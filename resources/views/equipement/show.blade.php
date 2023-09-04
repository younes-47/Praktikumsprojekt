@extends('template')

@section('title', 'Equipement - Détails')

@section('content')




<div class="container-fluid">
<div class="row">
    <div class="col-lg-12 margin-tb">
            <h2 class="mt-4" style="text-align: center;">Détails</h2>
    </div>
</div>
</div>
<br>




<div class="container" style="width: 600px; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; padding: 30px">

  <dl class="dl-horizontal">
    <dt>Le type d'equipement:</dt>
    <dd class="list-group-item" style="border-radius: 1rem;">{{ $equipement->Type }}</dd>

    <dt>Le modèle:</dt>
    <dd class="list-group-item" style="border-radius: 1rem;">{{ $equipement->Modele }}</dd>

    <dt>Détails:</dt>
    <dd class="list-group-item" style="border-radius: 1rem;">{{ $equipement->Details }}</dd>

    <dt>Stock disponible:</dt>
    @if($stock != 0)
    <dd class="list-group-item list-group-item-warning" style="border-radius: 1rem;">
              <div style="font-size: xx-large; text-align: center;
                vertical-align: middle;">
                {{ $stock }}

              </div>
      </dd>
      @else
      <dd class="list-group-item list-group-item-danger" style="border-radius: 1rem;">
        <div style="font-size: xx-large; text-align: center;
          vertical-align: middle;">

          stock épuisé

        </div>
    </dd>
    @endif

  <dt>les salles ayant cet équipement:</dt>
    @if($les_salles->count() != 0)
      @foreach ($les_salles as $salle)
      <dd class="list-group-item list-group-item-dark" style="border-radius: 1rem;">
        Salle <strong>{{ $salle->ID_emplacement }}</strong> avec <strong>{{ $salle->Quantite_actuelle }}</strong> unité(s)
      </dd>
      @endforeach
    @else
      <dd class="list-group-item list-group-item-dark" style="border-radius: 1rem;">
        <i>(Aucune salle)</i>
      </dd>
    @endif
  </dl>

  

</div>

<div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <br>
            <a class="btn btn-outline-primary" href="{{ url()->previous() }}"><i class="fas fa-angle-double-left"></i> Retourner</a>
</div>

<br>

@endsection