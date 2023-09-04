@extends('template')

@section('title', 'Archive')

@section('content')




<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <h2 class="mt-4" style="text-align: center;"><i class="bi bi-archive"></i> Archive</h2>
            <h5 class="mt-4" style="text-align: center;">Toutes les employés et les équipements supprimés restent archivés</h5>
            <div class="h-100 d-flex align-items-center justify-content-center">
                <a class="btn btn-secondary" href="{{ URL::to('/archive/employes') }}" style="margin-right: 15px;"><i class="bi bi-archive-fill"></i> Employés</a>
                <a class="btn btn-secondary" href="{{ URL::to('/archive/equipements') }}" style="margin-right: 15px;"><i class="bi bi-archive-fill"></i> Equipements</a>
            </div>
        </div>
    </div>
</div>



@endsection