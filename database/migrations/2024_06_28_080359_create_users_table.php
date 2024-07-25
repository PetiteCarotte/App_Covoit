<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('firstname')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nid')->unique()->nullable();
            $table->string('unite')->nullable();
            $table->string('numero_de_poste')->nullable();
            $table->string('numero_de_telephone')->nullable();
            $table->string('password');
            $table->string('id_commune')->nullable();  // Ajout de cette ligne pour définir la colonne
            $table->foreign('id_commune')->references('code_commune_insee')->on('communes')->onDelete('restrict')->nullable();
            $table->unsignedBigInteger('id_base_militaire')->nullable();  // Ajout de cette ligne pour définir la colonne
            $table->foreign('id_base_militaire')->references('id_base_militaire')->on('base_militaires')->onDelete('restrict')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
}
