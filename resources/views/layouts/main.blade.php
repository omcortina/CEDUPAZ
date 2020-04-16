<!DOCTYPE html>

@php
    $administrador = \App\Persona::find(session('id_usuario'));
@endphp
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>@yield('title')</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('Diseño/css/font-face.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('Diseño/vendor/font-awesome-4.7/css/font-awesome.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('Diseño/vendor/font-awesome-5/css/fontawesome-all.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('Diseño/vendor/mdi-font/css/material-design-iconic-font.min.css')}}" rel="stylesheet" media="all">
    
    <!-- Bootstrap CSS-->
    <link href="{{ asset('Diseño/vendor/bootstrap-4.1/bootstrap.min.css')}}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('Diseño/vendor/animsition/animsition.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('Diseño/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('Diseño/vendor/wow/animate.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('Diseño/vendor/css-hamburgers/hamburgers.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('Diseño/vendor/slick/slick.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('Diseño/vendor/select2/select2.min.css')}}" rel="stylesheet" media="all">
    <link href="{{ asset('Diseño/vendor/perfect-scrollbar/perfect-scrollbar.css')}}" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="{{ asset('Diseño/css/theme.css')}}" rel="stylesheet" media="all">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">

    <style type="text/css">
    @media (max-width: 991px){
        .header-desktop {
            position: relative;
            top: 0;
            left: 0;
            height: auto;
        }
    } 
    </style>
    

</head>

<body class="animsition">
    <div class="page-wrapper">
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="#">
                            <img src="{{ asset('Diseño/images/icon/logo.png') }}" alt="Cool Admin" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <a class="js-arrow" href="{{ route('persona/listar_docentes') }}">
                                <i class="fas fa-tachometer-alt" ></i>Gestion Docente</a>
                        </li>

                        <li class="has-sub">
                            <a class="js-arrow" href="{{ route('persona/listar_estudiantes') }}">
                                <i class="fas fa-tachometer-alt" ></i>Gestion Estudiante</a>
                        </li>

                        <li class="has-sub">
                            <a class="js-arrow" href="{{ route('asignatura/listar_asignaturas') }}">
                                <i class="fas fa-tachometer-alt" ></i>Gestion Asignatura</a>
                        </li>

                        <li class="has-sub">
                            <a class="js-arrow" href="{{ route('curso/listar_cursos') }}">
                                <i class="fas fa-tachometer-alt" ></i>Gestion Curso</a>
                        </li> 
                    </ul>
                </div>
            </nav>
        </header>
        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="{{ asset('Diseño/images/icon/logo.png') }}" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="has-sub">
                            <a class="js-arrow" href="{{ route('persona/listar_docentes') }}">
                                <i class="fas fa-tachometer-alt" ></i>Gestion Docente</a>
                        </li>

                        <li class="has-sub">
                            <a class="js-arrow" href="{{ route('persona/listar_estudiantes') }}">
                                <i class="fas fa-tachometer-alt" ></i>Gestion Estudiante</a>
                        </li>

                        <li class="has-sub">
                            <a class="js-arrow" href="{{ route('asignatura/listar_asignaturas') }}">
                                <i class="fas fa-tachometer-alt" ></i>Gestion Asignatura</a>
                        </li>

                        <li class="has-sub">
                            <a class="js-arrow" href="{{ route('curso/listar_cursos') }}">
                                <i class="fas fa-tachometer-alt" ></i>Gestion Curso</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30" style="left: auto !important">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            
                            <div class="header-button">
                                
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img src="{{ asset('Diseño/images/icon/avatar-01.jpg') }}" alt="John Doe" />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">{{$administrador->nombre}}</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img src="{{ asset('Diseño/images/icon/avatar-01.jpg') }}" alt="John Doe" />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">{{$administrador->nombre}} {{$administrador->apellido}}</a>
                                                    </h5>
                                                    <span class="email">{{$administrador->email}}</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-account"></i>Mi perfil</a>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="{{ route('persona/cerrar_sesion')}}">
                                                    <i class="zmdi zmdi-power"></i>Cerrar sesion</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                         @yield('content')
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>

    <!-- Jquery JS-->

    <!-- Bootstrap JS-->
    <script src="{{ asset('Diseño/vendor/bootstrap-4.1/popper.min.js')}}"></script>
    <script src="{{ asset('Diseño/vendor/bootstrap-4.1/bootstrap.min.js')}}"></script>
    <!-- Vendor JS       -->
    <script src="{{ asset('Diseño/vendor/slick/slick.min.js')}}">
    </script>
    <script src="{{ asset('Diseño/vendor/wow/wow.min.js')}}"></script>
    <script src="{{ asset('Diseño/vendor/animsition/animsition.min.js')}}"></script>
    <script src="{{ asset('Diseño/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')}}">
    </script>
    <script src="{{ asset('Diseño/vendor/counter-up/jquery.waypoints.min.js')}}"></script>
    <script src="{{ asset('Diseño/vendor/counter-up/jquery.counterup.min.js')}}">
    </script>
    <script src="{{ asset('Diseño/vendor/circle-progress/circle-progress.min.js')}}"></script>
    <script src="{{ asset('Diseño/vendor/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{ asset('Diseño/vendor/chartjs/Chart.bundle.min.js')}}"></script>
    <script src="{{ asset('Diseño/vendor/select2/select2.min.js')}}">
    </script>

    <!-- Main JS-->
    <script src="{{ asset('Diseño/js/main.js')}}"></script>
    <script>
        $(document).ready(function () {
           $('#filtro').keyup(function () {
              var rex = new RegExp($(this).val(), 'i');
                $('#bodytable tr').hide();
                $('#bodytable tr').filter(function () {
                    return rex.test($(this).text());
                }).show();

                })
        });
    </script>
</body>

</html>
<!-- end document-->
