<h2>Search filters</h2>

<head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
<body>

{$searchFiltersForm}

{if $nothingFound}
Nothing found! Please, try another filter.

{else}

    {section name=i loop=$courses}
        <h3>{$courses[i].title}</h3>
        <p>{$courses[i].description}</p>

        <p>Time: {$courses[i].time}</p>

        <p>Audience: {$courses[i].audience_min} - 
        {$courses[i].audience_max}</p>

        <p>pop: {$courses[i].popularity}</p>
        <p>rat: {$courses[i].rating}</p>
    {/section}

{/if}



  <script>


  var price_min = {$priceminvalue};
  var price_max = {$pricemaxvalue};
  var price_top = {$pricetop};
  var price_bottom = {$pricebottom};

  var audience_min = {$audienceminvalue};
  var audience_max = {$audiencemaxvalue};
  var audience_top = {$audiencetop};
  var audience_bottom = {$audiencebottom};

  var rating_min = {$ratingminvalue};
  var rating_max = {$ratingmaxvalue};
  var rating_top = {$ratingtop};
  var rating_bottom = {$ratingbottom};

  {literal}
  $( function() {
    $( "#price-range" ).slider({
      range: true,
      min: price_bottom,
      max: price_top,
      values: [ price_min, price_max ],
      slide: function( event, ui ) {
        $( "#pricemin" ).val( ui.values[ 0 ]);
        $( "#pricemax" ).val( ui.values[ 1 ] );
        $( "#pricelabel" ).html('$'+ui.values[ 0 ]+' - $'+ ui.values[ 1 ]);
      }
    });
    $( "#pricemin" ).val($( "#price-range" ).slider( "values", 0 ));
    $( "#pricemax" ).val($( "#price-range" ).slider( "values", 1 ));
    $( "#pricelabel" ).html('$'+$( "#price-range" ).slider( "values", 0 )+' - $'+$( "#price-range" ).slider( "values", 1 ));

    $( "#audience-range" ).slider({
      range: true,
      min: audience_bottom,
      max: audience_top,
      values: [ audience_min, audience_max ],
      slide: function( event, ui ) {
        $( "#audiencemin" ).val( ui.values[ 0 ]);
        $( "#audiencemax" ).val( ui.values[ 1 ] );
        $( "#audiencelabel" ).html('$'+ui.values[ 0 ]+' - $'+ ui.values[ 1 ]);
      }
    });
    $( "#audiencemin" ).val($( "#audience-range" ).slider( "values", 0 ));
    $( "#audiencemax" ).val($( "#audience-range" ).slider( "values", 1 ));
    $( "#audiencelabel" ).html('$'+$( "#audience-range" ).slider( "values", 0 )+' - $'+$( "#audience-range" ).slider( "values", 1 ));

     $( "#rating-range" ).slider({
      range: true,
      min: rating_bottom,
      max: rating_top,
      values: [ rating_min, rating_max ],
      slide: function( event, ui ) {
        $( "#ratingmin" ).val( ui.values[ 0 ]);
        $( "#ratingmax" ).val( ui.values[ 1 ] );
        $( "#ratinglabel" ).html('$'+ui.values[ 0 ]+' - $'+ ui.values[ 1 ]);
      }
    });
    $( "#ratingmin" ).val($( "#rating-range" ).slider( "values", 0 ));
    $( "#ratingmax" ).val($( "#rating-range" ).slider( "values", 1 ));
    $( "#ratinglabel" ).html('$'+$( "#rating-range" ).slider( "values", 0 )+' - $'+$( "#rating-range" ).slider( "values", 1 ));

  } );
  </script>
  {/literal}
