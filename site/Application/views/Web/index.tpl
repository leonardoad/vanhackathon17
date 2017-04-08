<html>
<head>
    <title>{$pageTitle}</title>
</head>
<body>

{$menu}
<h2>This is the main web page</h2>
{$content}

        <script type="text/javascript">
            //var cBaseUrl = '/Projetos/Opertur/';
            eval("base = '{$baseUrl}'");
            var cBaseUrl = '{$baseUrl}';
            var HTTP_HOST = '{$HTTP_HOST}';
        </script>

{$scripts}

    <!-- jQuery Version 1.11.0 -->
    <script src="{$baseUrl}Public/Js/jquery-1.11.0.js"></script>
    {* <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>*}
    <!-- Bootstrap Core JavaScript -->
    <script src="{$baseUrl}Public/Js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{$baseUrl}Public/Js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    {*   <script src="{$baseUrl}Public/Js/plugins/morris/raphael.min.js"></script>
    <script src="{$baseUrl}Public/Js/plugins/morris/morris.min.js"></script>
    <script src="{$baseUrl}Public/Js/plugins/morris/morris-data.js"></script>*}



    <!-- DataTables -->
    {*        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.js"></script>*}


    <!-- DataTables JavaScript -->
    <script src="{$baseUrl}Public/Js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="{$baseUrl}Public/Js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="{$baseUrl}Public/Js/jquery-ui.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{$baseUrl}Public/Js/sb-admin-2.js"></script>

    <!-- Bootstrap Datepicker JS-->
    {*        <script src="{$baseUrl}Public/Js/bootstrap-datepicker.js"></script>*}
    <script src="{$baseUrl}../Libs/Scripts/Datepicker/js/bootstrap-datepicker.min.js"></script>

    <script src="{$baseUrl}../Libs/Scripts/Principal.js"></script>
    {*        <script src="{$baseUrl}../Libs/Scripts/jquery.timer.js"></script>*}

    <link rel="stylesheet" href="{$baseUrl}../Libs/Scripts/Select2/select2.css">
    <script type="text/javascript" src="{$baseUrl}../Libs/Scripts/Select2/select2.min.js"></script>
    {*            <script type="text/javascript" src="{$baseUrl}../Libs/Scripts/Mask/jquery.mask.js"></script>*}
    {literal}
        <script type="text/javascript">

        /*
         * Faz os campos de select que tiverem o attr 'select2' virem um Select2

         $(document).ready(function ($) {
         $("select[select2]").select2({width: '100%'});
         $("select[select2]").attr('data-times-focused', '1');
         $(".select2-hidden-accessible").each(function () {

         obrig = $(this).attr('obrig');
         id = $(this).attr('id');
         if (obrig == 'obrig') {
         //                                        border-right: 2px solid rgb(193, 0, 5);
         //aria-labelledby
         //select2-AreaBanco-container
         // $("span[aria-labelledby='select2-" + id + "-container']").parent().parent().css('border-right', '2px solid rgb(193, 0, 5)')
         }
         });

         /*
         $('select[select2][event="change"]').select2()
         .on("change", function (e) {
         console.log(  $(this));
         // mostly used event, fired to the original element when the value changes
         $(this).trigger('change');
         });

         }); */

        $("body").delegate("*[select2]", "focusin", function () {
            times = $(this).attr('data-times-focused');
            if (typeof times == 'undefined') {
                $(this).select2({width: '100%'});
                $(this).attr('data-times-focused', '1');

            }
        });



            </script>
        {/literal}
</body>
</html>