<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Senhas;
use App\Models\Chamadas;
use App\Models\TelaMaster;

class TelaController extends Controller
{
    //

    public function chamar($guiche_id){

        $senha = Senhas::select()
            ->where('em_uso', 'n')
            ->orderBy('id', 'ASC')
            ->first();

        $dados = [
            'senha_id' => $senha->id,
            'guiche_id' => $guiche_id
        ];

        Chamadas::create($dados);

        $telaMaster = TelaMaster::findOrFail(1);

        $telaMaster->update([
            'senha_id' => $senha->id,
            'guiche_id' => $guiche_id,
            'som' => 's'
        ]);

        $senha->update([
            'em_uso' => 's'
        ]);        


        die();

    }

    public function repetir($guiche_id){

        $chamada = Chamadas::select('senha_id')
            ->where('guiche_id', $guiche_id)
            ->orderBy('id', 'DESC')
            ->first();
        
        $telaMaster = TelaMaster::findOrFail(1);

        $telaMaster->update([
            'senha_id' => $chamada->senha_id,
            'guiche_id' => $guiche_id,
            'som' => 's'
        ]);

        die();
    }

    function anteriores(){

        $chamadas = Chamadas::select('*')
            ->orderBy('id', 'DESC')
            ->get();
        
        foreach($chamadas as $chamada){
            
        }

        //dd($chamadas);
    }


}
