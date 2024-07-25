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
        Schema::create('jours', function (Blueprint $table) {
            $table->id('id_jours');
            $table->boolean('lundi');
            $table->boolean('mardi');
            $table->boolean('mercredi');
            $table->boolean('jeudi');
            $table->boolean('vendredi');
            $table->boolean('samedi');
            $table->boolean('dimanche');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jours');
    }
};
