@extends('backend/main')
@section('title', 'Registro')
@section('content')
    <body>
        <form method="post" action="{{ route('logged') }}">
        {{ csrf_field() }}
            <div class="form-group">
                <label for="inputEmail">Correo electrónico</label>
                <input name='email' type="email" class="form-control" id="inputEmail" placeholder="Entra tu correo electrónico">
            </div>
            <div class="form-group">
                <label for="inputToken">Token</label>
                <input name='token' type="text" class="form-control" id="inputToken" placeholder="Entra tu token">
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>
        <div>
            <label>Si no tienes creada una cuenta:</label>
            <a href="{{ route('registerCompany') }}">Regístrate</a>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        
        @if(isset($errors) && sizeof($errors)>0)
            <div class='alert alert-danger'>
                <ul class='list-group'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </body>
@endsection