<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Senhas;
use App\Models\Chamadas;
use App\Models\TelaMaster;
use App\Models\Configs;

class TelaController extends Controller
{
    //

    public function master(){

        $config = Configs::findOrFail(1);

        return view('tela.master', compact('config'));
    }


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

        $chamadas = Chamadas::select('senhas.senha', 'guiches.nome')
            ->join('senhas','chamadas.senha_id', '=', 'senhas.id')
            ->join('guiches','chamadas.guiche_id', '=', 'guiches.id')
            ->orderBy('chamadas.id', 'DESC')
            ->get();

        // dd($chamadas);

        
        return view('tela.anteriores', compact('chamadas'));

    }

    public function exibeMaster(){

        $telaMaster = Chamadas::select('chamadas.id chamada_id', 'senhas.senha', 'guiches.nome')
            ->join('senhas','chamadas.senha_id', '=', 'senhas.id')
            ->join('guiches','chamadas.guiche_id', '=', 'guiches.id')
            ->where('exibe_master', 's')
            ->first()
            ->get();
        
        if($telaMaster){


        }
    }


}
