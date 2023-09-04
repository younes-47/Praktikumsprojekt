@extends('template')

@section('title', 'Listes des Equipements')

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;">Les équipements</h2>
            </div>
        </div>
    </div>
    <br>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p><i class="bi bi-check-circle-fill"></i> {{ $message }}</p>
        </div>
    @endif


    <div class="container">
        <a class="btn btn-success" href="{{ route('equipement.create') }}"><i class="bi bi-plus-circle-fill"></i> Nouvel
            Equipement </a>
        <br>
        <p></p>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered myTable" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Modèle</th>
                                <th>Details</th>
                                <th style="width: 15%">Stock (dépôt)</th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipements as $eq)
                                <tr>
                                    <td>{{ $eq->id }}</td>
                                    <td>{{ $eq->Type }}</td>
                                    <td>{{ $eq->Modele }}</td>
                                    <td>{{ $eq->Details }}</td>
                                    @php
                                        $stock = App\Models\Eqcorrelation::orderby('Date_ajout', 'DESC')
                                            ->where('Date_deplacement', null)
                                            ->where('Modele', $eq->Modele)
                                            ->where('Type', $eq->Type)
                                            ->where('Quantite_deplacee', 0)
                                            ->where('ID_emplacement', 0)
                                            ->value('Quantite_actuelle');
                                    @endphp

                                    @if ($stock != null)
                                        <td style="color: green; text-align: center; font-size: large;">{{ $stock }}
                                        </td>
                                    @else
                                        <td style="color: red;">stock épuisé</td>
                                    @endif

                                    <td>


                                        <a class="btn btn-info" href="{{ route('equipement.show', $eq->id) }}"><i
                                                class="fas fa-eye"></i></a>
                                        <a class="btn btn-warning" href="{{ route('equipement.edit', $eq->id) }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="btn btn-danger" href="{{ route('equipement.supprimer', $eq) }}"><i
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
