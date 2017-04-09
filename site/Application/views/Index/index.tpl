 
<div class="row">

    <div class="panel  panel-primary">
        <div class="panel-heading">
            <div class="">Hello! These are your booked Lunch n' Learn!</div>
        </div>
    </div>
</div>

<div class="row">
    {section name=j loop=$courseLst}
        <div class="col-md-4">
            <div class="card card-inverse card-info">
                <img class="card-img-top" src="{$courseLst[j]->getPhotoPath()}">
                <div class="card-block">
                    <h4 class="card-title mt-3">{$courseLst[j]->getTitle()}</h4>
                    <div class="card-text">
                        <p><strong>Duration:</strong> {$courseLst[j]->getFormattedTime()}</p>
                        <p><strong>Educator:</strong> {$courseLst[j]->getEducatorName()}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <span class="lnl-price"><i class="fa fa-calendar fa-fw"></i>{$courseLst[j]->getRealDate()} </span><span class="">(confirmed)</span>
                </div>
                <div class="card-footer">
                    <a href="{$baseUrl}web/lunchandlearn/id/{$courseLst[j]->getID()}" class="btn lnl-green btn-sm">Read More</a>
                    <a   class="btn lnl-green float-right btn-sm" event="click" id="contacteducator" params="id_course={$courseLst[j]->getID()}"  name="contacteducator" url="index"><i class="fa fa-envelope-o fa-fw"></i> Cantact the Educator</a>
                </div>
            </div>
        </div>

    {sectionelse}
        <p>Looks like you don't have any booked session... </p>
        <a href="{$baseUrl}web">Find the perfect Lunch and Learn for you! </a>
    {/section}
</div>
<!-- /.row -->