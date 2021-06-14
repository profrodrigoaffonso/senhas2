@extends('layouts.master')

@section('content')
<div id="anteriores"></div>
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