@extends('template')

@section('title', 'Salle - Modification')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;">Modifier la salle N° {{ $salle->Numero }}</h2>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Il y'en a des problèmes avec vos entrèes!<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p><i class="bi bi-x-octagon-fill"></i> {{ $message }}</p>
        </div>
    @endif

    <form action="{{ route('salle.update', $salle) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="container" style="width: 700px;">
            <div class="row main-div">

                <div class="mb-3">

                    <label for="numero" class="form-label"><strong>Numero de la salle:</strong></label>
                    <input type="text" id="numero" name="Numero" class="form-control" value="{{ $salle->Numero }}"
                        placeholder="Numero...">

                </div>

                <div class="mb-3">

                    <label for="nom" class="form-label"><strong>Nom de la salle:</strong></label>
                    <input type="text" id="nom" name="Nom" class="form-control" value="{{ $salle->Nom }}"
                        placeholder="Nom...">

                </div>

                @if($equipements->count() != 0)
                <div class="mb-3">
                    <label for="equipements" class="form-label"><strong>Les équipements de la salle:</strong></label>
                    <p><i>(Si vous voulez supprimer un équipement mettez la
                        quantité 0)</i></p>
                    
                    @foreach ($equipements as $eq)
                        <div class="input-group">
                            <div class="col-md-5 mb-3" style="margin-right: 5px;">
                                <label for="type">Type</label>
                                <select class="form-select list-group-item-secondary" id="type" aria-label="Default select example" name="Type_old[]">
                                    <option value="{{ $eq->Type }}" >{{ $eq->Type }}</option>
                                </select>
                            </div>

                            {{-- njbdo qte li kayna f depot mn had equipement --}}
                            @php
                                $qte = App\Models\Eqcorrelation::orderby('Date_ajout','DESC')
                                ->where('Modele',$eq->Modele)->where('Type',$eq->Type)
                                ->where('ID_emplacement',0)->where('Quantite_deplacee', 0)->where('Etat',null)->get('*')->unique('Modele')->unique('ID_emplacement')->first();
                            @endphp


                            <div class="col-md-3 mb-3" style="margin-right: 5px; width: 230px;">
                                <label for="modele">Modèle</label>
                                <select class="form-select list-group-item-secondary" id="type" aria-label="Default select example" name="Modele_old[]">
                                    <option value="{{ $eq->Modele }}">{{ $eq->Modele }} <div class="text-success">(stock: {{ $qte->Quantite_actuelle }})</div></option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3" style="width: 150px;" >
                                <label for="quantité">Quantité (salle)</label>
                                <input type="number" id="quantité" min="0" class="form-control" name="Stock_old[]"
                                    value="{{ $eq->Quantite_actuelle }}">
                            </div>
                        </div>
                    
                    @endforeach
                </div>
                @endif
            </div>
                <label for="equipements" class="form-label"><strong>Ajouter des équipements à la salle:</strong></label>
                <button type="button" class="btn btn-success btn-ajouter" style="float: right;"><i
                        class="fa fa-plus"></i></button>


                <div class="form-row" id="equipements">



                    <div class="clone" style="display:none;">

                        <div class="duplicate">

                            <div class="input-group">
                                <div class="col-md-4 mb-3" style="margin-right: 15px;">
                                    <label for="type">Type</label>
                                    <select class="form-select" id="type" aria-label="Default select example"
                                        name="Type[]">
                                        <option selected disabled>--Choisir le type--</option>
                                        <option value="Imprimante">Imprimante</option>
                                        <option value="Ordinateur">Ordinateur</option>
                                        <option value="Ecran">Ecran</option>
                                        <option value="Scanner">Scanner</option>
                                        <option value="Chaise">Chaise</option>
                                        <option value="Bureau">Bureau</option>
                                        <option value="Paquet de Papiers">Paquet de Papiers</option>
                                        <option value="Telephone Fixe">Telephone Fixe</option>
                                        <option value="Désinfectants Hydroalcoolique">Désinfectants Hydroalcoolique</option>
                                        <option value="Bavettes">Bavettes</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3" style="margin-right: 15px;">
                                    <label for="modele">Modèle</label>
                                    <select class="form-select" id="modele" aria-label="Default select example" name="Modele[]">
                                        <option selected disabled>--Choisir le modèle--</option>
                                        @foreach($modeles as $mod)
                                            <option value="{{$mod->Modele}}">{{$mod->Modele}} <div class="text-success">(stock: {{$mod->Quantite_actuelle}})</div></option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 mb-3" style="margin-right: 15px;">
                                    <label for="quantité">Quantité</label>
                                    <input type="number" id="quantité" min="1" step="1" class="form-control"
                                        name="Stock[]" placeholder="min 1">
                                </div>
                                <div class="col mb-3" style="margin-top: 23px;">

                                    <button type="button" id="remove" class="btn btn-danger btn-supprimer"
                                        style="float: right;"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            

            <div class="mb-3 text-center">
                <br>
                <button type="submit" class="btn btn-success">Enregistrer</button>
                <a class="btn btn-outline-primary" href="{{ URL::to('/salle') }}"><i class="fas fa-angle-double-left"></i>
                    Retourner</a>
            </div>
        </div>
    </form>

    {{-- Les modèles dyal kola type --}}
@php
    $Imprimante = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Imprimante')->where('Etat',null)->get()->unique('Type');
    $Ordinateur = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Ordinateur')->where('Etat',null)->get()->unique('Type');
    $Ecran = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Ecran')->where('Etat',null)->get()->unique('Type');
    $Scanner = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Scanner')->where('Etat',null)->get()->unique('Type');
    $Chaise = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Chaise')->where('Etat',null)->get()->unique('Type');
    $Bureau = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Bureau')->where('Etat',null)->get()->unique('Type');
    $Paquet_de_Papiers = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Paquet de Papiers')->where('Etat',null)->get()->unique('Type');
    $Telephone_Fixe = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Telephone Fixe')->where('Etat',null)->get()->unique('Type');
    $Désinfectants_Hydroalcoolique = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Désinfectants Hydroalcoolique')->where('Etat',null)->get()->unique('Type');
    $Bavettes = App\Models\Eqcorrelation::select('Modele')->where('ID_emplacement',0)->where('Type', 'Bavettes')->where('Etat',null)->get()->unique('Type');
@endphp


    <script>
        function populate(type, modele)
        {
            var type = document.getElementById(type);
            var modele = document.getElementById(modele);
            
            modele.innerHTML = "";

            if(type.value == "Imprimante")
            {

            }
        }
    </script>




<script>
    $(document).ready(function() {
        $(".btn-ajouter").click(function() {
            var inputHtml = $(".clone").html();
            $(".main-div").after(inputHtml);
        })
    });

    $("body").on("click", ".btn-supprimer", function() {
        if(confirm('Voulez-vous vraiment supprimer cette équipement?')){
            $(this).parents(".duplicate").remove();
        };
    })
</script>

@endsection
