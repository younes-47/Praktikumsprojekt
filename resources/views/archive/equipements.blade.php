@extends('template')

@section('title', 'Archive - Equipements')

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;"><i class="bi bi-archive"></i>&nbsp; L'archive des équipements
                </h2>
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
                                <th style="width: 25%">Quantité Distribuée <br> (entre le dépôt et les salles)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($old_equipements as $eq)
                                <tr>
                                    <td>{{ $eq->id }}</td>
                                    <td>{{ $eq->Type }}</td>
                                    <td>{{ $eq->Modele }}</td>
                                    <td>{{ $eq->Details }}</td>
                                    <td>{{ $eq->qte_distribue }}</td>
                                    <td>
                                        <a href="{{ route('page-restauration-equipement', $eq->id) }}"
                                            class="btn btn-danger" style="float: center;">
                                            <i class="fas fa-trash-restore"></i> Restaurer</a>
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
