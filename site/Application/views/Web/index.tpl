
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon"  href="{$baseUrl}Public/Images/favicon.ico" />

        <title>{$pageTitle} - Lunch & Learn</title>

        <!-- Bootstrap core CSS -->
        <link href="{$baseUrl}Public/Css/bootstrap/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome CSS -->
        <link href="{$baseUrl}Public/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{$baseUrl}Public/Css/style.css" rel="stylesheet">

    </head>

    <body>
        <div class="lnl-topnav">
            <nav class="navbar navbar-default lnl-nav" role="navigation">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header col-md-1">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand lnl-brand" href="{$baseUrl}"><img src="{$baseUrl}Public/Images/lnl-logo.jpg"></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="col-sm-6 col-md-6 lnl-manu-search">
                            {$searchform}
                        </div>
                        {*<ul class="nav navbar-nav navbar-right col-md-4">
                        <li><a href="#"></a></li>
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login <b class="caret"></b></a>
                        <div class="dropdown-menu">
                        <a href="{$baseUrl}index">Log in</a>
                        {$formSignUp}
                        </div>

                        </li>
                        <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        {$menu}
                        </ul>

                        </li>
                        </ul>*}
                        <form id="formSignup" name="formSignup" action="web">
                            {*<a id="btnSignUp" class="btn btn-success" name="btnSignUp" href="#none" type="success" link="#none" event="click" label="Sign up">Sign up</a>
                            <a id="btnLogOut" class="btn btn-success" name="btnLogOut" href="/site/logout" type="success" link="/site/logout" event="" label="Log Out">Log Out</a>
                            *}<ul class="nav navbar-nav navbar-right col-md-5 lnl-login">
                                <li><button id="btnSignIn" name="btnSignIn" href="#none" type="success" link="#none" event="click" label="Login"class="btn btn-md lnl-blue">Login</button></li>
                                <li><button id="btnSignUp" name="btnSignUp" href="#none" type="success" link="#none" event="click" label="Sign up"class="btn btn-md lnl-blue">Sign Up</button></li>
                                <li><button id="btnLogOut" name="btnLogOut" href="{$baseUrl}/site/logout" type="success"   event="click"  label="Log Out" class="btn btn-md lnl-pink">Log Out</button></li>
                            </ul>
                        </form>
                    </div><!-- /.navbar-collapse -->
            </nav>

        </div>
        {$content}


        <footer class="footer lnl-footer">
            <div class="container">
                <p class="text-muted">Vanhackaton 2017</p>
            </div>
        </footer>

        <div id="alert" style="display: none;"></div>

        <script type="text/javascript">
            //var cBaseUrl = '/Projetos/Opertur/';
            eval("base = '{$baseUrl}'");
            var cBaseUrl = '{$baseUrl}';
            var HTTP_HOST = '{$HTTP_HOST}';
        </script>

        {$scripts}

        <!-- jQuery Version 1.11.0 -->
        {*        <script src="{$baseUrl}Public/Js/jquery-1.11.0.js"></script>*}
        {* <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>*}
        <!-- Bootstrap Core JavaScript -->
        <script src="{$baseUrl}Public/Js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        {*        <script src="{$baseUrl}Public/Js/plugins/metisMenu/metisMenu.min.js"></script>*}

        <!-- Morris Charts JavaScript -->
        {*   <script src="{$baseUrl}Public/Js/plugins/morris/raphael.min.js"></script>
        <script src="{$baseUrl}Public/Js/plugins/morris/morris.min.js"></script>
        <script src="{$baseUrl}Public/Js/plugins/morris/morris-data.js"></script>*}



        <!-- DataTables -->
        {*        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.js"></script>*}


        <!-- DataTables JavaScript -->{*
        <script src="{$baseUrl}Public/Js/plugins/dataTables/jquery.dataTables.js"></script>
        <script src="{$baseUrl}Public/Js/plugins/dataTables/dataTables.bootstrap.js"></script>*}
        {*        <script src="{$baseUrl}Public/Js/jquery-ui.min.js"></script>*}

        <!-- Custom Theme JavaScript -->
        {*        <script src="{$baseUrl}Public/Js/sb-admin-2.js"></script>*}

        <!-- Bootstrap Datepicker JS-->
        {*        <script src="{$baseUrl}Public/Js/bootstrap-datepicker.js"></script>*}
        <script src="{$baseUrl}../Libs/Scripts/Datepicker/js/bootstrap-datepicker.min.js"></script>

        {*        <script src="{$baseUrl}../Libs/Scripts/Principal.js"></script>*}
        {*        <script src="{$baseUrl}../Libs/Scripts/jquery.timer.js"></script>*}

        <link rel="stylesheet" href="{$baseUrl}../Libs/Scripts/Select2/select2.css">
        <script type="text/javascript" src="{$baseUrl}../Libs/Scripts/Select2/select2.min.js"></script>
        {*            <script type="text/javascript" src="{$baseUrl}../Libs/Scripts/Mask/jquery.mask.js"></script>*}

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        {*        <script src="{$baseUrl}Public/js/jquery/jquery-3.2.0.min.js"></script>*}
        {*        <script>window.jQuery || document.write('<script src="{$baseUrl}Public/ js/jquery/jquery.min.js"><\/script>')</script>*}
        {*        <script src="{$baseUrl}Public/js/bootstrap/bootstrap.min.js"></script>*}
    </body>
</html>