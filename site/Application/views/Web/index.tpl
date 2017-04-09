
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">

        <title>{$pageTitle} - Lunch & Learn</title>

        <!-- Bootstrap core CSS -->
        <link href="{$baseUrl}Public/Css/bootstrap/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome CSS -->
        <link href="{$baseUrl}Public/font-awesome-4.7.0/Css/font-awesome.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{$baseUrl}Public/Css/style.css" rel="stylesheet">

    </head>

    <body>
        <div class="container">
            <nav class="navbar navbar-default lnl-nav" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header col-md-2">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand lnl-brand" href="#"><img src="{$baseUrl}Public/images/lnl-logo.jpg"></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <div class="col-sm-6 col-md-6 lnl-manu-search">
                        <form class="navbar-form" role="search">
                            <div class="input-group">
                                {$searchform}
                                {*<input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </span>*}
                            </div><!-- /input-group -->
                        </form>
                    </div>
                    <ul class="nav navbar-nav navbar-right col-md-4">
                        <li><a href="#">Link</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login <b class="caret"></b></a>
                            <div class="dropdown-menu">
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
                    </ul>
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