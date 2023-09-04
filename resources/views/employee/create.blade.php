@extends('template')

@section('title', 'Employés - Création')

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;">Ajouter un Employé</h2>
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

    <form action="{{ route('employee.store') }}" method="POST">
        @csrf

        <div class="container" style="width: 700px;">
            <div class="row">
                <div class="mb-3">

                    <label for="nom" class="form-label"><strong>Nom:</strong></label>
                    <input type="text" id="nom" name="Nom" class="form-control" placeholder="Nom...">

                </div>
                <div class="mb-3">

                    <label for="nom" class="form-label"><strong>Prénom:</strong></label>
                    <input type="text" id="nom" name="Prenom" class="form-control" placeholder="Prénom...">

                </div>
                <div class="mb-3">

                    <label for="tele" class="form-label"><strong>Téléphone:</strong></label>
                    <input type="number" id="tele" name="Telephone" class="form-control" placeholder="Telephone...">

                </div>
                <div class="mb-3">

                    <label for="fonction" class="form-label"><strong>Fonction:</strong></label>
                    <input type="text" id="fonction" name="Fonction" class="form-control" placeholder="Fonction...">

                </div>
                <div class="mb-3">

                    <label for="salle" class="form-label"><strong>Salle du travail:</strong></label>
                    {{-- <input type="text" id="salle" name="SalleActuelle" class="form-control"
                        placeholder="Numéro la salle..."> --}}
                        <select class="form-select" id="salle" aria-label="Default select example" name="SalleActuelle">
                            <option selected disabled>--Choisir la salle--</option>
                            @foreach($salles as $salle)
                                <option value="{{$salle->Numero}}">{{$salle->Nom}}</option>
                            @endforeach
                        </select>

                </div>
                <div class="mb-3">

                    <label for="adresse" class="form-label"><strong>Adresse:</strong></label>
                    <input type="text" id="adresse" name="Adresse" class="form-control" placeholder="Adresse...">

                </div>
                <div class="mb-3">

                    <label for="nppr" class="form-label"><strong>Numéro PPR:</strong></label>
                    <input type="text" maxlength="4" id="nppr" name="NumeroPPR" class="form-control" placeholder="Numéro PPR...">

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <br>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <a class="btn btn-outline-primary" href="{{ URL::to('/employee') }}"><i
                            class="fas fa-angle-double-left"></i> Retourner</a>
                </div>
            </div>
        </div>


    </form>

<br><br>
@endsection
