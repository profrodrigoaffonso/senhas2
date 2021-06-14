<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSenhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senhas', function (Blueprint $table) {
            $table->id();
            $table->string('senha', 5);
            $table->enum('em_uso', ['s', 'n'])->default('n');
            $table->timestamps();
        });

        $data = date('Y-m-d H:i:s');

        $registros = [];

        for($i = 1; $i <= 99999; $i++){

            DB::table('senhas')->insert([
                'senha' => str_pad($i, 5, '0', STR_PAD_LEFT),
                'created_at' => $data,
                'updated_at' => $data
            ]);

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('senhas');
    }
}
