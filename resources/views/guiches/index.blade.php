@extends('layouts.admin')

@section('content')
    <h1>Horários</h1>
    <p><a href="{{ route('guiches.create') }}">Novo</a></p>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Nome</th>
                <th></th>             
            </tr>
        </thead>
        <tbody>
            @foreach($guiches as $guiche)
            <tr>
                <td>{{ $guiche->nome }}</td>
                <td><a href="/guiches/{{ $guiche->id }}/edit">Editar</a></td>              
            </tr>
            @endforeach            
        </tbody>
    </table>
@endsection