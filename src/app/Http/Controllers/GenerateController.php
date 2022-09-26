<?php

namespace App\Http\Controllers;

use App\Services\GenerateExerciseService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class GenerateController extends Controller
{
    /**
     * __invoke Method.
     *
     * @param GenerateExerciseService $service
     * @return Application|Factory|View
     */
    public function __invoke(GenerateExerciseService $service)
    {
        try {
            $task = $service->execute();
            return view('generate', compact($task));
        } catch (Exception $ex) {
            return view('generate')->with('error', $ex->getMessage());
        }
    }
}
