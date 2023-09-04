@extends('template')

@section('title', 'Archive - Employé')

@section('content')

<div class="container-fluid" style="">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <h2 class="mt-4" style="text-align: center"><i class="bi bi-clock-history"></i> Historique de {{$nom_complet->Nom}} {{$nom_complet->Prenom}}</h2>
        </div>
    </div>
</div>
<br>

<div class="col-lg-6 container">
    @foreach ($old_salles as $salle)
    <li style="margin-bottom: 5px;" class="list-group-item list-group-item-warning">Travaillé(e) dans la salle <strong>{{ $salle->NumeroSalle }}</strong> entre
        <strong>{{ \Carbon\Carbon::parse($salle->DateRejoindre)->format('d/m/Y') }}</strong> et 
        <strong>{{ \Carbon\Carbon::parse($salle->DateDepart)->format('d/m/Y') }}</strong> - 
        <i>{{\Carbon\Carbon::parse($salle->DateRejoindre)->diffInDays(\Carbon\Carbon::parse($salle->DateDepart)) }}
             jour(s)
        </i>
    </li>
    @endforeach
    <br>
    <div style="justify-content: center; display: flex;">
        <a class="btn btn-outline-primary" href="{{ url()->previous() }}"><i class="fas fa-angle-double-left"></i>
            Retourner</a>
    
    </div>
    
</div>


@endsection