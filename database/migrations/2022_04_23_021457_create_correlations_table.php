<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correlations', function (Blueprint $table) {
            $table->id();
            $table->integer('NumeroSalle');
            $table->integer('IDEmployee');
            $table->timestamp('DateRejoindre')->useCurrent();
            $table->timestamp('DateDepart')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('correlations');
    }
}
