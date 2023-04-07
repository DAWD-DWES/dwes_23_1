{{-- Usamos la vista app como plantilla --}}
@extends('app')
{{-- Sección aporta el título de la página --}}
@section('title', 'Puntuación Partidas')
@section('navbar')
<div class="container justify-content-around">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="juego.php">Volver</a>
        </li>
    </ul>
</div>
@endsection
{{-- Sección muestra puntuacion de las partidas --}}
@section('content')
<div class="container">
    <h1 class="my-5 text-center">Puntuación de partidas jugadas</h1>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Palabra</th>
                        <th scope="col">Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($panelPuntuacion))
                    @php $i=1; @endphp
                    @foreach($panelPuntuacion as $key => $partida)
                    <tr>
                        <td scope="row">{{ $i++ }}</td>
                        <td>{{ $partida[0] }}</td>
                        <td>{{ $partida[1] }}</td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td>No hay partidas</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>    
@endsection