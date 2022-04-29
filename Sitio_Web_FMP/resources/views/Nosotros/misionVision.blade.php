@extends('Pagina/baseOnlyHtml')

@section('container')
<div class="wrapper">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="page-title-box color-boton py-2 rounded">
            <h2 class="page-title text-white">Facultad Multidisciplinaria Paracentral</h2>
        </div> 
        <div class="my-4"></div>
        <!-- end page title -->           

        <div class="row">
            <div class="col-xl-6">
                <div class="card-box" style="height: 20em"> 
                    <h3 class="text-center">Misión</h3>
                    <p class="text-justify">Ser líder en el campo de la educación superior universitaria; reconocida por la calidad humana, científica y técnica; promotora de valores éticos; con infraestructura y equipo adecuado; un presupuesto que garantice el funcionamiento eficiente y una oferta académica pertinente para el desarrollo humano integral de la Región Paracentral y de la nación.</p>
                </div> <!-- end card-box -->
            </div><!-- end col -->      
            <div class="col-xl-6" >
                <div class="card-box " style="height: 20em"> 
                    <h3 class="text-center">Visión</h3>
                    <p class="text-justify" >Somos una institución de educación superior de carácter público; formadora de profesionales de grado y postgrado en diferentes áreas del saber; generadora de conocimientos científicos, tecnológicos y humanistas; comprometida con el desarrollo humano sostenible en la Región Paracentral de El Salvador.</p>
                </div> <!-- end card-box -->
            </div><!-- end col -->      
        </div>
    </div> <!-- end container -->
</div> 
@endsection