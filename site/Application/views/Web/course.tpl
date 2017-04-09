
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron lnl-singlelnl-header">
    <div class="container">
        <h1>{$course->getTitle()} </h1>
    </div>
</div>
<div class="container-fluid lnl-fluid">
    <div class="container lnl-profile-body">
        <!-- Example row of columns -->
        <div class="row">
            <!--/col-3-->
            <div class="col-sm-8" style="" contenteditable="false">
                <div class="panel panel-default target">
                    <div class="panel-body">
                        <div class="col-md-12">
                            {*                            <h3><strong>{$course->getSubTitle()} </strong></h3>*}
                            {$course->getDescription()}


                            <hr>
                        </div>
                        <div class="col-md-12 lnl-subtitle"><h4><strong>Previous Events Gallery </strong></h4></div>
                        <div class="col-md-12">
                            <div class="row"><div class='list-group gallery'>
                                    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                        <a class="thumbnail fancybox" data-fancybox="gallery" href="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg">
                                            <img class="img-responsive" alt="" src="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg" />
                                        </a>
                                    </div> <!-- col-6 / end -->
                                    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                        <a class="thumbnail fancybox" data-fancybox="gallery" href="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg">
                                            <img class="img-responsive" alt="" src="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg" />
                                        </a>
                                    </div> <!-- col-6 / end -->
                                    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                        <a class="thumbnail fancybox" data-fancybox="gallery" href="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg">
                                            <img class="img-responsive" alt="" src="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg" />
                                        </a>
                                    </div> <!-- col-6 / end -->
                                    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                        <a class="thumbnail fancybox" data-fancybox="gallery" href="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg">
                                            <img class="img-responsive" alt="" src="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg" />
                                        </a>
                                    </div> <!-- col-6 / end -->
                                    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                        <a class="thumbnail fancybox" data-fancybox="gallery" href="{$HTTP_REFERER}Public/Images//lnl-video-thumbnail.jpg">
                                            <img class="img-responsive" alt="" src="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg" />
                                        </a>
                                    </div> <!-- col-6 / end -->
                                    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                                        <a class="thumbnail fancybox" data-fancybox="gallery" href="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg">
                                            <img class="img-responsive" alt="" src="{$HTTP_REFERER}Public/Images/lnl-video-thumbnail.jpg" />
                                        </a>
                                    </div> <!-- col-6 / end -->
                                </div> <!-- list-group / end --></div>
                        </div>
                    </div>
                </div>

                <hr>
            </div><!-- end col-sm-8 -->
            <div class="col-sm-4">
                <!--left col-->
                <div class="media lnl-media">
                    <div class="lnl-video-thumbnail" align="center" name='openvideo' id='openvideo' event='click' url='web' params='videolink={$course->getVideoLink()}&id={$course->getID()}'>
                        <div class="lnl-video">
                            <img class="thumbnail img-responsive" src="{$course->getPhotoPath()}" >
                        </div>
                    </div>
                    <div class="media-body">
                        <div class="row">
                            <div class=" col-md-12">
                                <span class="lnl-price video-price">${$course->getCost()} </span>
                                <a href="{$baseUrl}BookedCourse/edit/id_course/{$course->getID()}" class="btn lnl-green float-right btn-lg">Book Now</a>
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-6 text-center">
                            <h1 class="rating-num">{$course->getAvarageStarsNumber()}</h1>
                        </div>
                        <div class="col-md-6 lnl-stars-big">
                            <div class="rating-lnl">
                                {$course->getAvarageStars()}
                                {*<span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star"></span>
                                <span class="fa fa-star-half-o"></span>*}
                            </div>
                            <div>
                                <span class="fa fa-user"></span> {$course->getCountReviews()} review
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-group">
                    {*                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Location</strong></span> Vancouver</li>*}
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Duration</strong></span> {$course->getFormattedTime()} </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Setup Time</strong></span> {$course->getFormattedSetupTime()} </li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Group Size</strong></span>{$course->getGroupSize()}</li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Event Hosted</strong></span>{$course->getCountEventHosted()}</li>
                </ul>
            </div><!-- end col-md-4 -->
        </div><!-- end row -->
    </div> <!-- end container -->
</div><!-- end container fluid -->
<!-- Begin Gallery Modal -->
<div tabindex="-1" class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3 class="modal-title">Heading</h3>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- End Gallery Modal -->

