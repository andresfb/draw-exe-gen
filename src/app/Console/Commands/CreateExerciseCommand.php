<?php

namespace App\Console\Commands;

use App\Models\Exercise;
use App\Models\Tool;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CreateExerciseCommand extends Command
{
    /** @var string */
    protected $signature = 'create:exercise';

    /** @var string */
    protected $description = 'Data Entry command to create a new Exercise';

    /** @var Collection  */
    private Collection $tools;


    /**
     * handle Method.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $this->showList();

            $this->tools = Tool::select(['id', 'name'])
                ->orderBy('id')
                ->get();

            $continue = true;
            while ($continue) {
                $continue = $this->getAction();
            }

            return $this->done();
        } catch (Exception $e) {
            $this->error("\nError found:\n");
            $this->error($e->getMessage());
            $this->info("");
            return 1;
        }
    }

    /**
     * showList Method.
     *
     * @return void
     */
    private function showList(): void
    {
        $list = Exercise::select([
            "id",
            'title',
            'sub_title',
            \DB::raw(
                'CONCAT( SUBSTRING(`description`, 1, 110), IF(LENGTH(`description`) > 110, "...", ""))'
            )
        ])
        ->whereActive(true)
        ->get();

        if (!$list->count()) {
            $this->newLine();
            $this->warn("No exercies found");
            $this->newLine();
            return;
        }

        $headers = ['Id', 'Title', 'Sub Title', 'Description'];
        $this->table($headers, $list, "box-double");
    }

    /**
     * getAction Method.
     *
     * @return int
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    private function getAction(): int
    {
        $action = $this->choice(
            'What you want to do?',
            ['Add New', 'Edit', 'Quit'],
            0
        );

        $action = strtolower(trim($action));
        if ($action == 'quit') {
            return false;
        }

        if ($action == 'edit') {
            $this->edit();
            return true;
        }

        $this->add();
        return true;
    }

    /**
     * edit Method.
     *
     * @return void
     */
    private function edit(): void
    {
        // TODO: implement the edit method
    }

    /**
     * add Method.
     *
     * @return void
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    private function add(): void
    {
        $this->newLine();
        $this->warn("Create a new Exercise");
        $this->newLine();

        $data['title'] = $this->getValue('Title');

        $data['sub_title'] = $this->getValue("Sub Title", false);;

        $data['description'] = $this->getValue("Description");

        $data = $this->getRepetitions($data);

        $data['repetitions_type'] = $this->choice(
            'Repetitions Type',
            config('constants.repetition_types'),
            0
        );

        $tools = $this->getTools();

        $data['video_link'] = $this->getValue('Video Link', false);

        $samples = [];
        $continue = true;

        while ($continue) {
            $samples[] = $this->getSample();
            $continue = $this->confirm("Enter more samples?");
        }

        $exercise = Exercise::create($data);
        $exercise->tools()->attach($tools->pluck('id')->toArray());
        foreach ($samples as $sample) {
            $exercise->addMedia($sample)
                ->preservingOriginal()
                ->toMediaCollection('samples');
        }
    }

    /**
     * getTitle Method.
     *
     * @param string $field
     * @param bool $required
     * @return string
     */
    private function getValue(string $field, bool $required = true): string
    {
        $question = sprintf(
            "%s%s",
            $field,
            !$required ? ' (optional)' : ''
        );

        $value = $this->ask($question);
        $value = trim($value);
        if (!$required) {
            return $value;
        }

        if (empty($value)) {
            $this->newLine();
            $this->warn("Please enter a valid value");
            return $this->getValue($field);
        }

        return $value;
    }

    /**
     * getIntValue Method.
     *
     * @param string $field
     * @param bool $required
     * @return int
     */
    private function getIntValue(string $field, bool $required = true): int
    {
        $value = $this->getValue($field, $required);
        if (!empty($value) && !is_numeric($value)) {
            $this->newLine();
            $this->warn("Please enter a integer value");
            return $this->getIntValue($field, $required);
        }

        $value = (int) $value;
        if (!$required) {
            return $value;
        }

        if (empty($value)) {
            $this->newLine();
            $this->warn("Please enter a integer value");
            return $this->getIntValue($field, $required);
        }

        return $value;
    }

    /**
     * getRepetitions Method.
     *
     * @param array $data
     * @return array
     */
    private function getRepetitions(array $data): array
    {
        $data['min_repetitions'] = $this->getIntValue("Min. Repetitions");

        $data['max_repetitions'] = $this->getIntValue("Max. Repetitions", false);

        if ($data['max_repetitions'] > 0 && $data['min_repetitions'] >= $data['max_repetitions']) {
            $this->newLine();
            $this->warn("Please enter a valid repetition range");
            return $this->getRepetitions($data);
        }

        $data['is_rangable'] = $data['max_repetitions'] > 0;

        return $data;
    }

    /**
     * getSamples Method.
     *
     * @return string
     */
    private function getSample(): string
    {
        $sample = $this->getValue('Enter sample file path');
        if (!file_exists($sample)) {
            $this->newLine();
            $this->warn("File not found");
            return $this->getSample();
        }

        return $sample;
    }

    /**
     * getTools Method.
     *
     * @return Collection
     */
    private function getTools(): Collection
    {
        $options = [];
        /** @var Tool $tool */
        foreach ($this->tools as $tool) {
            $options[$tool->id] = $tool->name;
        }

        $options[count($options) + 1] = "All";
        $tools = $this->choice(
            'Select the usable tools',
            $options,
            count($options),
            null,
            true
        );

        if (in_array("All", $tools)) {
            return $this->tools;
        }

        return $this->tools->whereIn('name', $tools);
    }

    /**
     * done Method.
     *
     * @return int
     */
    private function done(): int
    {
        $this->newLine();
        $this->info("Done");
        $this->newLine();
        return 0;
    }
}
