@extends('template')

@section('title', 'Liste des Employés')

@section('content')


    <!-- title -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;">Les employés</h2>
            </div>
        </div>
    </div>
    <br>

    <!-- message success -->
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p><i class="bi bi-check-circle-fill"></i> {{ $message }}</p>
        </div>
    @endif

    <!-- bouton ajouter employee + search bar -->
    <div class="container">
        <a class="btn btn-success" href="{{ route('employee.create') }}"><i class="bi bi-plus-circle-fill"></i> Nouvel
            Employé </a>
        <br>
        <p></p>

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
                                <th style="width: 20%">Salle du Travail</th>
                                <th style="width: 7%">N°PPR</th>
                                <th style="width: 15%">Actions</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($employees as $em)
                                <tr>
                                    <td>{{ $em->id }}</td>
                                    <td>{{ $em->Nom }} {{ $em->Prenom }}</td>
                                    <td>{{ $em->Telephone }}</td>
                                    <td>{{ $em->Adresse }}</td>
                                    @php
                                        $salleActuelle = App\Models\Correlation::where('IDEmployee', $em->id)
                                            ->where('DateDepart', null)
                                            ->value('NumeroSalle');
                                        $nom_salle = App\Models\Salle::where('Numero',$salleActuelle)->get('*')->first();
                                    @endphp
                                    <td>{{ $nom_salle->Nom }}</td>
                                    <td>{{ $em->NumeroPPR }}</td>
                                    <td>


                                        <a class="btn btn-info" href="{{ route('employee.show', $em->id) }}"><i
                                                class="fas fa-eye"></i></a>
                                        <a class="btn btn-warning" href="{{ route('employee.edit', $em->id) }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a class="btn btn-danger" href="{{ route('employee.supprimer', $em) }}"><i
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
