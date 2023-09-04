@extends('template')

@section('title', 'Employé - Détails')

@section('content')




    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;">Details</h2>
            </div>
        </div>
    </div>
    <br>




    <div class="container" style="width: 600px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; padding: 30px">

        <dl class="dl-horizontal">
            <dt>Numéro identifiant:</dt>
            <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->id }}</dd>

            <dt>Nom Complet:</dt>
            <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->Nom }} {{ $employee->Prenom }}</dd>

            <dt>Numéro de Téléphone</dt>
            <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->Telephone }}</dd>

            <dt>L'adresse:</dt>
            <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->Adresse }}</dd>

            <dt>Fonction:</dt>
            <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->Fonction }}</dd>

            <dt>La salle du travail:<a href="#" class="link-warning" style="float: right;" data-toggle="modal"
                    data-target="#historique"><i class="bi bi-clock-history"></i> Historique</a></dt>
            <dd class="list-group-item" style="border-radius: 1rem;">{{ App\Models\Salle::where('Numero',$salleActuelle->NumeroSalle)->get('*')->first()->Nom  }}</dd>

            <dt>Le numéro PPR:</dt>
            <dd class="list-group-item" style="border-radius: 1rem;">{{ $employee->NumeroPPR }}</dd>

        </dl>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <br>
        <a class="btn btn-outline-primary" href="{{ url()->previous() }}"><i class="fas fa-angle-double-left"></i>
            Retourner</a>
    </div>

    <br><br>
    
    <div class="modal fade" id="historique" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Historique</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <li class="list-group-item list-group-item-primary">Travaille dans la salle <strong>{{ $salleActuelle->NumeroSalle }}</strong> depuis
                            <strong>{{ \Carbon\Carbon::parse($salleActuelle->DateRejoindre)->format('d/m/Y') }}</strong> - 
                            <i>{{\Carbon\Carbon::parse($salleActuelle->DateRejoindre)->diffInDays(\Carbon\Carbon::now()) }} jour(s)</i>
                        </li>


                            <br>
                            @foreach ($old_salles as $salle)
                            <li class="list-group-item list-group-item-warning">Travaillé(e) dans la salle <strong>{{ $salle->NumeroSalle }}</strong> entre
                                <strong>{{ \Carbon\Carbon::parse($salle->DateRejoindre)->format('d/m/Y') }}</strong> et 
                                <strong>{{ \Carbon\Carbon::parse($salle->DateDepart)->format('d/m/Y') }}</strong> - 
                                <i>{{\Carbon\Carbon::parse($salle->DateRejoindre)->diffInDays(\Carbon\Carbon::parse($salle->DateDepart)) }}
                                     jour(s)
                                </i>
                            </li>
                            @endforeach
 
                        
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>



@endsection
