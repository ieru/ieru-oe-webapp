<!DOCTYPE html>
<html lang="<?php echo LANG ?>">
    <head>
        <?php define( 'VERSION', '0.2.11' );?>
        <title>Organic.Edunet</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="/css/_app.css" rel="stylesheet" media="screen">

        <!-- ajax parsing activation for google -->
        <meta name="fragment" content="!">

        <!-- iOS web app configuration -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black-transparent" /> 
        <link rel="apple-touch-icon" href="/images/ios-icon.png"/>
        <!--<link rel="apple-touch-startup-image" href="img/splash.png" />-->
    </head>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <a class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <a class="navbar-brand" href="/<?php echo LANG ?>/#/">Organic.Edunet</a>

                <div class="nav-collapse collapse">
                    <ul id="user-zone" class="nav navbar-nav">
                    <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] <> '' AND @is_object( $_user ) ): ?>
                        <li role="menu" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Lang::get('website.welcome'); ?>, <span id="user-username"><?php echo  $_user->user_username ?></span><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li role="presentation"><a data-toggle="modal" href="#change-account"><span class="glyphicon glyphicon-wrench"></span> <?php echo Lang::get('website.change_account_details'); ?></a></li>
                                <li role="presentation"><a data-toggle="modal" href="#suggest-modal"><span class="glyphicon glyphicon-leaf"></span> <?php echo Lang::get('website.suggest_a_new_resource'); ?></a></li>
                                <li role="presentation"><a data-toggle="modal" href="#" class="ugc-widget-own"><span class="glyphicon glyphicon-pencil"></span> <?php echo Lang::get('website.view_own_resources'); ?></a></li>
                                <?php if ( $_user->check_permission( PERMISSION_ACCESS_ADMIN_ZONE ) ): ?>
                                <li class="divider" role="presentation"></li>
                                <li role="presentation"><a href="/<?php echo LANG ?>/admin/"><span class="glyphicon glyphicon-cog"></span> <?php echo Lang::get('website.adminzone'); ?></a></li>
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
                                    <form id="login-form" action="">
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
                                        <p class="divider" role="presentation"></p>
                                        <p><a href="#/user/retrieve"><?php echo Lang::get('website.forgot_password') ?></a></p>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li><a href="/<?php echo LANG ?>/#/user/register"><?php echo Lang::get('website.register'); ?></a></li>
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
                                <li role="presentation"><a href="/de/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-de" alt="Deutsch" /> Deutsch</a></li>
                                <li role="presentation"><a href="/et/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-et" alt="Eesti keel" /> Eesti keel</a></li>
                                <li role="presentation"><a href="/en/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-en" alt="English" /> English</a></li>
                                <li role="presentation"><a href="/es/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-es" alt="Español" /> Español</a></li>
                                <li role="presentation"><a href="/el/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-el" alt="Eλληνικά" /> Eλληνικά</a></li>
                                <li role="presentation"><a href="/fr/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-fr" alt="Français" /> Français</a></li>
                                <li role="presentation"><a href="/it/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-it" alt="Italiano" /> Italiano</a></li>
                                <li role="presentation"><a href="/lv/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-lv" alt="Latviešu valoda" /> Latviešu valoda</a></li>
                                <li role="presentation"><a href="/tr/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-tr" alt="Türkçe" /> Türkçe</a></li>
                                <li role="presentation"><a href="/pl/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-pl" alt="Polski" /> Polski</a></li>
                                <li role="presentation"><a href="/ar/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-sa" alt="Arabic" /> العربية</a></li>
                                <li role="presentation"><a href="/ru/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-ru" alt="Russian" /> Русский язык</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <header id="header">
            <div class="container">
                <a href="/<?php echo LANG ?>/#/">
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
                                            <li><a href="#ar"><img src="/images/blank.png" class="flag flag-sa" alt="Arabic" /> العربية</a></li>
                                            <li><a href="#ru"><img src="/images/blank.png" class="flag flag-ru" alt="Russian" /> Русский язык</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </form>
                <nav style="height: 40px; overflow: hidden; " class="hidden-sm">
                    <ul class="list-inline">
                        <li><a href="/<?php echo LANG ?>/#/"><?php echo Lang::get('website.home') ?></a></li>
                    <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] <> '' AND @is_object( $_user ) ): ?>
                        <li><a href="/<?php echo LANG ?>/#/suggest"><?php echo Lang::get('website.suggest_a_new_resource') ?></a></li>
                        <li><a href="/<?php echo LANG ?>/#/recommended"><?php echo Lang::get('website.menu_recommendations') ?></a></li>
                    <?php endif; ?>
                        <li><a href="/<?php echo LANG ?>/#/about"><?php echo Lang::get('website.about') ?></a></li>
                        <li><a href="/<?php echo LANG ?>/#/feedback"><?php echo Lang::get('website.feedback') ?></a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- HOME PAGE -->
        <div id="page-home">

            <!-- Banner section -->
            <div id="home-banner">
                <div class="container">
                    <div id="carousel-example-generic" class="carousel slide">
                    </div>
                </div>
            </div>

            <!-- Sections -->
            <div class="container">
                <div class="row sections-categories">
                </div>
            </div>

            <!-- Main content section -->
            <div class="container">
                <div class="row">
                    <div id="home-content">
                    </div>
                </div>
            </div>
        </div>
        <!-- END HOME PAGE -->

        <!-- SECTION PAGE -->
        <div id="page-section">

            <!-- Banner section -->
            <div id="home-banner">
                <div class="container">
                    <div id="carousel-example-generic" class="carousel slide">
                    </div>
                </div>
            </div>

            <!-- Sections -->
            <div class="container">
                <div class="row sections-categories">
                </div>
            </div>

            <!-- Themes -->
            <div class="container">
                <div class="row sections-themes">
                </div>
            </div>

        </div>
        <!-- END SECTION PAGE -->

        <!-- SEARCH PAGE -->
        <div id="page-app">
            <div class="container">
                <div class="row">
                    <div id="search-content">
                        <aside id="app-content-filters" class="col col-lg-3 hidden-sm">
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
                    <div class="col-lg-9 col-offset-3" style="margin-top: 15px; ">
                        <span class="glyphicon glyphicon-arrow-left"></span> <a href="#" onclick="window.history.back(); return false;"><?php echo Lang::get('website.back') ?></a>
                    </div>
                    <aside class="col-lg-3 hidden-sm">
                    </aside>
                    <section id="resource-full-content" class="col-lg-9">
                        <article id="resource-viewport" >
                        </article>
                        <hr/>
                        <div id="resource-recommendations">
                            <header>
                                <h2><?php echo Lang::get('website.recommended_resources') ?></h2>
                            </header>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <!-- ABOUT PAGE -->
        <div id="page-about">
            <div class="container">
                <div class="row">
                    <section class="col-lg-12">
                        <?php echo Lang::get('about.about') ?>
                    </section>
                </div>
            </div>
        </div>

        <!-- SUGGEST PAGE -->
        <div id="page-suggest">
            <div class="container">
                <div class="row">
                    <section class="col-lg-12">
                        <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] <> '' AND @is_object( $_user ) ): ?>
                        <div class="row" style="padding-top: 30px; ">
                            <p><?php echo Lang::get('suggest.line1') ?></p>
                            <p>
                                <a class="label label-info" id="organic-suggest-resource" href="
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
                                ">Bookmarklet</a>
                            </p>
                            <p><?php echo Lang::get('suggest.line2') ?></p>
                        </div>
                        <?php endif; ?>
                    </section>
                </div>
            </div>
        </div>

        <!-- FEEDBACK PAGE -->
        <div id="page-feedback">
            <form id="send-feedback" method="post" style="margin-top: 15px; ">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <legend><?php echo Lang::get('website.send_feedback') ?></legend>
                            <div class="control-group">
                                <label class="control-label"><?php echo Lang::get('website.name') ?></label>
                                <div class="controls">
                                    <input type="text" name="form-feedback-name" id="form-feedback-name">
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label"><?php echo Lang::get('website.email') ?></label>
                                <div>
                                    <input type="text" name="form-feedback-email">
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label"><?php echo Lang::get('website.feedback_type') ?></label>
                                <div>
                                    <select id="form-feedback-type" name="form-feedback-type">
                                        <option data-select="bug" value="Bug"><?php echo Lang::get('website.bug') ?></option>
                                        <option data-select="feature" value="Feature request"><?php echo Lang::get('website.feature_request') ?></option>
                                        <option data-select="comment" value="General comment"><?php echo Lang::get('website.general_comment') ?></option>
                                        <option data-select="inappropriate" value="Inappropriate resource"><?php echo Lang::get('website.report_resource_as_inappropriate') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label"><?php echo Lang::get('website.subject') ?></label>
                                <div>
                                    <input type="text" id="form-feedback-subject" name="form-feedback-subject">
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label"><?php echo Lang::get('website.body') ?></label>
                                <div>
                                    <textarea id="form-feedback-body" name="form-feedback-body" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="control-group" style="margin-top: 20px; ">
                                <div>
                                    <button type="submit" class="btn btn-default"><?php echo Lang::get('website.send_feedback') ?></button>
                                    <button type="reset" class="btn btn-default"><?php echo Lang::get('website.reset_form') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>


        <!-- REGISTER NEW ACCOUNT PAGE -->
        <div id="page-register-user-confirm">
            <div class="container">
                <div class="row" style="padding-top: 30px; ">

                </div>
            </div>
        </div>

        <!-- ACCEPT PASSWORD CHANGE-->
        <div id="page-change-password-confirm">
            <div class="container">
                <div class="row" style="padding-top: 30px; ">

                </div>
            </div>
        </div>

        <!-- RECOMMENDATIONS -->
        <div id="page-recommended">
            <div class="container">
                <div class="row clearfix" style="padding-top: 30px; height: 700px; " id="page-recommended-div">
                </div>
            </div>
        </div>

        <!-- PRIVACY NOTIFICATION -->
        <div id="page-privacy">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo Lang::get('legal.legal') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- REGISTER NEW ACCOUNT PAGE -->
        <div id="page-register-user">
            <form id="register-new-user" class="form-horizontal">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <legend><?php echo Lang::get('website.register_a_new_user') ?></legend>
                            <div class="control-group">
                                <label style="padding-top: 0 !important; " class="col col-lg-4 control-label" for="form-register-name"><?php echo Lang::get('website.name') ?></label>
                                <div class="col col-lg-8 controls">
                                    <input type="text" id="form-register-name" name="form-register-name">
                                </div>
                            </div>
                            <div class="control-group">
                                <label style="padding-top: 0 !important; " class="col col-lg-4 control-label" for="form-register-username"><?php echo Lang::get('website.username') ?></label>
                                <div class="col col-lg-8 controls">
                                    <input class="input-with-feedback" type="text" id="form-register-username" name="form-register-username">
                                </div>
                            </div>
                            <div class="control-group">
                                <label style="padding-top: 0 !important; " class="col col-lg-4 control-label" for="form-register-password"><?php echo Lang::get('website.password') ?></label>
                                <div class="col col-lg-8 controls">
                                    <input class="input-with-feedback" type="password" id="form-register-password" name="form-register-password">
                                </div>
                            </div>
                            <div class="control-group">
                                <label style="padding-top: 0 !important; " class="col col-lg-4 control-label" for="form-register-repeat-password"><?php echo Lang::get('website.repeat_password') ?></label>
                                <div class="col col-lg-8 controls">
                                    <input class="input-with-feedback" type="password" id="form-register-repeat-password" name="form-register-repeat-password">
                                </div>
                            </div>
                            <div class="control-group">
                                <label style="padding-top: 0 !important; " class="col col-lg-4 control-label" for="form-register-email"><?php echo Lang::get('website.email') ?></label>
                                <div class="col col-lg-8 controls">
                                    <input class="input-with-feedback" type="text" id="form-register-email" name="form-register-email">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="col col-lg-4 control-label">
                                </div>
                                <div class="col col-lg-8 controls" style="margin-bottom: 10px; ">
                                    <input type="checkbox" name="form-register-accept" class="input-with-feedback" id="form-register-accept"/> <a href="/<?php echo LANG ?>/#/privacy" target="_blank"><?php echo Lang::get('website.accept_use_terms_and_conditions') ?></a></button>
                                </div>
                            </div>
                            <div class="control-group">
                                <label style="padding-top: 0 !important; " class="col col-lg-4 control-label"></label>
                                <div class="col col-lg-8 controls">
                                    <button type="submit" class="btn btn-primary" id="form-register-submit"><?php echo Lang::get('website.register') ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- RETRIEVE PASSWORD -->
        <div id="page-retrieve-password">
            <div class="container">
                <div class="row">
                    <section class="col-lg-12">
                        <h2><?php echo Lang::get('website.retrieve_password') ?></h2>
                        <p><?php echo Lang::get('website.retrieve_password_text') ?></p>
                        <form class="col-lg-6">
                            <div class="control-group">
                                <label style="padding-top: 0 !important; " class="col col-lg-4 control-label" for="form-retrieve-email"><?php echo Lang::get('website.email') ?></label>
                                <div class="col col-lg-8 controls">
                                    <input class="input-with-feedback" type="text" id="form-retrieve-email" name="form-retrieve-email">
                                </div>
                            </div>
                            <div class="control-group" style="margin-top: 50px; ">
                                <label style="padding-top: 0 !important; " class="col col-lg-4 control-label"></label>
                                <div class="col col-lg-8 controls">
                                    <button type="submit" class="btn btn-primary" id="form-retrieve-submit"><?php echo Lang::get('website.retrieve_password') ?></button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>

        <!-- PAGE FOOTER -->
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <ul>
                            <li><a href="/<?php echo LANG ?>/#/"><?php echo Lang::get('website.home') ?></a></li>
                        <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] <> '' AND @is_object( $_user ) ): ?>
                            <li><a href="/<?php echo LANG ?>/#/suggest"><?php echo Lang::get('website.suggest_a_new_resource') ?></a></li>
                            <li><a href="/<?php echo LANG ?>/#/user/register"><?php echo Lang::get('website.register') ?></a></li>
                        <?php endif; ?>
                            <li><a href="/<?php echo LANG ?>/#/feedback"><?php echo Lang::get('website.feedback') ?></a></li>
                            <li><a href="/<?php echo LANG ?>/#/about"><?php echo Lang::get('website.about') ?></a></li>
                            <li><a href="/<?php echo LANG ?>/#/privacy"><?php echo Lang::get('website.privacy_policy') ?></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <p><?php echo Lang::get('website.footer_copyright_notice') ?></p>
                    </div>
                    <div class="col-lg-3">
                        <p>
                            <a href="http://ec.europa.eu/ict_psp">
                                <img width="100" src="http://www.organic-lingua.eu/images/stories/eu_emblem.jpg" alt="eu_emblem" height="67" style="margin-top: 10px; float: right;">
                                <img width="100" src="http://www.organic-lingua.eu/images/stories/logo_ict_psp.gif" alt="ICT Policy Support Programme (ICT PSP)" height="69" style="float: left; margin-top: 10px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: medium outset #ffffff;">
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

        <!-- MODALS -->
        <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] <> '' AND @is_object( $_user ) ): ?>
        <div class="modal fade" id="suggest-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><?php echo Lang::get('website.suggest_a_new_resource'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <p>Drag the following Bookmarklet to your bookmarks. To suggest a new resource, just go to the website you want to suggest
                            as a new resource, and click on the bookmarklet you just added.</p>
                        <p>
                            <a class="label label-info" id="organic-suggest-resource" href="
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
                            ">Bookmarklet</a>
                        </p>
                        <p>In the new window, fill in the fields and click on the "Send Suggestion" button when you are don.</p>
                    </div>
                    <!--<div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>-->
                </div>
            </div>
        </div>
        <div class="modal fade" id="change-account">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><?php echo Lang::get('website.change_account_details'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <form  class="form-horizontal row">
                            <h4><?php echo Lang::get('website.change_password') ?> <small>(only will be changed if not empty)</small></h4>
                            <div class="control-group">
                                <label class="col-lg-4 control-label" for="form-new-password"><?php echo Lang::get('website.password') ?></label>
                                <div class="col-lg-8 controls">
                                    <input class="input-with-feedback" type="password" id="form-new-password" name="form-new-password">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="col-lg-4 control-label" for="form-new-password-repeat"><?php echo Lang::get('website.repeat_new_password') ?></label>
                                <div class="col-lg-8 controls">
                                    <input class="input-with-feedback" type="password" id="form-new-password-repeat" name="form-new-password-repeat">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Lang::get('website.close') ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo Lang::get('website.save_changes') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- END MODALS -->

        <script id="resource-content-full" type="text/template">
            <header>
                <figure class="hidden-sm">
                    <img class="img-thumbnail" src="http://api.pagepeeker.com/v2/thumbs.php?size=m&url=<%= location %>" border="1" alt="Preview" />
                </figure>
                <h2 class="resource-title"><a href="<%= location %>" target="_blank"><%= texts[metadata_language].title %></a></h2>
                <small><?php echo Lang::get('website.resource_language') ?>
            <% for ( var i in languages ){ %>
                <span class="resourcelang"><img src="/images/blank.png" class="flag flag-<%= languages[i] %>" alt="<%= lang(languages[i]) %>" /> <%= lang(languages[i]) %></span>
            <% } %>
                </small>
            </header>
            <p><span class="resource-description"><% if ( texts[metadata_language].description ){ %><%= texts[metadata_language].description %><% } %></span></p>
            <footer>
                <hr/>
                <ul class="list-unstyled">
                    <li><strong><?php echo Lang::get('website.age_rage_context') ?>:</strong> 
                        <% if ( typeof age_range != 'undefined' ) { for ( var i in age_range ) { %>
                            <%= age_range[i] %>
                        <% } } else { %><%= lang('none') %><% } %>
                    </li>
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
                    <li><hr/></li>
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
                        <a href="#" data-location="<%= xml %>" data-id="<%= id %>" onclick="return false;" data-toggle="tooltip" class="ugc-widget"> <span class="glyphicon glyphicon-info-sign"></span> <?php echo Lang::get('website.improve_translation'); ?></a>
                    </li>
                    <% if ( texts[metadata_language].type != 'human' ) { %>
                    <li class="translation-rating">
                        <strong><?php echo Lang::get('website.rate_translation') ?> (<%=lang(metadata_language)%>):</strong> 
                    </li>
                    <% } %>
                    <li><hr/></li>
                    <li>
                        <strong><?php echo Lang::get('website.resource_type') ?>:</strong>
                        <% if ( !!texts[interfaceLanguage].types && texts[interfaceLanguage].types.length > 0 ){ %>
                            <% for ( var i in texts[interfaceLanguage].types ){ %>
                            <%= texts[interfaceLanguage].types[i] %>,
                            <% } %>
                        <% }else{ %>
                            <%= lang('none') %>
                        <% } %>
                    </li>
                    <li>
                        <strong><?php echo Lang::get('website.media_format') ?>:</strong>
                        <% if ( !!texts[interfaceLanguage].format ){ %>
                            <%= texts[interfaceLanguage].format %>
                        <% }else{ %>
                            <%= lang('none') %>
                        <% } %>
                    </li>
                    <li>
                        <strong><?php echo Lang::get('website.educational_context') ?>:</strong>
                        <% if ( !!texts[interfaceLanguage].educational && texts[interfaceLanguage].educational.length > 0 ){ %>
                            <% for ( var i in texts[interfaceLanguage].educational ){ %>
                            <%= texts[interfaceLanguage].educational[i] %>,
                            <% } %>
                        <% }else{ %>
                            <%= lang('none') %>
                        <% } %>
                    </li>
                    <li>
                        <strong><?php echo Lang::get('website.intended_audience') ?>:</strong>
                        <% if ( !!texts[interfaceLanguage].audience && texts[interfaceLanguage].audience.length > 0 ){ %>
                            <% for ( var i in texts[interfaceLanguage].audience ){ %>
                            <%= texts[interfaceLanguage].audience[i] %>,
                            <% } %>
                        <% }else{ %>
                            <%= lang('none') %>
                        <% } %>
                    </li>
                    <li>
                        <strong><?php echo Lang::get('website.copyright') ?>:</strong>
                        <% if ( !!audience ){ %>
                            <%= copyright.description %>
                        <% }else{ %>
                            <%= lang('none') %>
                        <% } %>
                    </li>
                    <li>
                        <strong><?php echo Lang::get('website.collection') ?>:</strong>
                            <%= xml.split('/')[0] %>
                    </li>
                    <li><hr/></li>
                    <li>
                        <a href="#/feedback/<%= id %>/inappropriate" class="label" style="font-size: 12px; "><?php echo Lang::get('website.report_resource_as_inappropriate') ?></a>
                    </li>
                </ul>
            </footer>
        </script>

        <script id="resource-content" type="text/template">
            <header>
                <figure class="hidden-sm">
                    <img class="img-thumbnail" src="http://api.pagepeeker.com/v2/thumbs.php?size=m&url=<%= location %>" border="1" alt="Preview" />
                </figure>
                <h2 class="resource-title"><a href="<%= location %>" target="_blank"><%= texts[metadata_language].title %></a></h2>
                <small><?php echo Lang::get('website.resource_language') ?>
            <% for ( var i in languages ){ %>
                <span class="resourcelang"><img src="/images/blank.png" class="flag flag-<%= languages[i] %>" alt="<%= lang(languages[i]) %>" /> <%= lang(languages[i]) %></span>
            <% } %>
                </small>
            </header>
                <p><span class="resource-description"><% if ( texts[metadata_language].description ){ %><%= texts[metadata_language].description.substr(0,200).trim() %><% } %>...</span> <a class="label label-primary moreinfo" href="/<?php echo LANG ?>/#/resource/<%= id %>"><span class="glyphicon glyphicon-plus"></span> <?php echo Lang::get('website.more_info') ?></a></p>
            <footer>
                <hr/>
                <ul class="list-unstyled">
                    <li><strong><?php echo Lang::get('website.age_rage_context') ?>:</strong> 
                        <% if ( typeof age_range != 'undefined' ) { for ( var i in age_range ) { %>
                            <%= age_range[i] %>  
                        <% } } else { %><%= lang('none') %><% } %>
                    </li>
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
                    <li><hr/></li>
                    <li class="clearfix">
                        <strong><abbr title="<?php echo Lang::get('website.abstracts_language_expanation') ?>"><?php echo Lang::get('website.abstracts_language') ?></abbr>:</strong>
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
                        <a href="#" data-location="<%= xml %>" data-id="<%= id %>" onclick="return false;" data-toggle="tooltip" class="ugc-widget"> <span class="glyphicon glyphicon-info-sign"></span> <?php echo Lang::get('website.improve_translation'); ?></a>
                    </li>
                    <% if ( texts[metadata_language].type != 'human' ) { %>
                    <li class="translation-rating">
                        <strong><?php echo Lang::get('website.rate_translation') ?> (<%=lang(metadata_language)%>):</strong> 
                    </li>
                    <% } %>
                    <li><hr/></li>
                    <li>
                        <a href="#/feedback/<%= id %>/inappropriate" class="label" style="font-size: 12px; "><?php echo Lang::get('website.report_resource_as_inappropriate') ?></a>
                    </li>
                </ul>
            </footer>
        </script>

        <script id="grnet-rating" type="text/template">
            <a onclick="return false;" data-toggle="tooltip" class="grnet-rating-tooltip" href="#"><% for ( var i = 0 ; i < rating ; i++ ){ %><img src="/images/full_star.png" class="grnet-rating-star star-value-<%= i %>"><% } %><% for ( var i = rating ; i < 5 ; i++ ){ %><img src="/images/empty_star.png" class="grnet-rating-star star-value-<%= i %>"><% } %></a>
               <%= lang('of') %>
            <span class="grnet-rating-num-votes"><%= votes %></span> <%= lang('votes') %>
            <!--<a  onclick="return false;" data-toggle="popover" class="grnet-rating-info" href="#"><span class="glyphicon glyphicon-expand"> </span></a></span>-->
            <% if ( rating > 0 ) { %>
            <span class="rating-history dropdown" style="position: relative; max-height: 50px; ">
                <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
                    <?php echo Lang::get('website.view_rating_history'); ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="drop5" role="menu" style="padding: 5px; font-size: 11px; max-height: 100px; overflow: auto; "></ul>
            </span>
            <% } %>
        </script>

        <script id="grnet-rating-stars" type="text/template">
            <li role="presentation">
                <% for ( var i = 0 ; i < ratingMean ; i++ ){ %><img src="/images/full_star.png" class="grnet-rating-star star-value-<%= i %>"><% } %><% for ( var i = ratingMean ; i < 5 ; i++ ){ %><img src="/images/empty_star.png" class="grnet-rating-star star-value-<%= i %>"><% } %>
            </li>
        </script>

        <script id="translation-rating" type="text/template">
            <a onclick="return false;" data-toggle="tooltip" class="translation-rating-tooltip" href="#"><% for ( var i = 0 ; i < rating ; i++ ){ %><img src="/images/full_star.png" class="translation-rating-star star-value-<%= i %>"><% } %><% for ( var i = rating ; i < 5 ; i++ ){ %><img src="/images/empty_star.png" class="translation-rating-star star-value-<%= i %>"><% } %></a>
               <%= lang('of') %>
            <span class="translation-rating-num-votes"><%= votes %></span> <%= lang('votes') %>
            <!--<a  onclick="return false;" data-toggle="popover" class="translation-rating-info" href="#"><span class="glyphicon glyphicon-expand"> </span></a></span>-->
            <% if ( rating > 0 ) { %>
            <span class="rating-history dropdown" style="position: relative; max-height: 50px; ">
                <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#">
                    <?php echo Lang::get('website.view_rating_history'); ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="drop5" role="menu" style="padding: 5px; font-size: 11px; max-height: 100px; overflow: auto; "></ul>
            </span>
            <% } %>
        </script>

        <script id="translation-rating-stars" type="text/template">
            <li role="presentation">
                <% for ( var i = 0 ; i < ratingMean ; i++ ){ %><img src="/images/full_star.png" class="translation-rating-star star-value-<%= i %>"><% } %><% for ( var i = ratingMean ; i < 5 ; i++ ){ %><img src="/images/empty_star.png" class="translation-rating-star star-value-<%= i %>"><% } %>
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
            <span class="label pull-right hidden-sm"><%= value %></span>
        </script>

        <script id="search-pagination" type="text/template">
            <ul class="pagination">

            <% if ( page > 1 ) { %>
              <li><a href="/<?php echo LANG ?>/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= 1 %><%=get_filters_formatted()%>"><%= lang('first') %></a></li>
            <% } %>

            <% if ( page > 1 ) { %>
              <li><a href="/<?php echo LANG ?>/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= page-1 %><%=get_filters_formatted()%>">&laquo;</a></li>
            <% } %>

            <% for ( var i = startPage ; i <= page+numPagLinks && i <= totalPages ; i++ ){ %>
              <li <% if ( i == page ) { %>class="disabled"<% } %>><a href="/<?php echo LANG ?>/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= i %><%=get_filters_formatted()%>"><%= i %></a></li>
            <% } %>

            <% if ( page < totalPages ) { %>
              <li><a href="/<?php echo LANG ?>/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= page+1 %><%=get_filters_formatted()%>">&raquo;</a></li>
            <% } %>

            <% if ( page < totalPages ) { %>
              <li><a href="/<?php echo LANG ?>/#/<%= route %><% if ( searchText != '' ) { %>/<%= searchText %><% } %>/<%= totalPages %><%=get_filters_formatted()%>"><%= lang('last') %></a></li>
            <% } %>

            </ul>
        </script>

        <script type="text/javascript">

          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-12236017-1']);

        </script>

        <script id="section-carousel" type="text/template">
            <ol class="carousel-indicators">
            <% for ( var i in carousel ) { %>
                <li data-target="#carousel-example-generic" data-slide-to="<%=i%>" <% if ( i==0 ) { %>class="active"<% } %>></li>
            <% } %>
            </ol>

            <div class="carousel-inner">
            <% for ( var i in carousel ) { %>
                <div class="item <% if ( i==0 ) { %>active<% } %>">
                    <a href="<%=carousel[i].link%>">
                        <img src="<%=carousel[i].image%>" alt="<%=carousel[i].alt%>">
                    </a>
                    <div class="carousel-caption">
                    </div>
                </div>
            <% } %>
            </div>

            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"><span class="icon-prev"></span></a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"><span class="icon-next"></span></a>
        </script>

        <script id="sections-categories" type="text/template">
            <div class="col col-lg-12">
                <h2><?php echo Lang::get('website.featured_sections') ?></h2>
            </div>
            <ul class="list-unstyled list-inline clearfix" style="margin-top: 25px; ">
            <% for ( var i in sections ) { %>
                <li class="col col-lg-2 section-image-hover">
                    <a class="school" href="<%=sections[i].link%>">
                        <img src="<%=sections[i].image%>" data-hover="<%=sections[i].imageh%>" data-leave="<%=sections[i].image%>" alt="<%=sections[i].section[default_lang]?sections[i].section[default_lang]:sections[i].section.en%>" />
                        <%=sections[i].section[default_lang]?sections[i].section[default_lang]:sections[i].section.en%>
                    </a>
                </li>
            <% } %>
            </ul>
        </script>

        <script id="sections-themes" type="text/template">
            <div class="col col-lg-12">
                <h2><?php echo Lang::get('website.hot_themes') ?></h2>
            </div>
            <ul class="list-unstyled list-inline">
            <% for ( var i in sections ) { %>
                <li class="col col-lg-2 section-image-hover">
                    <a class="school" href="<%=sections[i].link%>">
                        <img src="<%=sections[i].image%>" data-hover="<%=sections[i].imageh%>" data-leave="<%=sections[i].image%>" alt="<%=sections[i].section[default_lang]?sections[i].section[default_lang]:sections[i].section.en%>" />
                        <%=sections[i].section[default_lang]?sections[i].section[default_lang]:sections[i].section.en%>
                    </a>
                </li>
            <% } %>
            </ul>
        </script>

        <!-- App javaScript files -->
        <script src="/js/app.min.js?date=<?php echo VERSION?>"></script>
        <script src="/js/lang/<?php echo LANG ?>.js?date=<?php echo VERSION?>"></script>
        <script src="/js/lang/error/<?php echo LANG ?>.js?date=<?php echo VERSION?>"></script>

        <script>
            //$.ajaxSetup({ cache: false });

            // Wait for search request
            var interfaceLanguage = $('html').attr('lang');
            var Box = new App.Models.App();
            var sections = new App.Models.Sections();
            var filtersBarView = new App.Views.FiltersBar({ collection: Box.get('filters') });
            var searchBarInfo = new App.Views.SearchInfoBar();
            Box.set('langFile', lang_file);
            Box.set('errFile', error_file);
            var doSearch = new App.Views.DoSearch();
            var doLogin = new App.Views.LoginForm();
            var doRegister = new App.Views.RegisterNewUser();
            var doChangeSettings = new App.Views.ChangeSettings({model: new App.Models.ChangeSettings()});
            var autoTranslate = new App.Views.Autotranslate();
            var changedFilters = false;

            // Router + History
            Router = new App.Router;
            Backbone.history.start();

            // Redirection
            $('#lang-selector .dropdown-menu li a').click(function(){
                window.location = $(this).attr('href')+'#'+Backbone.history.getFragment();
                return false;
            })

            // 
            $('#search-form input[type=checkbox], #search-form label').bind('click', function (e) { e.stopPropagation() })
        </script>

        <script>
        <?php if ( isset( $_COOKIE['usertoken'] ) AND $_COOKIE['usertoken'] <> '' AND @is_object( $_user ) ): ?>
            // Suggest new resources
            $('html').on('click', '.ugc-widget', function(event){
                event.preventDefault();
                var WIDGET_HOST = 'http://organiclingua.know-center.tugraz.at/';
                var path_js = '/UGC/ugc-widget-server/';

                var type_text = $(this).parents('article').find('.resource-change-lang').find('li > a').html();
                var action = !!type_text.match(/human/gi) ? 'edit' : 'translate';
                try {
                    var x = document.createElement("SCRIPT");
                    x.type = "text/javascript";
                    x.src = WIDGET_HOST + path_js + "loadUGC.js";
                    if ( action == 'edit'){
                        // CORRECT
                        x.setAttribute("Language", $('html').attr('lang'));
                    }else{
                        //TRANSLATE
                        x.setAttribute("sourceLanguage", 'en');
                        x.setAttribute("targetLanguage", $('html').attr('lang')); 
                    }
                    x.setAttribute('Name', '<?php echo $_user->user_username ?>');
                    x.setAttribute('Username', '<?php echo $_user->user_username ?>');
                    x.setAttribute('Email', '<?php echo $_user->user_email ?>');
                    x.setAttribute('Operation', action);
                    x.setAttribute('id', 'LOMWidget');
                    x.setAttribute("LOMID", $(this).attr('data-id'));
                    x.setAttribute("LOMLocation", 'http://organic-edunet.eu/xml/'+$(this).attr('data-location'));
                    document.getElementsByTagName("head")[0].appendChild(x);
                }catch(e){
                    alert(e.getMessage());
                }
            })
            
            // View own resources
            $('html').on('click', '.ugc-widget-own', function(event){
                javascript:(function() {
                    WIDGET_HOST = 'http://organiclingua.know-center.tugraz.at/';
                    var path_js = '/UGC/ugc-widget-server/';
                    try {
                        var x = document.createElement('SCRIPT');
                        x.type = 'text/javascript';
                        x.src = WIDGET_HOST +  path_js + 'loadUGC.js';
                        x.setAttribute('Name', '<?php echo $_user->user_username ?>');
                        x.setAttribute('Username', '<?php echo $_user->user_username ?>');
                        x.setAttribute('Email', '<?php echo $_user->user_email ?>');
                        x.setAttribute('Operation', 'index');
                        x.setAttribute('id', 'LOMWidget');
                        x.setAttribute("Language", $('html').attr('lang'));
                        x.setAttribute('URL', window.location.href);
                        document.getElementsByTagName('head')[0].appendChild(x);
                    } catch (e) {}
                })();
            })
        <?php else: ?>
            $('#app-content-results, #resource-viewport').tooltip({
                selector: '.ugc-widget',
                title: '<?php echo Lang::get('website.log_in_or_register_for_improving_translation') ?>'
            });
            $('body').tooltip({
                selector: '.grnet-rating-tooltip, .translation-rating-tooltip',
                title:'<?php echo Lang::get('website.log_in_or_register_for_rating') ?>'
            });
        <?php endif; ?>
        </script>

    </body>
</html>