@extends('template')

@section('title', 'Liste des Salles')

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;">Les salles</h2>
            </div>
        </div>
    </div>
    <br>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p><i class="bi bi-check-circle-fill"></i> {{ $message }}</p>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p><i class="bi bi-x-octagon-fill"></i> {{ $message }}</p>
        </div>
    @endif

    <div class="container">
        <a class="btn btn-success" href="{{ route('salle.create') }}"><i class="bi bi-plus-circle-fill"></i> Nouvelle salle
        </a>

        <br>
        <p></p>

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered myTable" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 10%">Numéro</th>
                                <th style="width: 25%">Nom</th>
                                <th>#Employés</th>
                                <th>#Equipements</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salles as $salle)
                                <tr>
                                    <td>{{ $salle->Numero }}</td>
                                    <td>{{ $salle->Nom }}</td>
                                    @php
                                        $employees = App\Models\Correlation::where('DateDepart', '=', null)
                                            ->where('NumeroSalle', $salle->Numero)
                                            ->get('*');
                                        $equipements = App\Models\Eqcorrelation::select('Modele')
                                            ->where('Date_deplacement', null)
                                            ->where('Quantite_deplacee', 0)
                                            ->where('ID_emplacement', '=', $salle->Numero)
                                            ->where('Etat', null)
                                            ->groupby('Modele')
                                            ->get();
                                        
                                    @endphp

                                    <td>{{ $employees->count() }}</td>
                                    <td>{{ $equipements->count() }}</td>
                                    <td>

                                        <a class="btn btn-info" href="{{ route('salle.show', $salle->id) }}"><i
                                                class="fas fa-eye"></i></a>
                                        <a class="btn btn-warning" href="{{ route('salle.edit', $salle->id) }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="btn btn-danger" href="{{ route('salle.supprimer', $salle) }}"><i
                                                class="fas fa-trash-alt"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
