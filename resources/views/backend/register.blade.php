@extends('backend/main')
@section('title', 'Registro')
@section('content')
    <body>
        <form method="post" action="{{ route('registered') }}">
        {{ csrf_field() }}
            <div class="form-group">
                <label for="inputName">Nombre de tu compañia</label>
                <input name='name' type="text" class="form-control" id="inputName" placeholder="Entra el nombre de tu compañia">
            </div>
            <div class="form-group">
                <label for="inputEmail">Correo electrónico</label>
                <input name='email' type="email" class="form-control" id="inputEmail" placeholder="Entra un correo electrónico">
            </div>
            <div class="form-group">
                <label for="inputMode">Modo de tu cuenta</label>
                <select name='mode' type="number" class="form-control" id="inputMode">
                    @foreach($modes as $mode)
                        @if($mode->name == "Sin cache")
                        <option value={{ $mode->id }} selected>{{ $mode->name }}</option>
                        @else
                        <option value={{ $mode->id }}>{{ $mode->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        <div>
            <label>Si ya tienes creada una cuenta:</label>
            <a href="{{ route('login') }}">Inicia sesión</a>
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
