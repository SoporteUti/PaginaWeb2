@extends('Pagina/base-transparencia')

@section('container')
<div class="card-box margin-start">
    @include('Transparencia-web._components.search')
</div>
<div class="card-box text-center">
    <h3>Bienvenido a la Unidad de Acceso a la Información Pública </h3>
    <h4>Seleccione una de las siguientes categorias</h4>
    <hr>
    <div class="row button-list">
        <div class="col-12 col-sm-4">
            <div class="card border border-danger">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <i class="fa fa-pencil-ruler fa-5x text-danger"></i> <br>
                        <a href="{{ url('transparencia/marco-normativo') }}" class=" btn btn-link">
                            <h3 >Marco Normativo</h3>
                        </a>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card border border-danger">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <i class="fa fa-tools fa-5x text-danger"></i> <br>
                        <a href="{{ url('transparencia/marco-gestion') }}" class=" btn btn-link">
                            <h3>Marco de Gestión</h3>
                        </a>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4">
            <div class="card border border-danger">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <i class="fa fa-file-invoice-dollar fa-5x text-danger"></i> <br>
                        <a href="{{ url('transparencia/marco-presupuestario') }}" class=" btn btn-link">
                            <h3>Marco Presupuestario</h3>
                        </a>
                    </blockquote>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="card border border-danger">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <i class="fa fa-folder-open fa-5x text-danger"></i> <br>
                        <a href="{{ url('transparencia/repositorios') }}" class=" btn btn-link">
                            <h3>Repositorios</h3>
                        </a>
                    </blockquote>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="card border border-danger">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <i class="fa fa-file-pdf fa-5x text-danger"></i> <br>
                        <a href="{{ url('transparencia/documentos-JD') }}" class=" btn btn-link">
                            <h3>Documentos de Junta Directiva</h3>
                        </a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
@endsection



