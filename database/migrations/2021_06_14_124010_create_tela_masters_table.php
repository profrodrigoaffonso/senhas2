<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelaMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tela_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('senha_id')->nullable();
            $table->integer('guiche_id')->nullable();
            $table->enum('som', ['s', 'n'])->default('n');
            $table->timestamps();
        });

        DB::table('tela_masters')->insert([
            'som' => 'n'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tela_masters');
    }
}
