<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Senhas;
use App\Models\Chamadas;
use App\Models\TelaMaster;
use App\Models\Configs;

use Illuminate\Support\Facades\DB;

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
            ->limit(5)
            ->get();

        // dd($chamadas);

        
        return view('tela.anteriores', compact('chamadas'));

    }

    public function atual(){

        $telaMaster = Chamadas::select('chamadas.id AS chamada_id', 'senhas.senha', 'guiches.nome', 'chamadas.som')
            ->join('senhas','chamadas.senha_id', '=', 'senhas.id')
            ->join('guiches','chamadas.guiche_id', '=', 'guiches.id')
            ->where('exibe_master', 's')
            ->first();
        
        if($telaMaster){
            // dd($telaMaster->chamada_id);
            // $telaMaster->update([
            //     'exibe_master' => 'n'
            // ]);

            $tabela = Chamadas::findOrFail($telaMaster->chamada_id);

            // dd($tabela); 

            $tabela->update([
                'exibe_master' => 'n'
            ]);

            //dd('jjj');

            $som = $telaMaster->som;

            if($som == 's'){
                $tabela->update([
                    'som' => 'n'
                ]);               
            }

        } else {
            $telaMaster = TelaMaster::select()
                ->join('senhas','tela_masters.senha_id', '=', 'senhas.id')
                ->join('guiches','tela_masters.guiche_id', '=', 'guiches.id')
                ->where('tela_masters.id', 1)
                ->first();

            // dd($telaMaster);

            $som = $telaMaster['som'];

            if($som == 's'){
                $telaMaster->update([
                    'som' => 'n'
                ]);
            }
        }

        $tabela = TelaMaster::findOrFail(1);

        $tabela->update([
            'som' => 'n'
        ]);


        //echo $som;

        return view('tela.atual', compact('telaMaster', 'som'));
    }


}
