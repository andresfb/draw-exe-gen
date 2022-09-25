<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exercises_tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')
                ->references('id')
                ->on('exercises');

            $table->foreignId('tool_id')
                ->references('id')
                ->on('tools');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercises_tools');
    }
};
