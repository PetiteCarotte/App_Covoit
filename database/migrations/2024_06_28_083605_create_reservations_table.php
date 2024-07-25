<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->foreignId('id_passager')->constrained('users', 'id'); // Clé étrangère vers la table users
            $table->foreignId('id_trajet')->constrained('trajets', 'id'); // Clé étrangère vers la table trajets
            $table->integer('qte_bagages_demandee');
            $table->integer('nbr_places_demande');
            $table->string('commentaire')->nullable();
            $table->timestamp('date_reservation');
            $table->enum('statut', ['En attente', 'Accepté', 'Refusé']);
            $table->timestamps();

            $table->primary(['id_passager', 'id_trajet']); // Définir une clé primaire composite
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
