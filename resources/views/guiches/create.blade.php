@extends('layouts.admin')

@section('content')
<form action="{{ route('guiches.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="exampleInputEmail1">Nome</label>
      <input type="text" class="form-control" id="nome" name="nome" required>
      @if($errors->has('codigo'))
      Digite o código
      @endif
    </div>
    
    <button type="submit" class="btn btn-primary">Salvar</button>
  </form>
@endsection