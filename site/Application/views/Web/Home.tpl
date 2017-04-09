<!-- Top section -->
<div class="row lnl-first">
    <div class="container">
        <!-- Example row of columns -->
        <div class="row lnl-first-content">
            <div class="col-md-6 col-centered txt-center">
                <h1>Lunch And Learn</h1>
                <h2>Morbi odio metus, dapibus non nibh id amet.</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. Morbi odio metus, dapibus non nibh id amet. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. Morbi odio metus, dapibus non nibh id amet.</p>
                <form name="searchFormMenu" id="searchFormMenu" action="web" class="lnl-search-form">
                    <div class="input-group">
                        <input name="search" id="search" value="" class="form-control" label="" maxlength="255" placeholder="What do you want to learn?" type="text">
                        <span class="input-group-btn">
                            <button name="btnSearch" id="btnSearch" href="#none" type="success" link="#none" event="click" label=""
                                    sendformfields="1" class="btn lnl-green" type="button">
                                <span class="fa fa-search" aria-hidden="true"></span> <strong> Search</strong></button>
                        </span>
                    </div><!-- /input-group -->
                </form>
                {*<form class="lnl-search-form" role="search">
                <div class="input-group">
                <input type="text" class="form-control" placeholder="What do you want to learn?">
                <span class="input-group-btn">
                <button class="btn lnl-green" type="button">
                <span class="fa fa-search" aria-hidden="true"></span> <strong> Search</strong></button>
                </span>
                </div><!-- /input-group -->
                </form>*}
            </div>
        </div><!-- end row -->
    </div> <!-- end container -->
</div><!-- end container fluid -->
<!-- Second section -->
<div class="row lnl-fullh-row">
    <div class="container">
        <div class="row ">
            <div class="col-md-6 lnl-content lnl-second">
                <h1>Grow your Team</h1>
                <h2>Team Work.</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. Morbi odio metus, dapibus non nibh id amet. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. Morbi odio metus, dapibus non nibh id amet.</p></br>
                <button class="btn lnl-pink btn-lg">Learn more...</button>

            </div>
            <div class="col-md-6">
                <img src="{$baseUrl}Public/Images/speaker.png">
            </div>
        </div><!-- end row -->
    </div> <!-- end container -->
</div><!-- end container fluid -->
<!-- Third section -->
<div class="row lnl-fullh-row lnl-third">
    <div class="container">
        <div class="row ">
            <div class="col-md-6 pull-right lnl-content">
                <h1>Show your values</h1>
                <h2>Culture</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. Morbi odio metus, dapibus non nibh id amet. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. Morbi odio metus, dapibus non nibh id amet.</p></br>
                <button class="btn lnl-white btn-lg">Learn more...</button>
            </div>
            <div class="col-md-6">
                <img src="{$baseUrl}Public/Images/yoga-woman.png">
            </div>
        </div><!-- end row -->
    </div> <!-- end container -->
</div><!-- end container fluid -->
<!-- Section Four -->
<div class="row lnl-fullh-row lnl-fourth">
    <div class="container">
        <div class="row lnl-content">
            <div class="col-md-10 col-centered txt-center">
                <h1>Popular Lunch and Learns</h1>
                <p>Morbi odio metus, dapibus non nibh id amet.</p></br>
                {section name=j loop=$popularCourses}
                    {*  <h3>{$popularCourses[i]->getTitle()}</h3>
                    <p>{$popularCourses[i]->getDescription()}</p>

                    <p>Time: {$popularCourses[i]->getTime()}</p>

                    <p>Audience: {$popularCourses[i]->getAudience_min()} -
                    {$popularCourses[i]->getAudience_max()}</p>*}
                    <div class="col-md-4">
                        <div class="card card-inverse card-info">
                            <img class="card-img-top" src="{$popularCourses[j]->getPhotoPath()}">
                            <div class="card-block">
                                <h4 class="card-title mt-3">{$popularCourses[j]->getTitle()}</h4>
                                <div class="meta card-text">
                                    {$popularCourses[j]->getDescription()|truncate:200}
                                    {*                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vel gravida metus, non ultrices sapien. </p>*}
                                    <hr>
                                </div>
                                <div class="card-text">
                                    {*                                            <p><strong>Location:</strong> {$popularCourses[j]->getLocation()}</p>*}
                                    <p><strong>Instructor:</strong> {$popularCourses[j]->getEducatorName()}</p>
                                    <p><strong>Duration:</strong> {$popularCourses[j]->getFormattedTime()}</p>
                                    <p><strong>Group Size:</strong> {$popularCourses[j]->getGroupSize()}</p>
                                </div>
                            </div>
                            <div class="card-footer">
                                <span class="lnl-price">${$popularCourses[j]->getCost()}</span>
                                {*                                        <a href="{$baseUrl}web/lunchandlearn/id/{$popularCourses[j]->getID()}" class="btn lnl-green float-right btn-sm">Book Now</a>*}
                                <a href="{$baseUrl}web/lunchandlearn/id/{$popularCourses[j]->getID()}" class="btn lnl-green float-right btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                {/section}
            </div>
            <div class="col-md-6"></div>
        </div><!-- end row -->
    </div> <!-- end container -->
</div><!-- end container fluid -->