<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrajetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trajets', function (Blueprint $table) {
            $table->id('id'); 
            $table->date('date_depart')->nullable();
            $table->time('heure_depart');
            $table->integer('qte_bagages');
            $table->integer('nbr_places');
            $table->integer('qte_bagages_occupee')->nullable();
            $table->integer('nbr_places_occupe')->nullable();
            $table->string('description')->nullable(); 
            $table->boolean('trajet_regulier'); 
            $table->boolean('statut');
            $table->boolean('domicile_base');
            $table->foreignId('id_conducteur')->constrained('users', 'id')->onDelete('restrict'); // Clé étrangère vers la table users
            $table->string('id_commune')->nullable();  // Ajout de cette ligne pour définir la colonne
            $table->foreign('id_commune')->references('code_commune_insee')->on('communes')->onDelete('restrict');
            $table->foreignId('id_base_militaire')->constrained('base_militaires', 'id_base_militaire')->onDelete('restrict'); // Clé étrangère vers la table base_militaires
            $table->foreignId('id_jours')->nullable()->constrained('jours', 'id_jours')->onDelete('restrict'); // Clé étrangère vers la table jours
            // $table->foreignId('id_vehicule')->nullable()->constrained('vehicules'); // Clé étrangère vers la table vehicules
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
        Schema::dropIfExists('trajets');
    }
}
