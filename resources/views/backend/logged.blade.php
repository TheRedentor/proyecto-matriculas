@extends('backend/main')
@section('title', 'Registro')
@section('content')
    <body>
        <h1>Aquí tienes tu token para acceder a nuestros servicios</h1>
        <h6>{{ $api_token }}</h6>
    </body>
@endsection