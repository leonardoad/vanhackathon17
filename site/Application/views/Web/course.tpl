

<p>{$course->getTitle()}  </p>
<p>{$course->getDescription()}  </p>
<p>{$course->getAvarageStars()}  </p>
<p>{$course->getPhotoPath()}  </p>
<p><img src="{$course->getPhotoPath()}" height="200"> </p>
<p>{$course->getVideoLink()}  </p>
<iframe width="560" height="315" src="https://www.youtube.com/embed/{$course->getVideoLink()} " frameborder="0" allowfullscreen></iframe>
<p>{$course->getCost()}  </p>
<p>{$course->getTime()}  </p>
<p>{$course->getFormatedTime()}  </p>
<p>{$course->getSetupTime()}  </p>
<p>{$course->getFormatedSetupTime()}  </p>
<p>{$course->getAudience_Min()}  </p>
<p>{$course->getAudience_Max()}  </p>


