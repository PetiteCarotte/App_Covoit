<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseMilitairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_militaires', function (Blueprint $table) {
            $table->id('id_base_militaire'); // Définir la clé primaire
            $table->string('nom_de_la_base');
            $table->string('nom_de_la_commune');
            $table->string('acronyme');
            $table->string('code_postal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('base_militaires');
    }
}
