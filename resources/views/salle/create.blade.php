@extends('template')

@section('title', 'Salle - Création')

@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <h2 class="mt-4" style="text-align: center;">Ajouter une Salle</h2>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <p><i class="bi bi-x-octagon-fill"></i> {{ $error }}</p>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p><i class="bi bi-x-octagon-fill"></i> {{ $message }}</p>
        </div>
    @endif

    <form action="{{ route('salle.store') }}" method="POST" class="form-inline">
        @csrf

        <div class="container" style="width: 700px;">
            <div class="main-div">
                <div class="form-row">
                    <div class="mb-3">
                        <label for="numero" class="form-label"><strong>Le numéro de la salle:</strong></label>
                        <input type="number" id="numero" name="Numero" class="form-control" placeholder="Numéro...">
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="nom" class="form-label"><strong>Le nom de la salle:</strong></label>
                        <input type="text" id="nom" name="Nom" class="form-control" placeholder="Nom...">
                    </div>
                </div>
            </div>
            <br>
            <!-- <div style=" display: flex; justify-content: center; align-items: center;"><hr style="width: 400px;"></div> -->
            <label for="equipements" class="form-label"><strong>Des équipements:</strong></label>
            <button type="button" class="btn btn-success btn-ajouter" style="float: right;"><i
                    class="fa fa-plus"></i></button>


            <div class="form-row" id="equipements">



                <div class="clone" style="display:none;">

                    <div class="duplicate">

                        <div class="input-group">
                            <div class="col-md-4 mb-3" style="margin-right: 15px;">
                                <label for="type">Type</label>
                                <select class="form-select" id="type" aria-label="Default select example" name="Type[]">
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
                                <input type="number" id="quantité" min="1" step="1" class="form-control" name="Stock[]"
                                    placeholder="min 1">
                            </div>
                            <div class="col mb-3" style="margin-top: 23px;">

                                <button type="button" id="remove" class="btn btn-danger btn-supprimer"
                                    style="float: right;"><i class="fas fa-trash-alt"></i></button>
                            </div>
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
