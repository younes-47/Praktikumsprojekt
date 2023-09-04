@extends('template')

@section('title', 'Equipement - Suppression!')

@section('content')

<div class="container-fluid">
<div class="row">
    <div class="col-lg-12 margin-tb">
            <h2 class="mt-4" style="text-align: center;">Voulez vous supprimer les données de cet équipement ?</h2>
            <h4 class="mt-4 alert alert-info" style="text-align: center;"><strong>{{$eq->Type}}</strong> modele: <strong>{{$eq->Modele}}</strong></h4>
    </div>
</div>
</div>
<br>

<div class="container" style="width: 600px;">
<div class="alert alert-danger" role="alert">
    <ul>
            <li>Les données concernant cet équipement seront archivés.</li>
            <li>Les enregistrements contenant les déplacements de cet équipement avec leurs dates ne seront pas supprimés.</li>
            <li>Les quantités de cet équipement qui se trouve dans les salles (s'elles existent) seront supprimée.</li>
     </ul>
 </div>
 <form action="{{ route ('equipement.destroy', $eq->id) }}" method="POST">
     <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <a class="btn btn-secondary" href="{{URL::to('/equipement')}}">Annuler</a>
         @csrf
         @method('delete')
         <button type="sumbit" class="btn btn-danger">Supprimer</button>
     </div>
                                
</form>
</div>


@endsection