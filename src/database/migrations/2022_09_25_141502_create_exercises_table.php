<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('sub_title', 100)->nullable();
            $table->text('description');
            $table->string('repetitions_type', 20)->default('page');
            $table->tinyInteger('min_repetitions')->default(1);
            $table->tinyInteger('max_repetitions')->default(3);
            $table->boolean('is_rangable')->default(false);
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercises');
    }
};
