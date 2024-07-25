<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communes', function (Blueprint $table) {
            $table->string('code_commune_insee')->primary(); // Définir la clé primaire
            $table->string('nom_de_la_commune');
            $table->string('code_postal');
            $table->string('libelle_d_acheminement');
            $table->timestamps();

            // Ajout des index sur les colonnes 'nom_de_la_commune' et 'code_postal'
            $table->index('nom_de_la_commune');
            $table->index('code_postal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communes');
    }
}
