@extends('template')

@section('title', 'Salle - Suppression!')

@section('content')

<div class="container-fluid">
<div class="row">
    <div class="col-lg-12 margin-tb">
            <h2 class="mt-4" style="text-align: center;">Voulez vous supprimer la salle <strong>"{{$salle->Nom}}"</strong>?</h2>
    </div>
</div>
</div>
<br>

<div class="container" style="width: 600px;">
<div class="alert alert-danger" role="alert">
    <ul>
           <li>Cette action va supprimer toutes les données concernant cette salle.</li>
           <li>L'historique des équipements et des employés en correlation avec cette salle ne sera pas supprimer</li>
            <li>S'assurer que cette salle ne contient aucun employé et aucun équipement, sinon vous ne pouvez pas la supprimer.</li>
            <li>Si des employés se trouvent dans cette salle, veuillez les déplacer vers une autre salle ou les supprimer. Pour les équipements, 
                veuillez les retourner au dépôt ou les supprimer.</li>
     </ul>
 </div>
 <form action="{{ route ('salle.destroy', $salle->id) }}" method="POST">
     <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <a class="btn btn-secondary" href="{{URL::to('/salle')}}">Annuler</a>
         @csrf
         @method('delete')
         <button type="sumbit" class="btn btn-danger">Supprimer</button>
     </div>
                                
</form>
</div>


@endsection