@extends('template')

@section('title', 'Employés - Modification')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;">Modifier un employé</h2>
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

    <form action="{{ route('employee.update', $employee) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="container" style="width: 700px;">
            <div class="row">
                <div class="mb-3">

                    <label for="nom" class="form-label"><strong>Nom:</strong></label>
                    <input type="text" id="nom" name="Nom" class="form-control" value="{{ $employee->Nom }}"
                        placeholder="Nom...">

                </div>
                <div class="mb-3">

                    <label for="nom" class="form-label"><strong>Prénom:</strong></label>
                    <input type="text" id="nom" name="Prenom" class="form-control" value="{{ $employee->Prenom }}"
                        placeholder="Prénom...">

                </div>
                <div class="mb-3">

                    <label for="tele" class="form-label"><strong>Téléphone:</strong></label>
                    <input type="number" id="tele" name="Telephone" class="form-control"
                        value="{{ $employee->Telephone }}" placeholder="Telephone...">

                </div>
                <div class="mb-3">

                    <label for="fonction" class="form-label"><strong>Fonction:</strong></label>
                    <input type="text" id="fonction" name="Fonction" class="form-control"
                        value="{{ $employee->Fonction }}" placeholder="Fonction...">

                </div>
                <div class="mb-3">

                    <label for="salle" class="form-label"><strong>Salle du travail:</strong></label>
                    <select class="form-select" id="salle" aria-label="Default select example" name="SalleActuelle">
                        <option selected value="{{ $salleActuelle }}">{{ App\Models\Salle::where('Numero',$salleActuelle)->get('*')->first()->Nom }}</option>
                        @foreach ($salles as $salle)
                            @if ($salle->Numero == $salleActuelle)
                                @continue
                            @endif
                            <option value="{{ $salle->Numero }}">{{ $salle->Nom }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="mb-3">

                    <label for="adresse" class="form-label"><strong>Adresse:</strong></label>
                    <input type="text" id="adresse" name="Adresse" class="form-control"
                        value="{{ $employee->Adresse }}" placeholder="Adresse...">

                </div>
                <div class="mb-3">

                    <label for="nppr" class="form-label"><strong>Numéro PPR:</strong></label>
                    <input type="text" maxlength="4" id="nppr" name="NumeroPPR" class="form-control"
                        value="{{ $employee->NumeroPPR }}" placeholder="Numéro PPR...">

                </div>

                <div class="mb-3 text-center">
                    <br>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                    <a class="btn btn-outline-primary" href="{{ URL::to('/employee') }}"><i
                            class="fas fa-angle-double-left"></i> Retourner</a>
                </div>
            </div>
        </div>

    </form>

@endsection
