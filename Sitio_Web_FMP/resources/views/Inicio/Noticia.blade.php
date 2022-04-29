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
            <div class="card-box col-xl-12">
                <a class="nav-link btn btn-danger waves-effect width-md" href="{{ route('index') }}#noticias">
                    <i class="mdi mdi-arrow-left-thick"></i> 
                    Volver a Noticias
                </a>
                <div class="row">
                    <div class="col-xl-12 ">
                        <h1 class="my-3">{!!$noticia->titulo!!} </h1>                                                   
                        <h3 class="my-2">{!!$noticia->subtitulo!!}</h3>
                        <p class="p-6">Publicado el {!!/*date('d M Y', strtotime())*/$noticia->created_at->translatedFormat('l d \d\e F \d\e\l Y')!!}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-5 order-first my-2">
                        <img src=" {{ asset('/images/noticias') }}/{!!$noticia->imagen!!}" 
                        alt="Imagen Noticia" height="300" class=" rounded bx-shadow-lg img-fluid">
                    </div>
                    <div class="col-xl-7 order-last">                        
                        <blockquote class="card-bodyquote mx-2"> 
                            <p class="text-justify ">
                                {!!$noticia->contenido!!}
                            </p>
                            @if ($noticia->fuente!=null and $noticia->urlfuente!=null)
                            <footer class="blockquote-footer text-muted"> 
                                Fuente: 
                                <a href="{!!$noticia->urlfuente!!}">
                                    {!!$noticia->fuente!!}
                                </a>
                            </footer>                                
                            @endif                            
                        </blockquote>  
                    </div>
                </div>
            </div>   
        </div>
    </div> <!-- end container -->
</div> 
@endsection