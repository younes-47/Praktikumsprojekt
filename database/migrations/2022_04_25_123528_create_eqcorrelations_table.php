<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEqcorrelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eqcorrelations', function (Blueprint $table) {
            $table->id();
            $table->integer('ID_emplacement')->default(0); // 0 pour depot, autre nombre pour numero de la salle
            $table->string('Type');
            $table->string('Modele');
            $table->integer('Quantite_actuelle');
            $table->integer('Quantite_ajoute');
            $table->integer('Quantite_deplacee');
            $table->timestamp('Date_ajout')->useCurrent();
            $table->timestamp('Date_deplacement')->nullable();
            $table->string('Etat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eqcorrelations');
    }
}
