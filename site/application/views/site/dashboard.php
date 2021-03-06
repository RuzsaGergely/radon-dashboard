<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radon Dashboard</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet"
        href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css"
        integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <style>
        html,
        body {

            height: 100%;
            background-color: #2f2f2f;
        }

        .holder {
            padding-left: 10%;
            padding-right: 10%;
            padding-top: 5%;
            padding-bottom: 5%;
            position: absolute;
            width: 100%;
        }

        @media screen and (max-width: 600px) {
            .holder {
                padding-left: 1%;
                padding-right: 1%;
                padding-top: 5%;
                padding-bottom: 5%;
                position: absolute;
                width: 100%;
            }
        }

        .icon {
            position: relative;
            /* Adjust these values accordingly */
            top: 5px;
            left: 5px;
        }

        .material-icons.md-light {
            color: rgba(255, 255, 255, 1);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body onload=checkLoginStatus(<?php echo "\"" . base_url() . "\""; ?>)>

    <div class="bmd-layout-container bmd-drawer-f-l bmd-drawer-overlay">
        <header class="bmd-layout-header">
            <div class="navbar navbar-dark" style="background-color: #2f2f2f;">
                <button class="navbar-toggler" type="button" data-toggle="drawer" data-target="#dw-s1">
                    <span class="sr-only">Toggle drawer</span>
                    <i class="material-icons">menu</i>
                </button>
                <ul class="nav navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#" onclick="logout()">Log out</a></li>
                </ul>
            </div>
        </header>
        <div id="dw-s1" class="bmd-layout-drawer bg-faded">
            <header>
                <p><img style=" -webkit-filter: invert(100%); filter: invert(100%);" src="<?php echo base_url(); ?>assets/radon_logo.svg" width="30"
                        height="30" alt=""> Radon Dashboard</p>
            </header>
            <ul class="list-group">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="serverDropdown" role="button"
                        data-toggle="dropdown">
                        <span class="material-icons icon">dns</span>&ensp;Servers
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" id="serverList">
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="displayOverview()"><span
                            class="material-icons icon">bar_chart</span>&ensp;Overview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="displayUserCreation()"><span
                            class="material-icons icon">how_to_reg</span>&ensp;Add User</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="displayAddServer()"><span
                            class="material-icons icon">add</span>&ensp;Add Server</a>
                </li>
                <div class="fixed-bottom">
                    <div class="dropdown-divider"></div>
                    <li class="nav-item" style="text-align: center;">
                        <b>v1.0 - Development</b>
                    </li>
                </div>
            </ul>
        </div>
        <main class="bmd-layout-content">
            <div class="holder">
                <div class="card">
                    <div class="card-body">
                        <div class="container" id="display-container">
                            <div class="row">
                                <div class="col-sm" id="serverNumber">
                                    <h1>Overview</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>


    <script src="https://code.jquery.com/jquery-3.4.1.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js"
        integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function () {
            $('body').bootstrapMaterialDesign();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"
        integrity="sha256-T/f7Sju1ZfNNfBh7skWn0idlCBcI3RwdLSS4/I7NQKQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/config.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard_control.js"></script>
</body>

</html>