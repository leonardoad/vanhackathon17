<h1>Home</h1>

<h2>Popular Courses</h2>
{section name=i loop=$popularCourses}
    <h3>{$popularCourses[i]->getTitle()}</h3>
    <p>{$popularCourses[i]->getDescription()}</p>

    <p>Time: {$popularCourses[i]->getTime()}</p>

    <p>Audience: {$popularCourses[i]->getAudience_min()} - 
    {$popularCourses[i]->getAudience_max()}</p>
{/section}
