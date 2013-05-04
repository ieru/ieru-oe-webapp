<!DOCTYPE html>
<html>
    <head>
        <title>Organic.Edunet</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="css/_app.css" rel="stylesheet" media="screen">

        <script src="http://use.edgefonts.net/amaranth.js"></script> 
    </head>

    <body>

        <div class="navbar navbar-inverse">
            <div class="container">
                <a class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <a class="navbar-brand" href="/#">Organic.Edunet</a>

                <div class="nav-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Lang::get('website.sign_in') ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form id="login-form" action="/" method="post" style="margin-bottom: 0">
                                        <input id="login-form-username" type="text" placeholder="<?php echo Lang::get('website.user') ?>"/>
                                        <input id="login-form-password" type="password" placeholder="<?php echo Lang::get('website.password') ?>"/>
                                        <button id="submit-login-form" type="submit" class="btn btn-primary"><?php echo Lang::get('website.submit') ?></button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <!--<li style="width: 300px; margin-right: 15px; ">
                            <div style="margin-left: 10px; float: right; padding-top: 9px; ">
                                <div class="onoffswitch" id="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" autocomplete="off">
                                    <label class="onoffswitch-label" for="myonoffswitch">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div> 
                            </div>
                            <div style="float: right; padding-top: 9px; color: #eee; "><?php echo Lang::get('website.auto-translate') ?></div>
                        </li>-->
                        <li class="dropdown pull-right" id="lang-selector">
                            <a href="#" data-toggle="dropdown" role="button" id="lang-<?php echo LANG ?>" class="dropdown-toggle"><span class="flag <?php echo Session::get( 'language' ) ?>flag"></span> <?php echo Lang::get('website.'.LANG ) ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=de<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><div class="flag deflag"></div> Deutsch</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=et<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><div class="flag etflag"></div> Eesti keel</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=en<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><div class="flag enflag"></div> English</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=es<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><div class="flag esflag"></div> Español</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=el<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><div class="flag elflag"></div> ελληνικά</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=fr<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><div class="flag frflag"></div> Français</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=it<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><div class="flag itflag"></div> Italiano</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=lv<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><div class="flag lvflag"></div> Latviešu valoda</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=tr<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><div class="flag trflag"></div> Türkçe</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <header id="header" class="jumbotron">
            <div class="container">
                <h1 class="pull-left hidden-phone">Organic.Edunet</h1>
                <form id="search-form" action="" class="pull-right">
                    <div class="input-group">
                        <input type="text" class="input-large" name="form-search" placeholder="<?php echo Lang::get('website.search') ?>" />
                        <span class="input-group-btn">
                            <button class="btn btn-large" type="submit">Go!</button>
                        </span>
                    </div>
                </form>
            </div>
        </header>

        <!-- HOME PAGE -->
        <div id="page-home">

            <!-- Banner section -->
            <div id="home-banner">
                <div class="container">
                    <a href="http://greenideasproject.org/" target="_blank"><img alt="green ideas 2013" src="http://organic.teluria.es/images/home-green-ideas.png"></a>
                </div>
            </div>

            <!-- Main content section -->
            <div class="container">
                <div class="row">
                    <div id="home-content">
                        <section class="col col-lg-8">
                            <h2><?php echo Lang::get('website.latest_resources') ?></h2>
                            <?php foreach( $carousel as $resource ): ?>
                            <article class="resource">
                                <header>
                                    <figure>
                                        <a href="<?php echo $resource->url ?>">
                                            <img class="img-thumbnail" src="http://images.thumbshots.com/image.aspx?cid=QtStE4McALo%3d&v=1&w=140&url=<?php echo $resource->url ?>" border="1" alt="Preview by Thumbshots.com" />
                                        </a>
                                    </figure>
                                    <h3><a href="<?php echo $resource->url ?>" onclick="target='_blank'"><?php echo$resource->title ?></a></h3>
                                </header>
                                <p><?php echo $resource->description ?></p>
                                <footer>
                                    <p>
                                        <?php echo Lang::get('website.rate') ?>: <span title="http://www.insights.co.nz/" id="item-show-rating-16787" class="item-rating"><a onclick="return false;" data-toggle="tooltip" class="rating-tooltip" href="#" data-original-title="" title=""><img src="/images/full_star.png" class="rating-star star-value-0"><img src="/images/full_star.png" class="rating-star star-value-1"><img src="/images/full_star.png" class="rating-star star-value-2"><img src="/images/full_star.png" class="rating-star star-value-3"><img src="/images/empty_star.png" class="rating-star star-value-4"></a> <?php echo Lang::get('website.of') ?> 3 <?php echo Lang::get('website.votes') ?>
                                        <a href="#" data-toggle="popover" data-placement="right" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." data-original-title="Popover on top"><span class="glyphicon glyphicon-expand"></span></a>
                                    </p>
                                </footer>
                            </article>
                            <?php endforeach ?>
                        </section>
                        <aside class="col col-lg-4">
                            <h2><?php echo Lang::get('website.featured_resource') ?></h2>
                            <div class="well">
                                <?php foreach( $featured as $resource ): ?>
                                <article class="resource">
                                    <header>
                                        <figure>
                                            <a href="<?php echo $resource->url ?>">
                                                <img class="img-thumbnail" src="http://images.thumbshots.com/image.aspx?cid=QtStE4McALo%3d&v=1&w=300&url=<?php echo $resource->url ?>" border="1" alt="Preview by Thumbshots.com" />
                                            </a>
                                        </figure>
                                        <h3><a href="<?php echo $resource->url ?>" onclick="target='_blank'"><?php echo$resource->title ?></a></h3>
                                    </header>
                                    <p><?php echo $resource->description ?></p>
                                    <footer>
                                        <p><?php echo Lang::get('website.rate') ?>: <span title="http://www.insights.co.nz/" id="item-show-rating-16787" class="item-rating"><a onclick="return false;" data-toggle="tooltip" class="rating-tooltip" href="#" data-original-title="" title=""><img src="/images/full_star.png" class="rating-star star-value-0"><img src="/images/full_star.png" class="rating-star star-value-1"><img src="/images/full_star.png" class="rating-star star-value-2"><img src="/images/full_star.png" class="rating-star star-value-3"><img src="/images/empty_star.png" class="rating-star star-value-4"></a> <?php echo Lang::get('website.of') ?> 3 <?php echo Lang::get('website.votes') ?></p>
                                    </footer>
                                </article>
                                <?php endforeach ?>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
        <!-- END HOME PAGE -->


        <!-- SEARCH PAGE -->
        <div id="page-app">
            <div class="container">
                <div class="row">
                    <div id="search-content">
                        <aside id="app-content-filters" class="col col-lg-3 hidden-phone">
                        </aside>
                        <div id="app-content-results" class="col col-lg-9">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SEARCH PAGE -->


        <!-- VIEW RESOURCE PAGE -->
        <div id="page-resource">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>
        <!-- END VIEW RESOURCE PAGE -->


        <footer id="footer">
            <div class="container">
                <p>&copy; Organic.Edunet 2013</p>
            </div>
        </footer>

        <script id="resource-content" type="text/template">
            <header>
                <figure class="hidden-phone">
                    <img class="img-thumbnail" src="http://images.thumbshots.com/image.aspx?cid=QtStE4McALo%3d&v=1&w=140&url=<%= location %>" border="1" alt="Preview by Thumbshots.com" />
                </figure>
                <h2><a href="<%= location %>" target="_blank"><%= texts[metadata_language].title %></a></h2>
                <p>This resource is in <%= language %></p>
            </header>
            <% if ( texts[metadata_language].description ){ %>
            <p><%= texts[metadata_language].description.substr(0,200).trim() %>...</p>
            <% } %>
            <footer>

            </footer>
        </script>

        <script id="facets-content" type="text/template">
            <div class="accordion-heading">
                <span class="glyphicon glyphicon-chevron-down pull-left"></span>
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#app-content-filters" href="#collapse-<%= name %>">
                    <%= name %>
                </a>
            </div>
        </script>

        <script id="facets-filter" type="text/template">
            <input type="checkbox" id="checkbox-<%= filter.replace(' ','-') %>" name="checkbox-<%= filter.replace(' ','-') %>" />
            <label for="checkbox-<%= filter.replace(' ','-') %>"><span></span> <a title="<%= filter %>"><%= translation %></a></label>
            <span class="label pull-right hidden-tablet hidden-phone"><%= value %></span>
        </script>

        <!-- jQuery + Bootstrap -->
        <script src="js/jquery.js"></script>
        <script src="js/vendor/bootstrap/bootstrap.js"></script>
        <script src="js/respond.js"></script>
        <!-- Libraries for using Backbone.js -->
        <script src="js/require.js"></script>
        <script src="js/underscore.js"></script>
        <script src="js/backbone.js"></script>
        <!-- App javaScript files -->
        <script src="js/app.js"></script>
        <script src="js/app.models.js"></script>
        <script src="js/app.views.js"></script>
        <script src="js/app.collections.js"></script>
        <script src="js/app.router.js"></script>

        <script>
            //$.ajaxSetup({ cache: false });
            // Wait for search request
            var Box = new App.Models.App();
            var doSearch = new App.Views.DoSearch();

            // Router + History
            Router = new App.Router;
            Backbone.history.start();

            // Ratings
            $('.rating-tooltip').tooltip({'title':'<?php echo Lang::get('website.log_in_or_register_for_rating') ?>'});
        </script>
  </body>
</html>