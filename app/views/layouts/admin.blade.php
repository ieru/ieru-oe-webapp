<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Organic Edunet Admin Zone</title>
        <link href="/css/_app.css" rel="stylesheet" media="screen">
    </head>

    <body>
        
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <a class="navbar-brand" href="/#/">Organic.Edunet</a>

                <div class="nav-collapse collapse">
                    <ul id="user-zone" class="nav navbar-nav">
                    <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] <> '' AND @is_object( AdminController::$_user ) ): ?>
                        <li role="menu" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome, Admin <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_ADMIN_ZONE ) ): ?>
                                <li role="presentation"><a href="/admin/"><span class="glyphicon glyphicon-cog"></span> <?php echo Lang::get('website.adminzone'); ?></a></li>
                                <?php endif; ?>
                                <li class="divider" role="presentation"></li>
                                <li role="presentation"><a href="#" id="user-logout"><span class="glyphicon glyphicon-off"></span> <?php echo Lang::get('website.logout'); ?></a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li id="user-login" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Lang::get('website.sign_in') ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <form id="login-form" action="/#/search/">
                                        <div class="control-group">
                                            <div class="controls">
                                                <input class="input-with-feedback" id="login-form-username" type="text" placeholder="<?php echo Lang::get('website.user') ?>"/>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">
                                                <input class="input-with-feedback" id="login-form-password" type="password" placeholder="<?php echo Lang::get('website.password') ?>"/>
                                            </div>
                                        </div>
                                        <button id="submit-login-form" type="submit" class="btn btn-primary"><?php echo Lang::get('website.submit') ?></button>
                                        <!--<p class="divider" role="presentation"></p>
                                        <p><a href="#/user/retrieve"><?php echo Lang::get('website.forgot_password') ?></a></p>-->
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li><a href="/#/user/register"><?php echo Lang::get('website.register'); ?></a></li>
                    <?php endif; ?>
                    </ul>
                    <ul class="nav navbar-nav pull-right">
                        <li style="margin-right: 15px; ">
                            <div style="margin-left: 10px; float: right; padding-top: 9px; ">
                                <div class="onoffswitch" id="button-autotranslate">
                                    <input type="checkbox" autocomplete="off" id="myonoffswitch" class="onoffswitch-checkbox" name="onoffswitch">
                                    <label for="myonoffswitch" class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                        <div class="onoffswitch-switch"></div>
                                    </label>
                                </div> 
                            </div>
                            <div style="float: right; padding-top: 9px; color: #eee; "><?php echo Lang::get('website.auto-translate'); ?></div>
                        </li>
                        <li class="dropdown pull-right" id="lang-selector">
                            <a href="#" data-toggle="dropdown" role="button" id="lang-<?php echo LANG ?>" class="dropdown-toggle"><span class="flag <?php echo Session::get( 'language' ) ?>flag"></span> <img id="user-selected-language" src="/images/blank.png" class="flag flag-<?php echo LANG ?>" alt="<?php echo LANG ?>" /> <?php echo Lang::get('website.'.LANG ) ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=de" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-de" alt="Deutsch" /> Deutsch</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=et" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-et" alt="Eesti keel" /> Eesti keel</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=en" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-en" alt="English" /> English</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=es" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-es" alt="Español" /> Español</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=el" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-el" alt="Eλληνικά" /> Eλληνικά</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=fr" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-fr" alt="Français" /> Français</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=it" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-it" alt="Italiano" /> Italiano</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=lv" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-lv" alt="Latviešu valoda" /> Latviešu valoda</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=tr" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-tr" alt="Türkçe" /> Türkçe</a></li>
                                <li role="presentation"><a href="<?php echo @$_SERVER['REDIRECT_URL'] ?>?lang-selector=pl" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-pl" alt="Polski" /> Polski</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <header id="header">
            <div class="container">
                <a href="/#/">
                    <h1 class="pull-left hidden-sm" style="position: relative; ">
                        Organic.Edunet
                        <small style="position: absolute; bottom: 10px; left: 102px; font-size: 18px; "><?php echo Lang::get('website.website_motto') ?></small>
                    </h1>
                </a>
                <form id="search-form" action="" class="pull-right">
                    <div id="search-form-div">
                        <div class="input-group">
                            <input id="form-search" autocomplete="off" type="text" name="form-search" placeholder="<?php echo Lang::get('website.search') ?>" />
                            <span class="input-group-btn">
                                <button class="btn" type="submit">Go!</button>
                            </span>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="#" id="dropdownMenu2" class="dropdown-toggle" role="button" data-toggle="dropdown"><?php echo Lang::get('website.advanced_options') ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
                            <li><input id="search-checkbox-monolingual" type="checkbox" /> <label for="search-checkbox-monolingual"> <?php echo Lang::get('website.monolingual'); ?></label></li>
                            <li><input id="search-checkbox-prfexpansion" type="checkbox" /> <label for="search-checkbox-prfexpansion"> <?php echo Lang::get('website.pseudo-feedback'); ?></label></li>
                            <li><input id="search-checkbox-semanticexpansion" type="checkbox" /> <label for="search-checkbox-semanticexpansion"> <?php echo Lang::get('website.semantic_expansion'); ?></label></li>
                            <li>
                                <label for="search-checkbox-autolangidentification" style="margin-left: 16px; "> <?php echo Lang::get('website.automatic_language_identification'); ?></label>
                                <ul id="autolangidentification-dropdown" class="organic-dropdown list-unstyled">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" id="autolangidentifier" role="button" data-toggle="dropdown" href="javascript:;" data-lang="guess" onclick="$(this).parent().toggleClass('open');"><?php echo Lang::get('website.guess_language'); ?> <span class="glyphicon glyphicon-chevron-down"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#guess"><?php echo Lang::get('website.guess_language'); ?></a></li>
                                            <li><a href="#de"><img src="/images/blank.png" class="flag flag-de" alt="Deutsch" /> Deutsch</a></li>
                                            <li><a href="#et"><img src="/images/blank.png" class="flag flag-et" alt="Eesti keel" /> Eesti keel</a></li>
                                            <li><a href="#en"><img src="/images/blank.png" class="flag flag-en" alt="English" /> English</a></li>
                                            <li><a href="#es"><img src="/images/blank.png" class="flag flag-es" alt="Español" /> Español</a></li>
                                            <li><a href="#el"><img src="/images/blank.png" class="flag flag-el" alt="Eλληνικά" /> Eλληνικά</a></li>
                                            <li><a href="#fr"><img src="/images/blank.png" class="flag flag-fr" alt="Français" /> Français</a></li>
                                            <li><a href="#it"><img src="/images/blank.png" class="flag flag-it" alt="Italiano" /> Italiano</a></li>
                                            <li><a href="#lv"><img src="/images/blank.png" class="flag flag-lv" alt="Latviešu valoda" /> Latviešu valoda</a></li>
                                            <li><a href="#tr"><img src="/images/blank.png" class="flag flag-tr" alt="Türkçe" /> Türkçe</a></li>
                                            <li><a href="#pl"><img src="/images/blank.png" class="flag flag-pl" alt="Polski" /> Polski</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </form>
                <nav class="hidden-sm">
                    <ul class="list-inline">
                        <li><a href="/#/"><?php echo Lang::get('website.home') ?></a></li>
                        <!--<li><a href="/#/navigation"><?php echo Lang::get('website.navigational_search') ?></a></li>-->
                    <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] <> '' AND @is_object( AdminController::$_user ) ): ?>
                        <li><a href="/#/suggest"><?php echo Lang::get('website.suggest_a_new_resource') ?></a></li>
                        <li><a href="/#/recommended"><?php echo Lang::get('website.menu_recommendations') ?></a></li>
                    <?php endif; ?>
                        <li><a href="/#/about"><?php echo Lang::get('website.about') ?></a></li>
                        <li><a href="/#/feedback"><?php echo Lang::get('website.feedback') ?></a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div class="container">
            <div id="admin-view" class="row">

                <div id="admin-view-aside" class="col-lg-4">
                    <div class="well" style="padding: 0">
                        <ul class="nav nav-list">
                        <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES ) ): ?>
                            <li class="nav-header">Edit language files</li>
                            <li><a href="/admin/langfiles">Web app skeleton (php)</a></li>
                            <li><a href="/admin/langfilesjs">Loaded with javascript</a></li>
                            <li><a href="/admin/langfilessuggest">Suggest section</a></li>
                            <li><a href="/admin/langerror">Error codes</a></li>
                        <?php endif; ?>
                        <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_AGINFRA_DATA ) ): ?>
                            <li class="nav-header">Statistics</li>
                            <li><a href="/admin/term-trends">Term Trends</a></li>
                            <li><a href="/admin/metadata-statistics">Metadata Statistics</a></li>
                            <li><a href="/admin/other-services">Other Services</a></li>
                        <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <div id="admin-view-main" class="col-lg-8">
                    <div class="row">

                        @yield('content')
                        
                    </div>
                </div>
            </div>
        </div>

        <footer id="footer">
            <div class="container">
                <ul class="pull-left list-unstyled">
                </ul>
                <p>&copy; Organic.Edunet 2013</p>
            </div>
        </footer>

        <script src="/js/jquery.js"></script>
        <script src="/js/vendor/bootstrap/bootstrap.js"></script>
        <script>
            var $window = $(window);
            $('#save-button').affix({
            });
        </script>
    </body>
</html>