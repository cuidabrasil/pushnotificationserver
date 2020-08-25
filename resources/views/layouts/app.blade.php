<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ trans('project.Empresa') }} - @yield('htmlheader_title', '') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
    <link rel="shortcut icon" href="{{ url('/') }}/logo.ico" type="image/x-icon">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    @yield('css')
    <style>
    ul li.paginate_button { padding: 0 !important; margin: 0 !important;}
    ul li.paginate_button:hover, ul li.paginate_button:active { border: initial !important; box-shadow: none;}
    </style>

    <!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.2/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/localization/messages_pt_BR.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.14/jquery.mask.min.js"></script>
    <script src="//rawcdn.githack.com/RickStrahl/jquery-resizable/master/dist/jquery-resizable.min.js"></script>

    <script src="{{ url('/') }}/public/js/trumbowyg/trumbowyg.min.js"></script>
    <script src="{{ url('/') }}/public/js/trumbowyg/plugins/upload/trumbowyg.upload.js"></script>
    <!--<script src="{{ url('/') }}/public/js/trumbowyg/plugins/resizimg/trumbowyg.resizimg.js"></script>-->
    <script src="{{ url('/') }}/public/js/trumbowyg/langs/pt_br.js"></script>
    <link href="{{ url('/') }}/public/js/trumbowyg/ui/trumbowyg.min.css" rel="stylesheet" />
</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="./dashboard" class="logo" style="padding: 0 5px !important;">
                <p style="float: left;margin-left: 10px;">Push Server - Azures</p>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ url('/') }}/public/images/avatar.png"
                                     class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{ url('/') }}/public/images/avatar.png"
                                         class="img-circle" alt="User Image"/>
                                    <p>
                                        {!! Auth::user()->name !!}
                                        <small>{{ trans('dashboard.member_since') }} {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ trans('dashboard.sign_out') }}
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <a href="{{ trans('project.url') }}"><b>{{ trans('project.Empresa') }}</b></a>
        </footer>

    </div>
@else
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif

    @yield('scripts')

    <script>
    $(document).on('click', '.sidebar-toggle', function () {
        if ( $('body').hasClass("sidebar-open") == false ) {
            $('body').addClass("sidebar-open");
            $('body').addClass("sidebar-collapse");
        } else {
            $('body').removeClass("sidebar-open");
            $('body').removeClass("sidebar-collapse");
        }
    });
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
    $(document).ready(function() {
        // ------------------------------------------------------------
        // ATIVANDO TOOLTIPS
        // ------------------------------------------------------------     
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
        // ------------------------------------------------------------
        // PREVIEW DE UPLOAD
        // ------------------------------------------------------------
        $("#fileUpload").on('change', function() {
            //Get count of selected files
            var countFiles = $(this)[0].files.length;
            var imgPath = $(this)[0].value;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var image_holder = $("#image-holder");
            image_holder.empty();
            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++) 
                {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image crop"
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
                } else {
                    alert("This browser does not support FileReader.");
                }
            } else {
                alert("Pls select only images");
            }
        });
        // ------------------------------------------------------------
        // VALIDACAO
        // ------------------------------------------------------------
        $("#formUpdate").validate({
            ignore: ".ignore",
            submitHandler: function(form) {
                form.submit();
            },
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) { 
                    error.insertAfter(element.parent());      // radio/checkbox?
                } else if (element.hasClass('select2-hidden-accessible')) {
                    error.insertAfter($('select#' + element.attr('id')).next());  // select2
                } else {
                    error.insertAfter(element);               // default
                }
            }
        });

        $('.deletar_imagem').click(function(){
            var id = $(this).attr('id');
            if(id){
                if(confirm("Deseja excluir esta imagem?")){
                    location = "{{ url('/') }}/contentphotos/delete/"+id+"?urlSource=" + window.location.href;
                }
            }
        })
    });
    </script>
    <style>
        .buttons-pdf {
            display: none;
        }
    </style>
</body>
</html>
