@extends('layouts.admin')

@section('content')


<div class="row">
    <div class="col-12 text-center pt-4">
        <img src="{{ asset('images/ues_logo3.svg') }}" style="filter: invert(25%);" class="img-responsive" alt="UES-FMP" width="35%" >
    </div>
</div>

@endsection

@section('plugins-js')
<!-- Dashboard Init JS -->
<script src="{{ asset('template-admin/dist/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
