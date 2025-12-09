<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
          Schema::create('turistic_place', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slogan');
            $table->string('cover');
            $table->string('description');
            $table->string('localization');
            $table->string('Weather');
            $table->string('Weather_img');
            $table->string('flora');
            $table->string('flora_img');
            $table->string('estructure');
            $table->string('estructure_img');
            $table->string('tips');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

         

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
