<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>@yield('title')</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />

    {{-- Bootstrap icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">



    {{-- Bootstrap 5 --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    {{-- DatatTables Style --}}
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css">


    {{-- Jquery dyal li kaykhdm ajout dyal les équipements dynamiquement --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


</head>

<body>

    <!-- Nombre dyalhom yt2aficha f navbar -->
    @php
        $employees = App\Models\Employee::where('id', '>', -1)
            ->where('Etat', 'Actif')
            ->count();
        $equipements = App\Models\Equipement::where('id', '>', -1)
            ->where('Etat', null)
            ->count();
        $salles = App\Models\Salle::where('id', '>', -1)->count();
    @endphp


    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end sidebar bg-secondary bg-gradient " id="sidebar-wrapper">
            <a href="" style="text-decoration: none; color:black; text-align: center;">
                <div class="sidebar-heading border-bottom sidebar-header bg-secondary bg-gradient text-white"> <img
                        src="{{ asset('img/court.png') }}" width="30px" height="30px"
                        style="float: left; margin-left: 10px"> Cour d'appel</div>
            </a>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3 sidebar-items text-white bg-secondary bg-gradient"
                    href="{{ URL::to('/employee') }}">Les employés<span class="badge bg-info rounded-pill"
                        style="float: right;">{{ $employees }}</span></a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 sidebar-items text-white bg-secondary bg-gradient"
                    href="{{ URL::to('/equipement') }}">Les équipements<span class="badge bg-info rounded-pill"
                        style="float: right;">{{ $equipements }}</span></a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 sidebar-items text-white bg-secondary bg-gradient"
                    href="{{ URL::to('/salle') }}">Les salles<span class="badge bg-info rounded-pill"
                        style="float: right;">{{ $salles }}</span></a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3 sidebar-items text-white text-center"
                    style="background: linear-gradient(90deg, rgba(144,149,47,1) 11%, rgba(152,185,191,1) 100%);"
                    href="{{ URL::to('/archive') }}"><strong><i class="bi bi-archive"></i> Archive</strong></a>
            </div>
        </div>
        <!-- Top navigation-->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg bg-secondary bg-gradient navbar-light border-bottom header ">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle"><i class="bi bi-arrow-left-right"></i> Barre de
                        navigation</button>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span
                            class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            {{-- <li class="nav-item active "><a class="nav-link text-white"
                                    href="{{ URL::to('/accueil') }}">Accueil</a></li> --}}
                            <!-- <li class="nav-item"><a class="nav-link" href="#!">Link</a></li> -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                        class="fas fa-user text-white" style="font-size: large;"></i></a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- <a class="dropdown-item" href="#!">Action</a> -->
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#username-change">Changer Nom d'Utilisateur</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#password-change">Changer Mot de Passe</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ URL::to('/logout') }}">Se déconnecter</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="bg-light">
                @if (session()->has('password-changed'))
                    <div class="containter-fluid">
                        <div class="alert alert-success alert-block text-center" style="margin: 1.5rem; width: 25%;">
                            <strong><i class="bi bi-check-circle-fill"></i>
                                {{ session('password-changed') }}</strong>
                        </div>
                    </div>
                @endif

                @if (session()->has('password-incorrect'))
                    <div class="containter">
                        <div class="alert alert-danger alert-block text-center" style="margin: 1.5rem; width: 20%;">
                            <strong><i class="bi bi-x-octagon-fill"></i> {{ session('password-incorrect') }}</strong>
                        </div>
                    </div>
                @endif

                @if (session()->has('username-changed'))
                    <div class="containter-fluid">
                        <div class="alert alert-success alert-block text-center" style="margin: 1.5rem; width: 30%;">
                            <strong><i class="bi bi-check-circle-fill"></i>
                                {{ session('username-changed') }}</strong>
                        </div>
                    </div>
                @endif

                @if (session()->has('username-incorrect'))
                    <div class="containter">
                        <div class="alert alert-danger alert-block text-center" style="margin: 1.5rem; width: 25%;">
                            <strong><i class="bi bi-x-octagon-fill"></i>
                                {{ session('username-incorrect') }}</strong>
                        </div>
                    </div>
                @endif


                

                {{-- ACTUAL CONTENT HERE --}}


                @yield('content')





            </div>


        </div>
    </div>

    {{-- Password changer modal --}}
    <div class="modal fade" id="password-change" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center bg-danger text-white">
                    <h5 class="modal-title w-100" id="exampleModalLongTitle">Changer votre mot de passe</h5>
                </div>
                <div class="modal-body">

                    <div class="container">
                        <form action="{{ route('changer_password') }}" method="POST">
                            @csrf
                            <label for="old" class="form-label">Ancien mot de passe</label>
                            <input type="password" id="old" class="form-control" name="old_pass" required>

                            <label for="new" class="form-label">Nouveau mot de passe</label>
                            <input type="password" id="new" class="form-control" name="new_pass" required>
                            <br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Changer</button>
                                <button type="button" class="btn btn-outline-primary"
                                    data-dismiss="modal">Annuler</button>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>


    {{-- Username changer modal --}}
    <div class="modal fade" id="username-change" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center bg-warning text-white">
                    <h5 class="modal-title w-100" id="exampleModalLongTitle">Changer votre nom d'utilisateur</h5>
                </div>
                <div class="modal-body">

                    <div class="container">
                        <form action="{{ route('changer_username') }}" method="POST">
                            @csrf
                            <label for="old" class="form-label">Ancien Nom d'Utilisateur</label>
                            <input type="text" id="old" class="form-control" name="old_username" required>

                            <label for="new" class="form-label">Nouveau Nom d'Utilisateur</label>
                            <input type="text" id="new" class="form-control" name="new_username" required>
                            <br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Changer</button>
                                <button type="button" class="btn btn-outline-primary"
                                    data-dismiss="modal">Annuler</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>



    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>



    {{-- <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
        <script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.0/js/dataTables.bootstrap5.min.js"></script> --}}


    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://kit.fontawesome.com/92265a4cc3.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    {{-- tables --}}
    {{-- <script src="{{asset('js/jquery-git.min.js')}}"></script> --}}
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.myTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
                }
            });
        });
    </script>
</body>

</html>
