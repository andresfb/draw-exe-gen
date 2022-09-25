<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
        });

        $this->seed();
    }

    public function down()
    {
        Schema::dropIfExists('tools');
    }

    private function seed()
    {
        DB::table('tools')->insert(['name' => 'Pencil']);
        DB::table('tools')->insert(['name' => 'Pen']);
        DB::table('tools')->insert(['name' => 'Charcoal']);
        DB::table('tools')->insert(['name' => 'Hard Brush']);
        DB::table('tools')->insert(['name' => 'Soft Brush']);
        DB::table('tools')->insert(['name' => 'Color Pencil']);
        DB::table('tools')->insert(['name' => 'Marker (Sharpie)']);
        DB::table('tools')->insert(['name' => 'Fat Marker']);
        DB::table('tools')->insert(['name' => 'Alcohol Markers']);
    }
};
