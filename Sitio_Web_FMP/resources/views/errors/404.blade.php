@extends('errors::illustrated-layout')

@section('code', '404')
@section('title', __('Página no encontrada'))

{{-- @section('image')
<style>
    #apartado-derecho{
        text-align:center;
    }
    ul{
        text-decoration: none !important;
        list-style: none;
        color: black;
        font-weight: bold;
    }
</style>
<div id="apartado-derecho" style="background-color: #AA0000;" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    <h2 class="lead text-white">Encuentra lo que buscas en nuestro menú:</h2>
    <ul>
        <li><a href="/">Inicio</a></li>
    </ul>
</div>
@endsection --}}
@section('message', __('Lo sentimos, no se pudo encontrar la página que estás buscando.'))
