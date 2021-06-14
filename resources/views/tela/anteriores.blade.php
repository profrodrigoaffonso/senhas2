<div class="row">
@foreach($chamadas as $chamada)
    <div class="col">{{ $chamada->senha}} - {{ $chamada->nome}}</div>
@endforeach
</div>