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
        // configuracoes
        $config = Configs::findOrFail(1);
        return view('tela.master', compact('config'));
    }


    public function chamar($guiche_id){

        //seleciona a próxima senha disponível
        $senha = Senhas::select()
                ->where('em_uso', 'n')
                ->orderBy('id', 'ASC')
                ->first();

        $dados = [
            'senha_id' => $senha->id,
            'guiche_id' => $guiche_id
        ];

        // insere na tabela chamadas
        Chamadas::create($dados);

        $telaMaster = TelaMaster::findOrFail(1);
        // atualiza a tabela tela_masters
        $telaMaster->update([
            'senha_id' => $senha->id,
            'guiche_id' => $guiche_id,
            'som' => 's'
        ]);
        
        // atualiza a senha disponível para em uso
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

        // exibe as últimas 5 senhas chamadas
        $chamadas = Chamadas::select('senhas.senha', 'guiches.nome')
                    ->join('senhas','chamadas.senha_id', '=', 'senhas.id')
                    ->join('guiches','chamadas.guiche_id', '=', 'guiches.id')
                    ->orderBy('chamadas.id', 'DESC')
                    ->limit(5)
                    ->get();

        
        return view('tela.anteriores', compact('chamadas'));

    }

    public function atual(){

        // exibe na tela atual a última senha chamada e ou repetida

        // retorna a última senha chamada com a condição que não foi exibida na tela master
        $telaMaster = Chamadas::select('chamadas.id AS chamada_id', 'senhas.senha', 'guiches.nome', 'chamadas.som')
                    ->join('senhas','chamadas.senha_id', '=', 'senhas.id')
                    ->join('guiches','chamadas.guiche_id', '=', 'guiches.id')
                    ->where('exibe_master', 's')
                    ->first();
        
        if($telaMaster){ // se encontrada
         
            // atualiza o registro para não exibir mais
            $tabela = Chamadas::findOrFail($telaMaster->chamada_id);        

            $tabela->update([
                'exibe_master' => 'n'
            ]);            
            
            // altera o som para não para apenas executar uma vez
            $som = $telaMaster->som;
            if($som == 's'){
                $tabela->update([
                    'som' => 'n'
                ]);               
            }

        } else { // caso não encontre o registro na tabela chamadas, exibe o que está na tabela tela_masters
            $telaMaster = TelaMaster::select('senhas.senha', 'guiches.nome', 'tela_masters.som')
                        ->join('senhas','tela_masters.senha_id', '=', 'senhas.id')
                        ->join('guiches','tela_masters.guiche_id', '=', 'guiches.id')
                        ->where('tela_masters.id', 1)
                        ->first();

            // altera o som para não para apenas executar uma vez
            $som = $telaMaster['som'];
            if($som == 's'){
                $telaMaster->update([
                    'som' => 'n'
                ]);
            }
        }
        // altera o som para não para apenas executar uma vez
        $tabela = TelaMaster::findOrFail(1);
        $tabela->update([
            'som' => 'n'
        ]);

        return view('tela.atual', compact('telaMaster', 'som'));
    }


}
