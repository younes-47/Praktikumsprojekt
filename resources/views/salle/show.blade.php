@extends('template')

@section('title', 'Salle - Détails')

@section('content')




    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;">Details</h2>
            </div>
        </div>
    </div>
    <br>




    <div class="container" style="width: 650px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; padding: 30px">

        <dl class="dl-horizontal">
            <dt>Le numéro de la salle:</dt>
            <dd class="list-group-item" style="border-radius: 1rem;">{{ $salle->Numero }}</dd>

            <dt>Le nom de la salle:</dt>
            <dd class="list-group-item" style="border-radius: 1rem;">{{ $salle->Nom }}</dd>

            <dt>Les employés:</dt>
            @if (0 != $employees->count())
                <table class="table table-bordered table-info">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Telephone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td><a href="/employee/{{ $employee->id }}"
                                        style="text-decoration: none; color: black;">{{ $employee->Nom }}
                                        {{ $employee->Prenom }}</a></td>
                                <td><a href="/employee/{{ $employee->id }}"
                                        style="text-decoration: none; color: black;">{{ $employee->Telephone }}</a></td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <dd class="list-group-item list-group-item-dark" style="border-radius: 1rem;">
                    <i>(Aucun employé travaille dans cette salle)</i>
                </dd>
            @endif

            <dt>Les équipements:</dt>
            @if ($equipements->count() != 0)
                <table class="table table-bordered table-primary">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Modele</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($equipements as $equipement)
                            @php
                                $eq_id = App\Models\Equipement::where('Modele', $equipement->Modele)
                                    ->where('Type', $equipement->Type)
                                    ->value('id');
                            @endphp
                            <tr>
                                <td><a href="/equipement/{{ $eq_id }}"
                                        style="text-decoration: none; color: black;">{{ $equipement->Type }}</a></td>
                                <td><a href="/equipement/{{ $eq_id }}"
                                        style="text-decoration: none; color: black;">{{ $equipement->Modele }}</a></td>
                                <td><a href="/equipement/{{ $eq_id }}"
                                        style="text-decoration: none; color: black;">{{ $equipement->Quantite_actuelle }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <dd class="list-group-item list-group-item-dark" style="border-radius: 1rem;">
                    <i>(Aucun équipement se trouve dans cette salle)</i>
                </dd>
            @endif

        </dl>

    </div>


    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <br>
        <a class="btn btn-outline-primary" href="{{ URL::to('/salle') }}"><i class="fas fa-angle-double-left"></i>
            Retourner</a>
    </div>





@endsection
