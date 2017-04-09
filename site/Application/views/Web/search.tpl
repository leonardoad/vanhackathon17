<head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>



<!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron lnl-search-result-header">

  </div>
  <div class="container-fluid lnl-fluid">
    <div class="container lnl-search-result-body">
      <!-- row of columns -->
      <div class="row">
        <!-- left col -->
        <div class="col-sm-3">
          {$searchFiltersForm}
        </div>
        <!--/col-3-->
        <div class="col-sm-9" style="" contenteditable="false">
          <div class="panel panel-default target">
            <div class="panel-body">
              <div class="col-md-12">
                <h3><strong>Search Results:</strong></h3>
                <hr>
                <div class="row">
                {if $nothingFound}
                  <div class="col-md-4 single-lnl">
                    Nothing found! Please, try another filter.
                  </div>
                {else}

                  {section name=i loop=$courses}

                      {*<p>pop: {$courses[i].popularity}</p>
                      <p>rat: {$courses[i].rating}</p>*}

                  <div class="col-md-4 single-lnl">
                    <div class="card card-inverse card-info">
                      <img class="card-img-top" src="images/lnl-image-1.jpg">
                      <div class="card-block">
                        <h4 class="card-title mt-3">{$courses[i].title}</h4>
                        <div class="meta card-text">
                          <p>{$courses[i].description}</p>
                          <hr>
                        </div>
                        <div class="card-text">
                          <p><strong>Location:</strong> Vancouver</p>
                          <p><strong>Duration:</strong> {$courses[i].time}</p>
                          <p><strong>Group Size:</strong> {$courses[i].audience_min} - 
                      {$courses[i].audience_max}</p>
                        </div>
                      </div>
                      <div class="card-footer">
                        <span class="lnl-price">${$courses[i].cost}</span>
                        <button class="btn lnl-green float-right btn-sm">Book Now</button>
                      </div>
                    </div>
                  </div><!-- end col-md-4 -->
                  {/section}

                {/if}
                </div><!-- end row -->
                <div class="row lnl-pagination pull-right">
                  <div class="col-md-12">
                    <ul class="pagination">
                      <li class="active"><a href="#">1</a></li>
                      <li><a href="#">2</a></li>
                      <li><a href="#">3</a></li>
                      <li><a href="#">4</a></li>
                      <li><a href="#">5</a></li>
                    </ul>
                  </div><!-- end col-md-12 -->
                </div><!-- end row -->
              </div>
            </div>

            <hr>
          </div><!-- end col-sm-9 -->
        </div><!-- end row -->
      </div> <!-- end container -->
    </div><!-- end container fluid -->




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
        $( "#audiencelabel" ).html(ui.values[ 0 ]+' - '+ ui.values[ 1 ]);
      }
    });
    $( "#audiencemin" ).val($( "#audience-range" ).slider( "values", 0 ));
    $( "#audiencemax" ).val($( "#audience-range" ).slider( "values", 1 ));
    $( "#audiencelabel" ).html($( "#audience-range" ).slider( "values", 0 )+' - '+$( "#audience-range" ).slider( "values", 1 ));

     $( "#rating-range" ).slider({
      range: true,
      min: rating_bottom,
      max: rating_top,
      values: [ rating_min, rating_max ],
      slide: function( event, ui ) {
        $( "#ratingmin" ).val( ui.values[ 0 ]);
        $( "#ratingmax" ).val( ui.values[ 1 ] );
        $( "#ratinglabel" ).html(ui.values[ 0 ]+' - '+ ui.values[ 1 ]);
      }
    });
    $( "#ratingmin" ).val($( "#rating-range" ).slider( "values", 0 ));
    $( "#ratingmax" ).val($( "#rating-range" ).slider( "values", 1 ));
    $( "#ratinglabel" ).html($( "#rating-range" ).slider( "values", 0 )+' - '+$( "#rating-range" ).slider( "values", 1 ));

  } );
  </script>
  {/literal}
