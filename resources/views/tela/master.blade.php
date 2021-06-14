@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col col-lg-6">teste</div>
    <div class="col col-lg-6"><iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $config->video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
</div>
<div class="row">
    <div id="anteriores"></div>
</div>
<script src="/js/jquery-3.6.0.min.js"></script>
<script>

    function atualizar(){
        // alert('aaa');
        $.get( "{{ route('tela.anteriores') }}", function( data ) {
            // alert(data)
            $('#anteriores').html(data)
            //alert( "Load was performed." );
        });
    }

    setInterval(function(){ 
        atualizar() 
    }, 3000);   
    
</script>
@endsection