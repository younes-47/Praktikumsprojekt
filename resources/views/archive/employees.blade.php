@extends('template')

@section('title', 'Archive - Employés')

@section('content')



    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;"><i class="bi bi-archive"></i>&nbsp; L'archive des employés</h2>
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
        <!-- table -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered myTable" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom complet</th>
                                <th>Telephone</th>
                                <th style="width: 20%">Adresse</th>
                                <th style="width: 20%">Fonction</th>
                                <th style="width: 7%">N°PPR</th>
                                <th style="width: 25%">Actions</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($old_employees as $em)
                                <tr>
                                    <td>{{ $em->id }}</td>
                                    <td>{{ $em->Nom }} {{ $em->Prenom }}</td>
                                    <td>{{ $em->Telephone }}</td>
                                    <td>{{ $em->Adresse }}</td>
                                    <td>{{ $em->Fonction }}</td>
                                    <td>{{ $em->NumeroPPR }}</td>
                                    <td>
                                        <a href="{{ route('archive-employee', $em->id) }}" class="btn btn-warning" style="float: center;" ><i class="bi bi-clock-history"></i> Historique</a>
                                        <a href="{{ route('page-restauration-employe', $em->id) }}" class="btn btn-danger" style="float: center;" ><i class="fas fa-trash-restore"></i> Restaurer</a>
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
