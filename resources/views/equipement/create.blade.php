@extends('template')

@section('title', 'Equipement - Création')

@section('content')


<div class="container-fluid">
<div class="row">
    <div class="col-lg-12 margin-tb">
            <h2 class="mt-4" style="text-align: center;">Ajouter un Equipement</h2>
    </div>
</div>
</div>

 
@if ($errors->any())
 <div class="alert alert-danger">
 <strong>Whoops!</strong> Il y'en a des problèmes avec vos entrèes!<br><br>
 <ul>
 @foreach ($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
@endif

@if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p><i class="bi bi-x-octagon-fill"></i> {{ $message }}</p>
        </div>
    @endif
 
<br>
<form action="{{route('equipement.store')}}" method="POST">
 @csrf
 
<div class="container" style="width: 700px;">
    <div class="row">
        <div class="mb-3">
                
                <label for="option-select" class="form-label"><strong>Le type d'équipement:</strong></label>
                <select class="form-select" aria-label="Default select example" name="Type" id="option-select">
                    <option selected disabled>--Choisir le type--</option>
                    <option value="Imprimante">Imprimante</option>
                    <option value="Ordinateur">Ordinateur</option>
                    <option value="Ecran">Ecran</option>
                    <option value="Scanner">Scanner</option>
                    <option value="Chaise">Chaise</option>
                    <option value="Bureau">Bureau</option>
                    <option value="Paquet de Papiers">Paquet de Papiers</option>
                    <option value="Telephone Fixe">Telephone Fixe</option>
                    <option value="Désinfectants Hydroalcoolique">Désinfectants Hydroalcoolique</option>
                    <option value="Bavettes">Bavettes</option>
                </select>

        </div>

        <div class="mb-3">
                
                    <label for="modele" class="form-label"><strong>Le modèle:</strong></label>
                    <input type="text" name="Modele" id="modele" class="form-control" placeholder="Modèle...">
                    
        </div>

        <div class="mb-3">
                <label for="details" class="form-label"><strong>Détails</strong></label>
                <textarea name="Details" class="form-control" id="details" rows="4" placeholder="Des notes (configuration, taille, prix...)"></textarea>
        </div>

        <div class="mb-3">
                <label for="quantité" class="form-label"><strong>La quantité de stock (facultative):</strong></label>
                <input type="number" id="quantité" min="0" step="1" class="form-control" name="Stock" placeholder="Valeur par défault = 0...">
                    
        </div>
      
        <div class="mb-3 text-center">
            <br>
            <button type="submit" class="btn btn-success">Enregistrer</button>
            <a class="btn btn-outline-primary" href="{{URL::to('/equipement')}}"><i class="fas fa-angle-double-left"></i> Retourner</a>
        </div>
    </div>
</div>
 
 
</form>


@endsection