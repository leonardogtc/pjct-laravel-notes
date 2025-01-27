@extends('layouts.main_layout')
@section('content')
    <h1>View and Brade!</h1>
    <br>
    {{--
        Esse recurso vem do Blade, é o duplo mustash.
        Essa notação substitui a instrução PHP do branch anterior.
        < ? = $value ? >
    --}}
    <h2>Página 3</h2>
    <h3>The value is: {{ $value }}</h3>

@endsection
