



<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron lnl-profile-header">

</div>
<div class="container-fluid lnl-fluid">
    <div class="container lnl-profile-body">
        <!-- Example row of columns -->
        <div class="row">
            <div class="col-sm-3">
                <!--left col-->
                <div class="media lnl-media">
                    <div class="lnl-profile-thumbnail" align="center">
                        <img class="thumbnail img-responsive" src="{$baseUrl}Public/images/josemario.jpg" width="300px" height="300px">
                    </div>
                    <div class="media-body">
                        <hr>
                        <div class="col-md-6 text-center">
                            <h1 class="rating-num">
                                {$profile->getAvarageStarsNumber()|number_format:1}</h1>
                        </div>
                        <div class="col-md-6 lnl-stars">
                            <div class="rating">
                                {$profile->getAvarageStars()}
                                {*<span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star-half-o"></span>*}
                            </div>
                            <div>
                                <span class="fa fa-user"></span> {$profile->getCountReviews()} reviews
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-group">
                    <li class="list-group-item text-muted" contenteditable="false">Profile</li>
{*                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Joined</strong></span> {$profile->getRegisterDate()}</li>*}
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Events Hosted</strong></span> {$profile->getCountEventHosted()}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Lunch and Learn</strong></span> {$courseLst|@count}</li>
                        {*                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location: </strong></span> Colombia</li>*}
                </ul>
                <div class="panel panel-default">
                    <div class="panel-heading">Social Media</div>
                    <div class="panel-body">  <i class="fa fa-facebook fa-2x"></i>  <i class="fa fa-github fa-2x"></i>
                        <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i>  <i class="fa fa-google-plus fa-2x"></i>

                    </div>
                </div>
            </div>
            <!--/col-3-->
            <div class="col-sm-9" style="" contenteditable="false">
                <div class="panel panel-default target">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <h3><strong>{$profile->getNomeCompleto()}</strong></h3>


                            <div class="lnl-profession"><small >UI/UX Designer - Front End Developer</small></div>
                            <div><span class="label label-blue">Educator</span><hr></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. Morbi odio metus, dapibus non nibh id amet. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. Morbi odio metus, dapibus non nibh id amet.</p>
                            <hr>
                        </div>
                        <div class="col-md-12 lnl-subtitle"><h4><strong>Lunch & Learns <span class="badge">{$courseLst|@count} </span></strong></h4></div>


                        {section name=j loop=$courseLst}
                            <div class="col-md-4">
                                <div class="card card-inverse card-info">
                                    <img class="card-img-top" src="{$courseLst[j]->getPhotoPath()}">
                                    <div class="card-block">
                                        <h4 class="card-title mt-3">{$courseLst[j]->getTitle()}</h4>
                                        <div class="meta card-text">
                                            {$courseLst[j]->getDescription()}
                                            {*                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. </p>*}
                                            <hr>
                                        </div>
                                        <div class="card-text">
                                            {*                                            <p><strong>Location:</strong> {$courseLst[j]->getLocation()}</p>*}
                                            <p><strong>Duration:</strong> {$courseLst[j]->getFormatedTime()}</p>
                                            <p><strong>Group Size:</strong> {$courseLst[j]->getGroupSize()}</p>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <span class="lnl-price">${$courseLst[j]->getCost()}</span>
                                        <button class="btn lnl-green float-right btn-sm">Book Now</button>
                                    </div>
                                </div>
                            </div>

                        {/section}

                    </div>
                </div>

                <hr>
            </div><!-- end col-sm-9 -->
        </div><!-- end row -->
    </div> <!-- end container -->
</div><!-- end container fluid -->