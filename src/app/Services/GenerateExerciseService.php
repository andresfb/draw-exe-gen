<?php

namespace App\Services;

use App\Dtos\Task;
use App\Models\Exercise;
use App\Models\Media;
use Exception;
use Illuminate\Support\Str;

class GenerateExerciseService
{
    /**
     * execute Method.
     *
     * @return Task
     * @throws Exception
     */
    public function execute(): Task
    {
        $exercise = Exercise::random();
        if (empty($exercise)) {
            throw new Exception("No Exercise found");
        }

        $task = Task::create()
            ->setTitle($exercise->title)
            ->setSubTitle($exercise->sub_title ?? '')
            ->setDescription($exercise->description)
            ->setVideo($exercise->video_link);

        $reps = $exercise->min_repetitions;
        if ($exercise->is_rangable) {
            $reps = mt_rand($exercise->min_repetitions, $exercise->max_repetitions);
        }

        $repetitions = sprintf(
            "%s %s",
            $reps,
            ngettext($exercise->repetitions_type, Str::plural($exercise->repetitions_type), $reps)
        );

        $task->setRepetitions($repetitions);
        $media = $exercise->getMedia('samples');

        /** @var Media $image */
        foreach ($media as $image) {
            $task->setSamples($image->getUrl());
        }

        $task->setTool($exercise->tools()->inRandomOrder()->first()->name);
        return $task;
    }
}
