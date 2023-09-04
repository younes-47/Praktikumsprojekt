@extends('template')

@section('title', 'Restaurer - Employé')

@section('content')


 

    <br>

    @if ($errors->any())
        <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <i class="bi bi-x-octagon-fill"></i> {{ $error }}
                @endforeach
        </div>
    @endif

    <div class="container" style="width: 800px">
        <form action="{{ route('restaurer-employe', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <h4 class="card-header link-danger text-center">Voulez vous restaurer cet employé ?</h4>
                <div class="card-body">
                    <p class="card-title" style="font-size: 17px">Voici les informations qui vont être restaurés</p>

                    <dl class="dl-horizontal">

                        <dt>Nom Complet:</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->Nom }} {{ $employee->Prenom }}
                        </dd>
        
                        <dt>Numéro de Téléphone</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->Telephone }}</dd>
        
                        <dt>L'adresse:</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->Adresse }}</dd>
        
                        <dt>Fonction:</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->Fonction }}</dd>
        
                        <dt>Le numéro PPR:</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->NumeroPPR }}</dd>
        
                        <dt class="link-danger">Veuillez choisir la salle où l'employé va travailler cette fois ci:</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">
                            <select class="form-select" id="salle" aria-label="Default select example" name="Salle_de_travaille">
                                <option selected disabled>--Choisir la salle--</option>
                                @foreach ($salles as $salle)
                                    <option value="{{ $salle->Numero }}">{{ $salle->Nom }}</option>
                                @endforeach
                            </select>
                        </dd>
        
                    </dl>

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-restore"></i>
                            Restaurer</button>
                        <a class="btn btn-outline-secondary" href="{{ URL::to('/archive/employes') }}"><i
                                class="fas fa-angle-double-left"></i> Retourner</a>
                    </div>

                </div>
            </div>
            

        </form>

    </div>

<br><br><br>



@endsection
