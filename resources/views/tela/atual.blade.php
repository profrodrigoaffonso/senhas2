<div class="row">
@if($som == 's')
    <audio autoplay="autoplay">
    <source src="/audio/bipe.mp3" type="audio/mp3" />
    seu navegador não suporta HTML5
    </audio>
@endif
{{ $telaMaster->senha }} {{ $telaMaster->nome }}
</div>