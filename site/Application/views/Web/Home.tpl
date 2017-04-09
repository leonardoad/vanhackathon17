<h1>Home</h1>

<h2>Popular Courses</h2>
<div class="row">
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
