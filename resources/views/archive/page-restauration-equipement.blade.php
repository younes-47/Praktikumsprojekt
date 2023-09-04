@extends('template')

@section('title', 'Restaurer - Employé')

@section('content')


    <br>


    <div class="container" style="width: 650px">
        <form action="{{ route('restaurer-equipement', $equipement->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <h4 class="card-header link-danger text-center">Voulez vous restaurer cet équipement ?</h4>
                <div class="card-body">
                    <p class="card-title" style="font-size: 17px">Voici les informations qui vont être restaurés</p>

                    <dl class="dl-horizontal">

                        <dt>Le type :</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">{{ $equipement->Type }}</dd>
        
                        <dt>Le modèle :</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">{{ $equipement->Modele }}</dd>
        
                        <dt>Les détails :</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">{{ $equipement->Details }}</dd>
        
                        <dt>Quantité:</dt>
                        <dd class="list-group-item" style="border-radius: 1rem;">{{ $equipement->qte_distribue }}</dd>

                        <div class="alert alert-danger" role="alert">
                            <ul>
                                   <P>NB: 
                                        La quantité va être restauré directement dans le dépôt, vous pouvez ensuite la modifié
                                        ou l'ajouter dans les salles. 
                                    </P>
                             </ul>
                         </div>
                        
        
                    </dl>

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-restore"></i>
                            Restaurer</button>
                        <a class="btn btn-outline-secondary" href="{{ URL::to('/archive/equipements') }}"><i
                                class="fas fa-angle-double-left"></i> Retourner</a>
                    </div>

                </div>
            </div>
            

        </form>

    </div>

<br><br><br>



@endsection
