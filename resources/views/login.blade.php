<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Authentification</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <style>
        .main-login {
            width: 400px;
            margin-top: 50px;
        }

        body {
            /* background-color: rgb(182, 170, 126); */
            background-color: #cfeaf7;
            /* #56baed */
            
        }

        img{
            width: 25%;
            height: 25%;
        }
        .mybox{
            /* box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; */
            box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;        
        }
    </style>
</head>

<body>
  

    <section class="vh-100">
        <div class="container h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card shadow-2-strong mybox" style="border-radius: 1rem;">
                <div class="card-body p-4 text-center">
      
                    <div class="mb-5 margin-tb text-center">
                        <img src="{{ asset('img/court-main.png') }}">
                    </div>

                    <h5>Gestionnaire des ressources humaines et
                        matérielles au sein de la cour d'appel à Kénitra</h5><br>
                    <form method="POST" action="{{ url('/connection') }}">

                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
            
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
            
                        @if (session()->has('message'))
                            <div class="containter">
                                <div class="alert alert-danger alert-block text-center" style="margin: 1.5rem; width: 20%;">
                                    <strong><i class="bi bi-x-octagon-fill"></i>  {{ session('message') }}</strong>
                                </div>
                            </div>
                        @endif
            
            
                        @csrf
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroupUsername2"
                                placeholder="Nom d'utilisateur..." name="username">
                        </div>
            
                        <p></p>
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="bi bi-key-fill"></i></div>
                            </div>
                            <input type="password" class="form-control" id="inlineFormInputGroupUsername2"
                                placeholder="Mot de passe" name="password">
                        </div>
                        <p></p>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary mb-2 btn-lg btn-block">S'authentifier</button>
                        </div>
            
            
                    </form>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


</body>

</html>
