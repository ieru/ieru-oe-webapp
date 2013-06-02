<!DOCTYPE html>
<html>
    <head>
        <title>Organic.Edunet</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="css/_app.css" rel="stylesheet" media="screen">

        <script src="http://use.edgefonts.net/amaranth.js"></script> 
        <script src="http://use.edgefonts.net/league-gothic.js"></script>

        <!-- iOS web app configuration -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-transparent" /> 
        <link rel="apple-touch-icon" href="/images/ios-icon.png"/>
        <!--<link rel="apple-touch-startup-image" href="img/splash.png" />-->
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
                    <ul id="user-login" class="nav navbar-nav">
                    <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] <> '' ): ?>
                        <li>
                            <p class="navbar-text"><?php echo Lang::get('website.welcome'); ?>, <?php echo  $_user->user_username ?> | <a href="#" id="user-logout"><?php echo Lang::get('website.logout'); ?></a></p>
                        </li>
                        <li>
                            <p class="navbar-text">
                                <a  id="organic-suggest-resource" 
                                href="
                                    javascript:(function() {
                                        WIDGET_HOST = 'http://organiclingua.know-center.tugraz.at/';
                                        var path_js = '/UGC/ugc-widget-server/';
                                        try {
                                            var x = document.createElement('SCRIPT');
                                            x.type = 'text/javascript';
                                            x.src = WIDGET_HOST +  path_js + 'loadUGC.js';
                                            x.setAttribute('Name', '<?php echo  $_user->user_username ?>');
                                            x.setAttribute('Username', '<?php echo  $_user->user_username ?>');
                                            x.setAttribute('Email', '<?php echo  $_user->user_email ?>');
                                            x.setAttribute('Operation', 'add');
                                            x.setAttribute('id', 'LOMWidget');
                                            x.setAttribute('URL', window.location.href);
                                            document.getElementsByTagName('head')[0].appendChild(x);
                                        } catch (e) {}
                                    })();
                                "><?php echo Lang::get('website.suggest_a_new_resource')?></a></p>
                        </li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Lang::get('website.sign_in') ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form id="login-form" action="">
                                        <input id="login-form-username" type="text" placeholder="<?php echo Lang::get('website.user') ?>"/>
                                        <input id="login-form-password" type="password" placeholder="<?php echo Lang::get('website.password') ?>"/>
                                        <button id="submit-login-form" type="submit" class="btn btn-primary"><?php echo Lang::get('website.submit') ?></button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li><a href="#/user/register"><?php echo Lang::get('website.register'); ?></a></li>
                    <?php endif; ?>
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <li style="width: 300px; margin-right: 15px; ">
                            <div style="margin-left: 10px; float: right; padding-top: 9px; ">
                                <div id="button-autotranslate" class="onoffswitch">
                                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" autocomplete="off">
                                    <label class="onoffswitch-label" for="myonoffswitch">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div> 
                            </div>
                            <div style="float: right; padding-top: 9px; color: #eee; "><?php echo Lang::get('website.auto-translate') ?></div>
                        </li>
                        <li class="dropdown pull-right" id="lang-selector">
                            <a href="#" data-toggle="dropdown" role="button" id="lang-<?php echo LANG ?>" class="dropdown-toggle"><span class="flag <?php echo Session::get( 'language' ) ?>flag"></span> <img id="user-selected-language" src="/images/blank.png" class="flag flag-<?php echo LANG ?>" alt="<?php echo LANG ?>" /> <?php echo Lang::get('website.'.LANG ) ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=de<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-de" alt="Deutsch" /> Deutsch</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=et<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-et" alt="Deutsch" /> Eesti keel</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=en<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-en" alt="Deutsch" /> English</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=es<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-es" alt="Deutsch" /> Español</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=el<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-el" alt="Deutsch" /> Eλληνικά</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=fr<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-fr" alt="Deutsch" /> Français</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=it<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-it" alt="Deutsch" /> Italiano</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=lv<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-lv" alt="Deutsch" /> Latviešu valoda</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=tr<?php if (isset($_POST['search-term'])){echo '&search-term='.$_POST['search-term'];} ?>" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-tr" alt="Deutsch" /> Türkçe</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <header id="header" class="jumbotron">
            <div class="container">
                <a href="/#"><h1 class="pull-left hidden-phone">Organic.Edunet</h1></a>
                <form id="search-form" action="" class="pull-right">
                    <div class="input-group">
                        <input type="text" class="input-large" name="form-search" placeholder="<?php echo Lang::get('website.search') ?>" />
                        <span class="input-group-btn">
                            <button class="btn btn-large" type="submit">Go!</button>
                        </span>
                    </div>
                </form>
                <nav class="hidden-phone">
                    <ul class="list-inline">
                        <li><a href="#"><?php echo Lang::get('website.home') ?></a></li>
                        <li><a href="#/navigation"><?php echo Lang::get('website.navigational_search') ?></a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- HOME PAGE -->
        <div id="page-home">

            <!-- Banner section -->
            <div id="home-banner">
                <div class="container">
                    <a href="http://greenideasproject.org/" target="_blank"><img alt="green ideas 2013" src="/images/home-green-ideas.jpg"></a>
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
                                    <figure class="hidden-phone">
                                        <a href="<?php echo $resource->url ?>">
                                            <img class="img-thumbnail" src="/images/organic-edunet-resource-logo.jpeg" border="1" alt="Preview by Thumbshots.com" />
                                            <!--<img class="img-thumbnail" src="http://images.thumbshots.com/image.aspx?cid=QtStE4McALo%3d&v=1&w=140&url=<?php echo $resource->url ?>" border="1" alt="Preview by Thumbshots.com" />-->
                                        </a>
                                    </figure>
                                    <h3><a href="<?php echo $resource->url ?>" onclick="target='_blank'" class="translation-text"><?php echo$resource->title ?></a></h3>
                                </header>
                                <p><span class="translation-text"><?php echo $resource->description ?>...</span> <a class="label label-primary moreinfo" href="/#/resource/<?php echo $resource->FK_general ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo Lang::get('website.more_info') ?></a></p>
                                <footer>
                                    <p><?php echo Lang::get('website.rate') ?>: <span class="grnet-rating" data-resource="<?php echo $resource->url ?>"></span></p>
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
                                                <img width="100%" src="/images/organic-edunet-resource-logo.jpeg" border="1" alt="Preview by Thumbshots.com" />
                                                <!--<img class="img-thumbnail" src="http://images.thumbshots.com/image.aspx?cid=QtStE4McALo%3d&v=1&w=300&url=<?php echo $resource->url ?>" border="1" alt="Preview by Thumbshots.com" />-->
                                            </a>
                                        </figure>
                                        <h3><a href="<?php echo $resource->url ?>" onclick="target='_blank'" class="translation-text"><?php echo $resource->title ?></a></h3>
                                    </header>
                                    <p><span class="translation-text"><?php echo $resource->description ?>...</span> <a class="label label-primary moreinfo" href="/#/resource/<?php echo $resource->FK_general ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo Lang::get('website.more_info') ?></a></p>
                                    <footer>
                                        <p><?php echo Lang::get('website.rate') ?>: <span class="grnet-rating" data-resource="<?php echo $resource->url ?>"></span></p>
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

        <!-- NAVIGATIONAL SEARCH PAGE -->
        <div id="page-navigational">
            <div class="container">
                <div class="row">
                    <div id="flash"></div>
                </div>
            </div>
        </div>
        <!-- NAVIGATIONAL SEARCH PAGE -->

        <!-- SEARCH PAGE -->
        <div id="page-app">
            <div class="container">
                <div class="row">
                    <div id="search-content">
                        <aside id="app-content-filters" class="col col-lg-3 hidden-phone">
                        </aside>
                        <div id="app-content-info" class="col col-lg-9">
                            <div class="jquery-results-bar pull-left">
                                <?php echo Lang::get('website.results') ?> 
                                <span id="jquery-results-first">1</span> -
                                <span id="jquery-results-last">10</span> <?php echo Lang::get('website.of') ?> 
                                <span id="jquery-results-total">983</span>
                            </div>
                            <div class="search-results-per-page pull-right">
                                <span><?php echo Lang::get('website.results_per_page') ?>:</span>
                                <ul class="organic-dropdown list-unstyled">
                                    <li id="results-per-page" class="dropdown">
                                        <a href="#" data-toggle="dropdown" role="button" id="lang-<?php echo LANG ?>" class="dropdown-toggle">
                                            10
                                            <span class="glyphicon glyphicon-chevron-down"></span>
                                        </a>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a href="#10">10</a></li>
                                            <li><a href="#20">20</a></li>
                                            <li><a href="#50">50</a></li>
                                            <li><a href="#100">100</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="content-filters-bar" class="col col-lg-9">
                            <p><strong><?php echo Lang::get('website.filters') ?>:</strong> <span><?php echo Lang::get('website.none') ?></span></p>
                        </div>
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
                    <div class="col col-lg-9 col-offset-3" style="margin-top: 15px; ">
                        <span class="glyphicon glyphicon-arrow-left"></span> <a href="#" onclick="window.history.back(); return false;"><?php echo Lang::get('website.back') ?></a>
                    </div>
                    <aside class="col col-lg-3 hidden-phone">
                    </aside>
                    <article id="resource-viewport" class="col col-lg-9">
                    </article>
                </div>
            </div>
        </div>
        <!-- END VIEW RESOURCE PAGE -->

        <!-- REGISTER NEW ACCOUNT PAGE -->
        <div id="page-register-user">
            <div class="container">
                <div class="row">
                    <div>
                        <form id="register-new-user" class="form-horizontal">
                            <legend><?php echo Lang::get('website.register_a_new_user') ?></legend>
                            <div class="control-group">
                                <label class="control-label" for="form-register-username"><?php echo Lang::get('website.username') ?></label>
                                <div class="controls">
                                    <input type="text" id="form-register-username" name="form-register-username">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-register-email"><?php echo Lang::get('website.email') ?></label>
                                <div class="controls">
                                    <input type="text" id="form-register-email" name="form-register-email">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-register-password"><?php echo Lang::get('website.password') ?></label>
                                <div class="controls">
                                    <input type="password" id="form-register-password" name="form-register-password">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="form-register-repeat-password"><?php echo Lang::get('website.repeat_password') ?></label>
                                <div class="controls">
                                    <input type="password" id="form-register-repeat-password" name="form-register-repeat-password">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <button type="submit" class="btn" id="form-register-submit"><?php echo Lang::get('website.register') ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END REGISTER NEW ACCOUNT PAGE -->

        <footer id="footer">
            <div class="container">
                <p style="margin-right: 15px; ">&copy; Organic.Edunet 2013</p>
            </div>
        </footer>

        <script id="resource-content-full" type="text/template">
            <header>
                <figure class="hidden-phone">
                    <img class="img-thumbnail" src="/images/organic-edunet-resource-logo.jpeg" border="1" alt="Preview by Thumbshots.com" />
                    <!--<img class="img-thumbnail" src="http://images.thumbshots.com/image.aspx?cid=QtStE4McALo%3d&v=1&w=140&url=<%= location %>" border="1" alt="Preview by Thumbshots.com" />-->
                </figure>
                <h2 class="resource-title"><a href="<%= location %>" target="_blank"><%= texts[metadata_language].title %></a></h2>
                <small><?php echo Lang::get('website.resource_language') ?>
            <% for ( var i in napa_langs ){ %>
                <span class="resourcelang"><img src="/images/blank.png" class="flag flag-<%= napa_langs[i] %>" alt="<%= lang(napa_langs[i]) %>" /> <%= lang(napa_langs[i]) %></span>
            <% } %>
                </small>
            </header>
            <p><span class="resource-description"><% if ( texts[metadata_language].description ){ %><%= texts[metadata_language].description %><% } %></span></p>
            <footer>
                <hr/>
                <ul class="list-unstyled">
                    <li><strong><?php echo Lang::get('website.age_rage_context') ?>:</strong> <%= age_range.trim() != '' ? age_range : lang('none') %></li>
                    <li class="grnet-rating">
                        <strong><?php echo Lang::get('website.rate') ?>:</strong>
                    </li>
                    <li class="search-result-keywords clearfix"><strong><?php echo Lang::get('website.keywords') ?>:</strong> 
                        <% if ( !!texts[metadata_language].keywords && texts[metadata_language].keywords.length > 0 ){ %>
                            <% for ( var i in texts[metadata_language].keywords ){ %>
                            <%= texts[metadata_language].keywords[i] %>,
                            <% } %>
                        <% }else{ %>
                            <%= lang('none') %>
                        <% } %>
                    </li>
                    <li class="clearfix">
                        <strong><?php echo Lang::get('website.abstracts_language') ?>:</strong>
                        <ul class="resource-change-lang organic-dropdown list-unstyled" style="display: inline; " data-lang="<%= metadata_language %>">
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" role="button" class="dropdown-toggle">
                                    <span class="glyphicon glyphicon-user"></span>
                                    <%= lang(metadata_language) %> (<%= lang(texts[metadata_language].type) %>)
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                </a>
                                <ul class="dropdown-menu">
                                <% for ( var i in texts ){ %>
                                    <li class="<%= texts[i].type_class %> list-unstyled"> 
                                        <a class="lang-select-<%= texts[i].lang %>" href="#">
                                            <span class="glyphicon glyphicon-user"></span>
                                            <%= lang(i) %> (<%= lang(texts[i].type) %>)
                                        </a>
                                    </li>
                                <% } %>
                                </ul>
                            </li>
                        </ul>
                        <a href="#" data-location="<%= entry %>" data-id="<%= id %>" onclick="return false;" data-toggle="tooltip" class="ugc-widget"> <span class="glyphicon glyphicon-info-sign"></span> <?php echo Lang::get('website.improve_translation'); ?></a>
                    </li>
                </ul>
            </footer>
        </script>

        <script id="resource-content" type="text/template">
            <header>
                <figure class="hidden-phone">
                    <img class="img-thumbnail" src="/images/organic-edunet-resource-logo.jpeg" border="1" alt="Preview by Thumbshots.com" />
                    <!--<img class="img-thumbnail" src="http://images.thumbshots.com/image.aspx?cid=QtStE4McALo%3d&v=1&w=140&url=<%= location %>" border="1" alt="Preview by Thumbshots.com" />-->
                </figure>
                <h2 class="resource-title"><a href="<%= location %>" target="_blank"><%= texts[metadata_language].title %></a></h2>
                <small><?php echo Lang::get('website.resource_language') ?>
            <% for ( var i in napa_langs ){ %>
                <span class="resourcelang"><img src="/images/blank.png" class="flag flag-<%= napa_langs[i] %>" alt="<%= lang(napa_langs[i]) %>" /> <%= lang(napa_langs[i]) %></span>
            <% } %>
                </small>
            </header>
                <p><span class="resource-description"><% if ( texts[metadata_language].description ){ %><%= texts[metadata_language].description.substr(0,200).trim() %><% } %></span>... <a class="label label-primary moreinfo" href="/#/resource/<%= id %>"><span class="glyphicon glyphicon-plus"></span> <?php echo Lang::get('website.more_info') ?></a></p>
            <footer>
                <hr/>
                <ul class="list-unstyled">
                    <li><strong><?php echo Lang::get('website.age_rage_context') ?>:</strong> <%= age_range.trim() ? age_range : lang('none') %></li>
                    <li class="grnet-rating">
                        <strong><?php echo Lang::get('website.rate') ?>:</strong>
                    </li>
                    <li class="search-result-keywords clearfix"><strong><?php echo Lang::get('website.keywords') ?>:</strong> 
                        <% if ( !!texts[metadata_language].keywords && texts[metadata_language].keywords.length > 0 ){ %>
                            <% for ( var i in texts[metadata_language].keywords ){ %>
                            <a class="label" href="/browser/keyword/<%= texts[metadata_language].keywords[i] %>"><%= texts[metadata_language].keywords[i] %></a>
                            <% } %>
                        <% }else{ %>
                            <%= lang('none') %>
                        <% } %>
                    </li>
                    <li class="clearfix">
                        <strong><?php echo Lang::get('website.abstracts_language') ?>:</strong>
                        <ul class="resource-change-lang organic-dropdown list-unstyled" style="display: inline; " data-lang="<%= metadata_language %>">
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" role="button" class="dropdown-toggle">
                                    <span class="glyphicon glyphicon-user"></span>
                                    <%= lang(metadata_language) %> (<%= lang(texts[metadata_language].type) %>)
                                    <span class="glyphicon glyphicon-chevron-down"></span>
                                </a>
                                <ul class="dropdown-menu">
                                <% for ( var i in texts ){ %>
                                    <li class="<%= texts[i].type_class %> list-unstyled"> 
                                        <a class="lang-select-<%= texts[i].lang %>" href="#">
                                            <span class="glyphicon glyphicon-user"></span>
                                            <%= lang(i) %> (<%= lang(texts[i].type) %>)
                                        </a>
                                    </li>
                                <% } %>
                                </ul>
                            </li>
                        </ul>
                        <a href="#" data-location="<%= entry %>" data-id="<%= id %>" onclick="return false;" data-toggle="tooltip" class="ugc-widget"> <span class="glyphicon glyphicon-info-sign"></span> <?php echo Lang::get('website.improve_translation'); ?></a>
                    </li>
                </ul>
            </footer>
        </script>

        <script id="grnet-rating" type="text/template">
            <a onclick="return false;" data-toggle="tooltip" class="grnet-rating-tooltip" href="#"><% for ( var i = 0 ; i < rating ; i++ ){ %><img src="/images/full_star.png" class="grnet-rating-star star-value-<%= i %>"><% } %><% for ( var i = rating ; i < 5 ; i++ ){ %><img src="/images/empty_star.png" class="grnet-rating-star star-value-<%= i %>"><% } %></a>
               <%= lang('of') %>
            <span class="grnet-rating-num-votes"><%= votes %></span> <%= lang('votes') %>
            <!--<a  onclick="return false;" data-toggle="popover" class="grnet-rating-info" href="#"><span class="glyphicon glyphicon-expand"> </span></a></span>-->
            <span class="rating-history dropdown">
                <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
                    <?php echo Lang::get('website.view_rating_history'); ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu" style="padding: 5px; font-size: 11px; "></ul>
            </span>
        </script>

        <script id="grnet-rating-stars" type="text/template">
            <li>
                <% for ( var i = 0 ; i < ratingMean ; i++ ){ %><img src="/images/full_star.png" class="grnet-rating-star star-value-<%= i %>"><% } %><% for ( var i = ratingMean ; i < 5 ; i++ ){ %><img src="/images/empty_star.png" class="grnet-rating-star star-value-<%= i %>"><% } %>
            </li>
        </script>

        <script id="facets-content" type="text/template">
            <div class="accordion-heading">
                <span class="glyphicon glyphicon-chevron-down pull-left"></span>
                <a id="collapse-click-<%= name %>" class="accordion-toggle" data-toggle="collapse" data-parent="#app-content-filters-accordion" href="#collapse-<%= name %>" title="<%= name %>">
                    <%= lang(name) %>
                </a>
            </div>
        </script>

        <script id="facets-filter" type="text/template">
            <input type="checkbox" id="checkbox-<%= filter.replace(' ','-') %>" name="checkbox-<%= filter.replace(' ','-') %>" <% if ( active ) { %>checked="checked"<% } %>/>
            <label for="checkbox-<%= filter.replace(' ','-') %>"><span></span> <a title="<%= filter %>"><%= translation %></a></label>
            <span class="label pull-right hidden-tablet hidden-phone"><%= value %></span>
        </script>

        <script id="search-pagination" type="text/template">
            <ul class="pagination">

            <% if ( page > 1 ) { %>
              <li><a href="/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= 1 %>"><%= lang('first') %></a></li>
            <% } %>

            <% if ( page > 1 ) { %>
              <li><a href="/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= page-1 %>">&laquo;</a></li>
            <% } %>

            <% for ( var i = startPage ; i <= page+numPagLinks && i <= totalPages ; i++ ){ %>
              <li <% if ( i == page ) { %>class="disabled"<% } %>><a href="/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= i %>"><%= i %></a></li>
            <% } %>

            <% if ( page < totalPages ) { %>
              <li><a href="/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= page+1 %>">&raquo;</a></li>
            <% } %>

            <% if ( page < totalPages ) { %>
              <li><a href="/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= totalPages %>"><%= lang('last') %></a></li>
            <% } %>

            </ul>
        </script>

        <!-- Navigational search -->
        <script type="text/javascript" src="http://oe.dynalias.net/components/com_navigational/moritz/swfobject.js"></script>
        <script type="text/javascript">
            var ontResourcesURI;
            var ontResources;
            var labels;
            var predicate = 'null';
            var ipCounter = 0;
            var advancedOptionsOpened = false;
            var inclusiveSearch = true;
            var descriptionLimit = 300;
            var titleLimit = 68;

            ///////////////////
            // MORITZ STUFF //
            /////////////////
            var URL='/semanticsearch.swf?treelang=<?php echo LANG ?>';
            var flashID = 'flash';          
            var width = '100%';
            var height = '500';
            var flashVersion = '10.0.0';
            var expressInstallURL = 'http://oe.dynalias.net/components/com_navigational/moritz/expressInstall.swf';            
            var params = {};
            var attributes = {};

            var flashvars = 
            {
                baseURL: 'http://oe.dynalias.net/', 
                locale: 'en',
                JSCallBack_selectionChange: 'onSelectionChange',
                JSCallBack_searchPointUpdate: 'onSearchPointUpdate'
            };

            function onSelectionChange(selectedNodes){
                Box.set('page', 1);
                Router.navigate('#/navigation/1');
                renderAdvancedOptions($);
            }

            function getFlashMovie(movieName) {
                   var isIE = navigator.appName.indexOf('Microsoft') != -1;
                   return (isIE) ? window[movieName] : document[movieName];
            }

            function renderAdvancedOptions($)
            {     
                $.ajax({
                    url: 'http://oe.dynalias.net/indexa.php?option=com_navigational&tmpl=component&task=getState&format=raw',
                    async: false,
                    jsonpCallback: 'jsonCallback',
                    contentType: "application/json",
                    dataType: 'jsonp',
                    success: function(data) 
                    {
                        doSearch.submitNavigational();
                    },
                    error: function(e) {
                    }
                });
            }

            function initInterface ( $ )
            {
                /*var request = $.getJSON('http://oe.dynalias.net/indexa.php?option=com_navigational&tmpl=component&task=listOntResourcesTranslated&format=raw');
                request.done(function(){
                   renderAdvancedOptions($);
                }).fail(function(){
                   $('#page-navigational .row').html('<div class="alert alert-danger col col-lg-8 col-offset-4">Navigational Search unavailable.</div>');
                   console.log('fail',arguments);
                });*/
                try{
                    $.ajax({
                        url: 'http://oe.dynalias.net/indexa.php?option=com_navigational&tmpl=component&task=listOntResourcesTranslated&format=raw',
                        async: false,
                        jsonpCallback: 'jsonCallback',
                        contentType: "application/json",
                        dataType: 'jsonp',
                        success: function(data) 
                        {
                            renderAdvancedOptions($);
                        },
                        error: function(e) 
                        {
                        }
                    });
                }catch(e){
                }
            }
        </script>
        <!-- jQuery + Bootstrap -->
        <script src="js/jquery.js"></script>
        <script src="js/vendor/bootstrap/bootstrap.js"></script>
        <!-- Activate IE8 responsive features -->
        <!--<script src="js/respond.js"></script>-->
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
        <!--Default language file -->
        <script src="js/lang/<?php echo LANG ?>.js"></script>

        <script>
            //$.ajaxSetup({ cache: false });

            // Wait for search request
            var Box = new App.Models.App();
            var filtersBarView = new App.Views.FiltersBar({ collection: Box.get('filters') });
            var searchBarInfo = new App.Views.SearchInfoBar();
            Box.set('langFile', lang_file);
            var doSearch = new App.Views.DoSearch();
            var doLogin = new App.Views.LoginForm();
            var autoTranslate = new App.Views.Autotranslate();

            // Router + History
            Router = new App.Router;
            Backbone.history.start();
        </script>

        <script>
        <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] ): ?>
            $('html').on('click', '.ugc-widget', function(event){
                event.preventDefault();
                var WIDGET_HOST = 'http://organiclingua.know-center.tugraz.at/';
                var path_js = '/UGC/ugc-widget-server/';

                var lang = $(this).parents('article').find('.resource-change-lang').attr('data-lang');
                var type_text = $(this).parents('article').find('.resource-change-lang').find('li > a').html();
                alert(type_text);
                var action = !!type_text.match(/human/gi) ? 'edit' : 'translate';
                alert(action);
                try {
                    var x = document.createElement("SCRIPT");
                    x.type = "text/javascript";
                    x.src = WIDGET_HOST + path_js + "loadUGC.js";
                    if ( action == 'edit'){
                        // CORRECT
                        x.setAttribute("Language", lang);
                    }else{
                        //TRANSLATE
                        x.setAttribute("sourceLanguage", 'en');
                        x.setAttribute("targetLanguage", lang); 
                    }
                    x.setAttribute('Name', '<?php echo $_user->user_username ?>');
                    x.setAttribute('Username', '<?php echo $_user->user_username ?>');
                    x.setAttribute('Email', '<?php echo $_user->user_email ?>');
                    x.setAttribute('Operation', action);
                    x.setAttribute('id', 'LOMWidget');
                    x.setAttribute("LOMID", $(this).attr('data-id'));
                    x.setAttribute("LOMLocation", 'http://oe.dynalias.net/harvested_files/oai_scam_'+$(this).attr('data-location').replace(/oai:scam[.]kmr[.]se:/,'').replace( /[:\/.]/g, '_' ).replace( /\?/g, '@')+'.xml');
                    document.getElementsByTagName("head")[0].appendChild(x);
                }catch(e){
                    alert(e.getMessage());
                }
            })
        <?php else: ?>
            $('#app-content-results, #resource-viewport').tooltip({
                selector: '.ugc-widget',
                title: '<?php echo Lang::get('website.log_in_or_register_for_improving_translation') ?>'
            });
            $('body').tooltip({
                selector: '.grnet-rating-tooltip',
                title:'<?php echo Lang::get('website.log_in_or_register_for_rating') ?>'
            });
        <?php endif; ?>
        </script>

        <script>
            $.fn.serializeObject = function()
            {
                var o = {};
                var a = this.serializeArray();
                $.each(a, function() {
                    if (o[this.name] !== undefined) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };

            $('#form-register-submit').click(function (e) {
                $.ajax({
                    url: '/api/organic/register',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#register-new-user').serializeObject(), 
                    success: function(response) {
                        if ( response.success ){
                            alert(response.message);
                            document.location.href = '/';
                        }else{
                            alert(response.message);
                        }
                    }
                });
                return false;
            })
        </script>
    </body>
</html>