 
<div class="row">

    <div class="panel  panel-primary">
        <div class="panel-heading">
            <div class="">Olá!</div>
        </div>
    </div>
</div>
{if $acoes!=''}
    <div class="row">

        <div class="panel  panel-default">
            <div class="panel-heading">
                <div class="">Ações da qualidade abertas para você!</div>
            </div>
            <div class="panel-body">
                <div class="">{$acoes}</div>
                <div id="acaoLst"> <i class="fa fa-spinner fa-2x spinner" ></i> Verificando</div>
            </div>
        </div>
    </div>
{/if}
<!-- /.row -->