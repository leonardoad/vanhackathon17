<h1>Home</h1>

<h2>Popular Courses</h2>

    {section name=i loop=$popularCourses}
        <h3>{$popularCourses[i].title}</h3>
        <p>{$popularCourses[i].description}</p>

        <p>Time: {$popularCourses[i].time}</p>

        <p>Audience: {$popularCourses[i].audience_min} - 
        {$popularCourses[i].audience_max}</p>

        <p>pop: {$popularCourses[i].popularity}</p>
        <p>rat: {$popularCourses[i].rating}</p>
    {/section}