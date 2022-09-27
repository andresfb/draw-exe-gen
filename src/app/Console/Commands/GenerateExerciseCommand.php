<?php

namespace App\Console\Commands;

use App\Services\GenerateExerciseService;
use Exception;
use Illuminate\Console\Command;

class GenerateExerciseCommand extends Command
{
    /** @var string */
    protected $signature = 'generate:exercise';

    /** @var string */
    protected $description = 'Generates a Random Drawing Exercise';

    /** @var GenerateExerciseService */
    private GenerateExerciseService $service;

    public function __construct(GenerateExerciseService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * handle Method.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $task = $this->service->execute();

            $this->table($task->getSamples(), $task);

            $this->newLine();
            $this->info("Done");
            return 0;
        } catch (Exception $e) {
            $this->error("\nError found:\n");
            $this->error($e->getMessage());
            $this->info("");
            return 1;
        }
    }
}
