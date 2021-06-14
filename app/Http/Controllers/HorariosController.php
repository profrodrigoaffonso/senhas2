<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Horarios;
use App\Models\Comandos;


class HorariosController extends Controller
{

    public function index(){
        die('ll');
        $horarios = Horarios::get()
            ->where('tipo', 'h');    
        return view('horarios.index', compact('horarios'));
    }

    public function create(){
        return view('horarios.create');
    }

    public function store(Request $request){
        
        $dados = $request->all();

        $dados['data_hora'] = "{$dados['data']} {$dados['hora']}";

        Horarios::create($dados);

        return redirect(route('horarios.index'));


    }

    public function edit($id){

        $horario = Horarios::findOrFail($id);
    
        $horario['data'] = date('Y-m-d', strtotime($horario['data_hora']));
        $horario['hora'] = date('H:i', strtotime($horario['data_hora']));

        return view('horarios.edit', compact('horario'));
    }

    public function update(Request $request){

        $dados = $request->all();

        $horario = Horarios::findOrFail($dados['id']);

        $horario->update([
            'comando' => $dados['comando'],
            'data_hora' => "{$dados['data']} {$dados['hora']}"
        ]);

        return redirect(route('horarios.index'));

    }

    public function temporizador(){
        return view('horarios.temporizador');
    }

    public function temporizadorAlterar(Request $request){

        $dados = $request->all();
        
        $data_hora = date('Y-m-d H:i');

        $data_hora = date('Y-m-d H:i', strtotime('+ '.$dados['tempo'].'minutes', strtotime($data_hora)));

        $horario = Horarios::findOrFail(3);

        $horario->update([
            'comando' => $dados['comando'],
            'data_hora' => $data_hora
        ]);

        return redirect(route('horarios.temporizador'));

    }

    public function alterarComando(){
        $data_inicio = date('Y-m-d H:i:00');
        $data_fim = date('Y-m-d H:i:59');

        $horario = Horarios::select('comando')
            ->where('data_hora', $data_inicio)
            ->first();
        
        if($horario){
            $comando = Comandos::findOrFail(1);

            $comando->update([
                'comando' => $horario->comando,
                'executado' => 'n'
            ]);

        }
        
    }

}
