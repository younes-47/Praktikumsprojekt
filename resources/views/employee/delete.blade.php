@extends('template')

@section('title', 'Employee - Suppression!')

@section('content')

<div class="container-fluid">
<div class="row">
    <div class="col-lg-12 margin-tb">
            <h2 class="mt-4" style="text-align: center;">Voulez vous supprimer les données de <strong>{{$em->Nom}} {{$em->Prenom}}</strong>?</h2>
    </div>
</div>
</div>
<br>

<div class="container" style="width: 600px;">
<div class="alert alert-danger" role="alert">
    <ul>
           <li>Les données concernant cet employé seront archivés.</li>
           <li>les enregistrements contenant les déplacements de cet employé dans les salles avec leurs dates restent accessibles dans l'archive</li>
     </ul>
 </div>
 <form action="{{ route ('employee.destroy', $em->id) }}" method="POST">
     <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <a class="btn btn-secondary" href="{{URL::to('/employee')}}">Annuler</a>
         @csrf
         @method('delete')
         <button type="sumbit" class="btn btn-danger">Supprimer</button>
     </div>
                                
</form>
</div>

@endsection