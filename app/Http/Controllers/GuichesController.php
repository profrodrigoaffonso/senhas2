<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Models\Guiches;

class GuichesController extends Controller
{

    public function index(){

        $guiches = Guiches::get();
    
        return view('guiches.index', compact('guiches'));

    }

    public function create(){

        // die('kk');
        return view('guiches.create');

    }

    public function store(Request $request){

        //  die('aqui');

        $dados = $request->all();

        Guiches::create($dados);

        return redirect(route('guiches.index'));

    }

    public function edit($id){

        //  die('aqui');
        $guiche = Guiches::findOrFail($id);
        // dd($guiche);
        return view('guiches.edit', compact('guiche'));

    }

    public function update(Request $request){


        $dados = $request->all();

        $guiche = Guiches::findOrFail($dados['id']);

        $guiche->update([
            'nome' => $dados['nome']
        ]);

        return redirect(route('guiches.index'));

       

    }
}
