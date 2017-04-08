
<div class="panel-body">

    {if $descricao != ''}
        {* <div class="panel panel-info">
        <div class=" panel-body ">*}
        <div class="alert alert-info" role="alert">
            <i class="glyphicon glyphicon-info-sign"></i> &nbsp;&nbsp;
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {$descricao}
        </div>
        {* </div> 
        </div> *}
    {/if}

    <div class="panel panel-default">
        {if $btnNovaBookedCourse !=''}
            <div class="panel-heading text-right">
                {$btnNovaBookedCourse}

            </div> 
        {/if}
        <div class="panel-body">
            {$gridBookedCourse}
        </div>
    </div>

</div>
