<!DOCTYPE html>
<html lang="<?php echo LANG ?>">
    <head>
        <?php define( 'VERSION', '0.2.6' );?>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo Lang::get('website.welcome'); ?>, <?php echo  $_user->user_username ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <!--<li role="presentation">< data-toggle="modal" href="#change-account"><span class="glyphicon glyphicon-wrench"></span> <?php echo Lang::get('website.change_account_details'); ?></a></li>-->
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
                                <li role="presentation"><a href="/ar/" tabindex="-1" role="menuitem"><img src="/images/blank.png" class="flag flag-ir" alt="Arabic" /> العربية</a></li>
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
                                            <li><a href="#ar"><img src="/images/blank.png" class="flag flag-ir" alt="Arabic" /> العربية</a></li>
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
                                    <input type="text" name="form-feedback-name">
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
                                    <select name="form-feedback-type">
                                        <option value="Bug"><?php echo Lang::get('website.bug') ?></option>
                                        <option value="Feature request"><?php echo Lang::get('website.feature_request') ?></option>
                                        <option value="General comment"><?php echo Lang::get('website.general_comment') ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label"><?php echo Lang::get('website.subject') ?></label>
                                <div>
                                    <input type="text" name="form-feedback-subject">
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label"><?php echo Lang::get('website.body') ?></label>
                                <div>
                                    <textarea name="form-feedback-body" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
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
                        <h1>PRIVACY POLICY OF THE Organic.Lingua PLATFORM</h1>
                        <p><strong>1. Terms </strong></p>
                        <p>
                            This disclaimer contains the general conditions governing the use and access to Organic.Lingua Platform (the "Platform") and liabilities arising out of their use,
                            in compliance with European standards of personal data protection:
                            <a name="content">
                                Directive 95/46/EC of the European Parliament and of the Council of 24 October 1995 on the protection of individuals with regard to the processing of
                                personal data and on the free movement of such data (Data Protection Directive); Directive 2000/31/EC
                            </a>
                            on certain legal aspects of information society services, in particular electronic commerce, in the Internal Market (Directive on electronic commerce); and
                            Directive 2002/22/EC on universal service and usersí rights relating to electronic communications networks and services, Directive 2002/58/EC concerning
                            the processing of personal data and the protection of privacy in the electronic communications sector.
                        </p>
                        <p>
                            The access and / or use of the Platform gives the condition of ìuserî.
                        </p>
                        <p>
                            It is understood that mere access to or use of the platform by the user implies acceptance thereof to all Terms of the Organic.Lingua Project has published at that
                            time on the web. The general conditions of use apply independently of those other obligations and specific conditions to which the user voluntarily submit
                            to this Platform.
                        </p>
                        <p>
                            Consequently, the user must carefully read the Conditions set forth in this Privacy Policy Organic.Lingua Platform.
                        </p>
                        <p>
                            <strong>2. Organic.Lingua Information Platform</strong>
                        </p>
                        <p>
                            <strong><em>2.1. Project and Platform Organic.Lingua</em></strong>
                        </p>
                        <p>
                            In compliance with the duty of information contained in the legislation on data protection and treatment of current data, then reflects the significant
                            data of this website.
                        </p>
                        <p>
                            Organic.Lingua Platform has been designed by the partners of the Consortium of the Research Project
                            <em>
                               Demonstrating the potential of multilingual Web Portal for Sustainable Agricultural & Environmental Education.
                            </em>
                            (Organic.Lingua), specially by a group of researches from the University of Alcal·.
                        </p>
                        <p>
                            The research project Organic.Lingua is an European project funded under the Seventh Framework Information Communication Technologies Policy Support Programme of the
                            European Union [Theme [CIP-ICTPSP.2010.6.2] Multilingual Online Services. Grant agreement 270999].
                        </p>
                        <p>
                            The Consortium is composed of eleven members from different European states. These members include the University of Alcal· as controller for the design
                            and operation of this Platform.
                        </p>
                        <p>
                            Organic.Lingua Platform is a social platform that integrates open access institutional repositories in the field of organic agriculture, and employs the
                        AGROVOC thesaurus in combination with other more specific search methods. It is hosted on the site    <a href="http://organic-edunet.eu/">http://organic-edunet.eu</a>
                        </p>
                        <p>
                            <strong><em>2.2. Target</em></strong>
                            <em></em>
                        </p>
                        <p>
                            Organic.Lingua is aiming to enhance an existing Web portal (http://www.organic-edunet.eu) with educational content on Organic Agriculture (OA) and Agroecology (AE), introducing automated multi-lingual services that will further support the uptake of the portal from its targeted audiences, facilitate the multilingual features of the portal, and further extend its geographical and linguistic coverage.
                        </p>
                        <p>
                            The Organic.Edunet Web portal bridges together a network of learning repositories with content on OA & AE, providing its users with a significant volume of relevant learning resources. It adopts a federated, standards-based approach that allows the incremental growth of the network.
                        </p>
                        <p>
                            The Organic.Lingua project aims to capitalise on the European and international demand for the Organic.Edunet portal by transforming it into a truly multilingual service. It will achieve this by re-engineering the architecture and enhancing the services of the existing Organic.Edunet portal, in order to fill the abovementioned gaps in multilingual support and cross-language resource organization and search.
                        </p>
                        <p>
                            It particularly aims at analyzing and re-engineering the service infrastructure and related facilities and business models in order to support multilingual access and use more widely and effectively. Since such linguistic limitations of Organic.Edunet are common to most current multilingual Web portals, an important outcome of the Organic.Lingua project is expected to be a set of guidelines, good practice methods and software tools that can be adopted in other portal cases.
                        </p>
                        <p>
                            Overall, Organic.Lingua aims to make the Organic.Edunet Web portal a service that will support agricultural researchers and educators around Europe, as well as explore new business opportunities for the specific service but also for the developers/providers of language technologies.
                        </p>
                        <p>
                            <strong>3. Privacy and Personal Data Processing</strong>
                        </p>
                        <p>
                            <strong><em>3.1. Personal data: users and their profiles</em></strong>
                        </p>
                        <p>
                            Identifying and personal data provided as part of this Platform, as well as the images used, are confidential and will be treated by those responsible for
                            the Platform in accordance with current legislation regarding the protection of personal data. At the same time, users expressly authorize the platform to
                            send information regarding developments in the field of services provided by it. In the event that did not wish to receive such information simply notify
                            via e-mail at any time (<a href="mailto:info@organic-lingua.eu">info@organic-lingua.eu</a>).
                        </p>
                        <p>
                            The Platform expressly indicate mandatory or not to provide certain personal data. The data marked as mandatory are required to provide optimal service to
                            the user. For this reason, should not be provided, the platform makers can not guarantee the efficiency of the service.
                        </p>
                        <p>
                            Whatever the country where the user resides, or from which it supplies the information, authorizes with the consent of those responsible for the platform
                            to use such information in any State in which it operates the platform, even though such information is used in the United States.
                        </p>
                        <p>
                            The Privacy Policy of this platform affects both personal data provided by users to develop its profile as the other personal data to access any of the
                            services offered and available on the same.
                        </p>
                        <p>
                            Data entered in the form by the user must be true, accurate, complete and current. Platform Managers will carry out the necessary safety measures to verify
                            the user's identity.
                        </p>
                        <p>
                            In the event that the person entering the data is different from the one to be declared as a user, are deemed to have express consent to do so and it gives
                            permission to the treatment described above. The user is solely responsible for any loss or damage, direct or indirect which might arise to any person due
                            to the high platform with false, inaccurate, incomplete or outdated.
                        </p>
                        <p>
                            <strong> </strong>
                        </p>
                        <p>
                            <strong><em>3.2. The exercise of rights of access, rectification, cancellation and opposition to the processing of personal data</em></strong>
                        </p>
                        <p>
                            The holder of personal data may exercise rights of access, opposition, rectification and cancellation on how much data stored on there own Organic.Lingua Platform.
                        </p>
                        <p>
                            These rights may be exercised through any medium, provided the record of it, against those responsible for the Platform, enclosing a photocopy of ID card,
                            passport or similar document by which to identify the owner of the data. For representation of the user, it must be accompanied by the forms permitted by
                            law.
                        </p>
                        <p>
                        Thus, the user can unsubscribe Platform permanently if requested. Simply notify via e-mail at any time (    <a href="mailto:info@organic-lingua.eu">info@organic-lingua.eu</a>).
                        </p>
                        <p>
                            The Platform will retain personal data of users while they keep active their account on their own or as necessary in accordance with the provisions of law.
                        </p>
                        <p>
                            <strong> </strong>
                        </p>
                        <p>
                            <strong><em>3.3. The processing of personal data of minors</em></strong>
                        </p>
                        <p>
                            This Platform is aimed at an audience interested in the subject matter of Organic.Lingua Research Project, namely education about organic agriculture.
                        </p>
                        <p>
                            In this sense, the services offered by the platform are aimed to over 14 years. The access under 14 is restricted. However, if a minor, but over 14 years,
                            pretend to register with the service, you can only do so with parental consent.
                        </p>
                        <p>
                        If a user becomes aware that a child has accessed or is using the platform it shall immediately notify to    <a href="mailto:info@organic-lingua.eu">info@organic-lingua.eu</a>. If the child has provided personal data, he shall be canceled and deleted.
                        </p>
                        <p>
                            <strong><em>3.4. Privacy levels</em></strong>
                        </p>
                        <!-- ESTO HAY QUE REVISARLO
                        <p>
                            When the user signs up for the service offered by this Platform, part of the information provided will be made public and will be exposed in Linked Data
                            format. These data are typically used by databases management and systems research like CERIF. In these data we will find the name of the user, their
                            surname, gender, research interests, organization where they work and their profile page.
                        </p>
                        <p>
                            When the user signs up on the Platform, a profile is generated which updates and shares, as he wants and with whom you want, its personal information.
                            Personal information will be shared on the platform with the conditions or levels of privacy that the user choose and under its exclusive control.
                        </p>
                        <p>
                            The user decides, simply by activating or deactivating the specific information they want to share and who to share it.
                        </p>
                        <p>
                            The level of privacy offered by the platform default allows access to the information provided only to ìcolleaguesî. ìColleaguesî are explicit contact
                            within the Platform, whose relationship is established at the request of a party, only after expressed acceptance of the other.
                        </p>
                        <p>
                            In addition to the information provided at the time of signing up for the platform, the user can provide other information to public through their profile.
                            This information is provided with the consent of the user, and will be used to keep users informed of the services offered by the platform or, give out
                            your location and then proceed to enhance and personalize the services offered by the Platform.
                        </p>
                        <p>
                            It will considered non-private information, that the Platform may make public, information published in your user profile, and the people you have in
                            contact.
                        </p>
                        <p>
                            In any case, the Platform does not control, and therefore, is not responsible of the shared information among users or by third parties.
                        </p>
                        <p>
                            However, due to the fact that from the information provided voluntarily by users may be able to deduct data regarding their nationality, ethnicity, health,
                            religious or political beliefs, users accepts expressly and voluntarily the terms conditions this Privacy Policy and the Terms of Use of the Platform.
                        </p>
                        -->
                        <p>
                            <strong><em>3.5. Cookies</em></strong>
                        </p>
                        <p>
                            Cookies are files sent to the browser by a web server in order to record user activities during its navigation.
                        </p>
                        <p>
                            The lender, on your own or a third party contracted to provide services, may use cookies when users surf the Platform.
                        </p>
                        <p>
                            In this sense, the cookies used by the Platform are only associated with an anonymous user and computer, and not themselves provide user's personal data;
                            and its use, in any case, has temporarily for the sole purpose of making more efficient onward transmission.
                        </p>
                        <p>
                            You can set your browser to notify you of the receipt of cookies and to prevent their installation on your computer.
                        </p>
                        <p>
                            In any case, the user is informed that to use the Platform is not necessary for the user to permit the installation of cookies sent by the website or third
                            parties acting on its behalf, notwithstanding that it is necessary for the user to start login as such in each of the services the provision of which
                            requires prior registration or ìloginî.
                        </p>
                        <p>
                            <strong><em>3.6. IP Addresses</em></strong>
                        </p>
                        <p>
                            An IP address is a number automatically assigned to a computer when it is connected to the Internet.
                        </p>
                        <p>
                            Platform servers can automatically detect the IP address and domain name used by the user.
                        </p>
                        <p>
                            <strong><em>3.7. Activity file</em></strong>
                        </p>
                        <p>
                            All this information (IP addresses, cookies, browser type, operating system, source website, websites visited, location, service provider system mobile,
                            search terms ....) is recorded in a file server activity, which allows the subsequent processing of the data in order to obtain measurements only
                            statistics which show the number of page impressions, the number of visits to the web servers, the order of visits, the access point, etc ... In this way,
                            the Platform is to provide a personalized and enhanced services to its users.
                        </p>
                        <p>
                            <strong><em>3.8. Security</em></strong>
                        </p>
                        <p>
                            This Platform uses techniques of information security generally accepted in the industry, such as firewalls, access control procedures and cryptography
                            mechanisms, all with the aim of preventing unauthorized access to data.
                        </p>
                        <p>
                            To maintain the said security, you agree that the service provider obtains personal data for the purposes of authentication access controls.
                        </p>
                        <p>
                            Also the responsible for the Platform will adopt in accordance with the data protection legislation in force, those security measures to avoid loss,
                            alteration, misuse or unauthorized access of information supplied by users.
                        </p>
                        <p>
                            However, the user is solely responsible for the safe custody of the password used to access the services offered by the Platform. As a security measure we
                            recommend users to use an alphanumeric password combined with symbols that make difficult their deduction.
                        </p>
                        <p>
                            <strong>4. Duration and Modification of Privacy Policy Platform</strong>
                        </p>
                        <p>
                            Organic.Lingua Platform reserves the right to change its privacy policy and data protection, unilaterally and without notice, due to changes in legislation, case
                            law or academic purposes. Such changes may have a partially or totally. If there is any change, the new text will be published on the website of the
                            platform, where users can access the current policy regarding confidentiality and data protection. In each case, the relationship with users will be
                            governed by the rules laid down in the precise moment when you access the web.
                        </p>
                        <p>
                            The validity of the conditions of this privacy policy coincides, therefore, with time of exposure, so far as it is modified in whole or in part by the
                            heads of the Platform.
                        </p>
                        <p>
                            Your continued access or use the services offered by the platform after applying the changes means that you consent to the new terms of use, and therefore
                            is subject to the new Privacy Policy.
                        </p>
                        <p>
                            The Platform may terminate, suspend or discontinue its operation unilaterally, without any possibility of seeking compensation from the user.
                        </p>
                        <h1>TERMS OF USE OF THE Organic.Lingua PLATFORM</h1>
                        <p>
                            <strong>1. Service Access</strong>
                        </p>
                        <p>
                            Users can access the site for free.
                        </p>
                        <p>
                            Users agree to make appropriate use of content and services that the platform provides, being solely responsible for the use made of the services offered.
                        </p>
                        <p>
                            By accessing you agree that the resposables or controllers of the Plataform will not be respect any consequences or damages resulting from such access or
                            use of the information is accessed, or access to other materials on the Internet through connections with this website.
                        </p>
                        <p>
                            Platform reserves the right to deny or withdraw access to its website and / or services offered without notice, on its own or a third party, for those
                            users who violate these Terms of Service. The Platform pursue a breach of these Terms and any misuse of your web page, exercising all civil and criminal
                            actions that can by law.
                        </p>
                        <p>
                            You can only use the services offered by the platform if done in compliance with these Terms of Use, and any applicable regulations, whether local,
                            regional, national or international.
                        </p>
                        <p>
                            <strong>2. Using the service</strong>
                        </p>
                        <p>
                            <strong><em>2.1. Conditions of Use: collection and use of information. Need for consent.</em></strong>
                        </p>
                        <p>
                            The use of the services offered by this Platform involves implicit user consent to the collection and use of your personal information. Just as consent for
                            treatment that might arise from the voluntary disclosure of information that could be deduced from your profile and was related to racial or ethnic origin,
                            health or religious or political beliefs, that is, with their sensitive data or specially protected.
                        </p>
                        <p>
                            As part of the service offered, given the nature of this platform, means consented to the transfer of your personal data or transferring them to the United
                            States or other countries, either for storage, processing or use Platform by Organic.Lingua.
                        </p>
                        <p>
                            Furthermore, the user agrees and accepts the possibility of advertising related to the services offered by the platform.
                        </p>
                        <p>
                            Except where required by the Privacy Policy and Terms of Use, the Platform does not provide to third parties information or personal data that allow the
                            users' personal identification.
                        </p>
                        <p>
                            To facilitate the use of the information between users, the platform provides search services.
                        </p>
                        <p>
                            In these cases the Platform will use the information provided by users.
                        </p>
                        <p>
                            Users may at any time revise the information provided above and make the changes that may be appropriate for publication in your account and profile.
                        </p>
                        <p>
                            <strong><em>2.2. Events and notifications</em></strong>
                        </p>
                        <p>
                            As part of the provision of the services offered by the platform, you may have to report certain information to the user as an integral part of the
                            services and account. You may not opt out of receiving such information. Notifications will aim to improve the service offered by the platform.
                        </p>
                        <p>
                            The user can hang on your profile information on any event or activity you want to promote or advertise whenever a purpose and research staff.
                        </p>
                        <p>
                            Thus, a user may invite to participate in the services offered by the platform to other subjects, as well as proposing to participate in events and
                            registered users.
                        </p>
                        <p>
                        Out of these cases, the user may opt out of receiving other communications or notifications by sending an email to the following address    <a href="mailto:Organic.Lingua@gmail.com">Organic.Lingua@gmail.com</a>.
                        </p>
                        <p>
                            <strong><em>2.3. Uses forbidden</em></strong>
                        </p>
                        <p>
                            The services provided by the Platform are provided solely for the user's personal use and not being allowed uses economic or business without prior consent
                            of those responsible for this Platform.
                        </p>
                        <p>
                            Also, few other purposes is prohibited conflict with this Privacy Policy and Terms of Use.
                        </p>
                        <p>
                            <strong>3. Responsibility and Obligations</strong>
                        </p>
                        <p>
                            <strong><em>3.1. Responsibility for the content</em></strong>
                        </p>
                        <p>
                            The content provided by the Platform is general, with a purpose and informational purposes only.
                        </p>
                        <p>
                            The content posted by users respond exclusively the users. The user is solely responsible for the use made of the services offered by the platform, and any
                            content you may provide and for any consequences arising from them, including use by other users of the platform.
                        </p>
                        <p>
                            Here, the user is responsible for the content that you submit, or expose to play through the services offered by the platform. With its publication, you
                            grant the Platform a worldwide, non-exclusive, free, on the use, copy, reproduce, process, adapt, modify, publish, transmit, display and distribution of
                            that content through any means or method Distribution present and / or future.
                        </p>
                        <p>
                            Those responsible for the platform are exempted from any liability for any decision taken by the user of the website. In this sense, it informs users that
                            the content played through the platform will not be monitored or controlled by their leaders. And, therefore, the present Platform no guarantee that the
                            contents of the information carried through the services offered is complete, accurate, precise and reliable.
                        </p>
                        <p>
                            Platform makers reject responsibility for any information not prepared by the responsible for it or not published in an authorized manner, as the liability
                            that may arise from the misuse of the contents. Similarly, in relation to the content, the Platform reserves the right to update, delete, limit or prevent
                            access to them, temporarily or permanently.
                        </p>
                        <p>
                            <strong><em>3.2. Responsibility for links to other websites (links)</em></strong>
                        </p>
                        <p>
                            Links included in the website with the Platform for informational purposes only and, therefore, responsible for the Platform do not control or verify any
                            information, content, products or services provided by these websites. Consequently, those responsible for the Platform disclaim any responsibility for any
                            aspect, especially the content on linked pages.
                        </p>
                        <p>
                            These links to other pages, as well as to the products or services offered by them does not imply endorsement, sponsorship or recommendation by the
                            Platform or Organic.Lingua Research Project.
                        </p>
                        <p>
                            In this sense, the Platform is not responsible for the Privacy and data protection they can continue those pages whose link may consist, for information or
                            exemplary in their website.
                        </p>
                        <p>
                            <strong><em>3.3. Liability in the event that this page is the link target added another page</em></strong>
                        </p>
                        <p>
                            As regards the links established by other pages towards the website Organic.Lingua Platform must adhere to the following stipulations:
                        </p>
                        <ul type="disc">
                            <li>
                                You must request permission before carrying out links and shall state expressly granted.
                            </li>
                            <li>
                                You can only lead to the homepage.
                            </li>
                            <li>
                                The link must be absolute and complete, for example, it must take the user to the direction of the platform and must include the full extent of the
                                home page screen. In any case, unless authorized in writing by the Platform, the page you make the link reproduce in any way the website, include it as
                                part of your website or in one of their ìframesî or create a ìbrowserî on any of the web pages.
                            </li>
                            <li>
                                Do not give any erroneous or incorrect about the platform.
                            </li>
                            <li>
                                If you want to record a hallmark of the platform, such as trademarks, logos and names, they must have the written permission of their makers.
                            </li>
                            <li>
                                The owner of the page that the link must act in good faith and do not pretend to adversely affect the reputation or good name of the Platform or Organic.Lingua
                                Research Project.
                            </li>
                            <li>
                                It is prohibited, unless authorized by those responsible for the Platform, enlist the text elements of the brand or logo, the domain name of the
                                Platform as a keyword (ìmetatagsî or ìmetanamesî) for search on websites through search engines.
                            </li>
                        </ul>
                        <p>
                            This platform does not assume any responsibility for any aspect of the website that provides the link to it.
                        </p>
                        <p>
                            <strong><em>3.4. Responsibility for technical aspects</em></strong>
                        </p>
                        <p>
                            The responsibles for the Platform do not guarantee the continued functioning and operability or availability of the website through no fault of their
                            responsibility.
                        </p>
                        <p>
                            The responsibles for the Platform are not responsible for any direct or indirect, including damage to computer systems and introduction of virus in the
                            network, derived from Internet navigation required to use this website. Therefore, in no case shall be indemnified for any problems due to system
                            malfunction.
                        </p>
                        <p>
                            <strong><em>3.5. Liability for interactions with other users</em></strong>
                        </p>
                        <p>
                            The Platform acts as a mere intermediary in the services it provides, so it is not responsible for the actions and interactions of its users.
                        </p>
                        <p>
                            Users are solely responsible for the information published on the third platform. In this sense, users undertake not to misuse the services offered by the
                            Platform using it to send spam, insult, harass, or otherwise violate the Terms of Use or Privacy Policy Platform.
                        </p>
                        <p>
                            <strong><em>3.6. Obligation users</em></strong>
                        </p>
                        <p>
                            The user liable for damages Platform makers may suffer as a result of the breach, meanwhile, of any of the obligations set forth in this legal notice.
                        </p>
                        <p>
                            The Platform user is obliged to make good use and reasonable use of the services offered.
                        </p>
                        <p>
                            You may not use the services offered by the platform to transmit any kind of unlawful, threatening, defamatory or any other material deemed offensive.
                        </p>
                        <p>
                            Regarding navigation, the user agrees to diligently and faithfully the recommendations that once set the platform relative to the use of the site. For this
                            purpose the platform makers will target users through any means of communication through the website.
                        </p>
                        <p>
                            <strong>4. Privacy</strong>
                        </p>
                        <p>
                            The questions regarding the Privacy Policy, shall be considered as expressly stated in this legal notice.
                        </p>
                        <p>
                            The conditions of use of this platform are based on the Privacy Policy described and strict respect for the privacy of its users.
                        </p>
                        <p>
                            <strong>5. Unsubscribe from the service</strong>
                        </p>
                        <p>
                            As reflected in the Privacy Policy of this platform, users can unsubscribe from it permanently if requested. However, the user may stop using the services
                            offered by the Organic.Lingua Platform without express notice, although in these cases the accounts will remain active until, over time, be disabled by prolonged
                            inactivity of the same.
                        </p>
                        <p>
                            Also responsible for the Platform may proceed to terminate any user who violates consider the conditions set out in this legal notice.
                        </p>
                        <p>
                            <strong>6. Intellectual Property Rights and Industrial</strong>
                        </p>
                        <p>
                            This entire website (excluding content distributed by users): description and characteristics, text, images, marks, logos, buttons, software files, color
                            combinations, as well as the structure, selection, arrangement and presentation of their content is protected by national and international intellectual
                            and industrial property. The Organic.Lingua Platform owns the intellectual property rights and industrial its website, as well as the elements contained therein.
                        </p>
                        <p>
                            In any case access by third parties to the site involves some kind of waiver, transfer or sale of all or part of the rights granted by national and
                            international legislation on intellectual property.
                        </p>
                        <p>
                            The Platform, as owner of the services offered, grants its users a limited, revocable, non-sublicensable license to use the services strictly personal.
                            Except for this license is prohibited any form of reproduction, distribution, public communication, modification, and, in general, any act of exploitation
                            of the software necessary for the visualization or the functioning of the service, which does not have the express permission those responsible for the
                            same.
                        </p>
                        <p>
                            The user undertakes to use the content diligently, correctly and lawfully and, in particular, agree to not remove, ignore or manipulate the ìcopyrightî and
                            other data identifying the rights of the Platform or its owners included content as well as technical protection devices or any information mechanisms that
                            may be included in the contents.
                        </p>
                        <p>
                            In the event that a user considers that there has been a violation of their copyright on any of the content posted, must inform the Platform proving that
                            fact by the most appropriate means.
                        </p>
                        <p>
                            In this sense, the Platform controller reserve the right to remove or delete the reference to the content that allegedly infringe intellectual property
                            rights without notice, in its sole discretion and without any compensation on their behalf.
                        </p>
                        <p>
                            The domain used by this platform can not be used unless express prior authorization in connection with other services than the Organic.Lingua Research Project in
                            any manner that is likely to cause confusion among users or discredit to the said project.
                        </p>
                        <p>
                            Any user posting, uploading or otherwise making available any User Generated Content onOrganic.Lingua website, will still own the User Generated Content (assuming
                            they have the rights to own it) but the user is giving us the right to use his User Generated Content.
                        </p>
                        <p>
                            That means that if the user sends in, posts, uploads, makes available, or discloses to us in any way any User Generated Content, the user grant us, our
                            affiliates and related entities, the right to use it any way we want in any medium without getting his permission or having to pay you for it.
                        </p>
                        <p>
                            In legal terms, by providing us with any User Generated Content, the user grant us and our affiliates and related entities, a worldwide, royalty-free,
                            perpetual, irrevocable, non-exclusive right and fully sub-licensable license to use, copy, reproduce, distribute, publish, publicly perform, publicly
                            display, modify, adapt, translate, archive, store, and create derivative works from such User Generated Content, in any form, format, or medium, of any
                            kind now known or later developed. The user waives any moral rights he might have with respect to any User Generated Content he provide to us. The user
                            also grants us the right to use any material, information, ideas, concepts, know-how or techniques contained in any communication you provide or otherwise
                            submit to us for any purpose whatsoever, including but not limited to, commercial purposes, and developing, manufacturing and marketing commercial products
                            using such information. All rights in this paragraph are granted without the need for additional compensation of any sort to you.
                        </p>
                        <p>
                            The user acknowledges that we and/or our designees may or may not pre-screen User Generated Content, and have the right (but not the obligation), in our
                            sole discretion, to move, remove, block, edit, or refuse any User Generated Content for any reason, including without limitation that such User Generated
                            Content violates these Terms of Use or is otherwise objectionable.
                        </p>
                        <p>
                            We try to create an environment in which users are posting and discussing content that you will find useful, interesting and appropriate; however we cannot
                            and do not monitor or manage all User Generated Content. Thus, we do not promise the accuracy, integrity, or quality of the User Generated Content and do
                            not endorse it in any manner. In other words, enjoy what other members post or share, but do it at your own risk.
                        </p>
                        <p>
                            Also, all User Generated Content provided on the Websites is the sole responsibility of the user who provided it. This means that the user is entirely
                            responsible for all User Generated Content that he provides.
                        </p>
                        <p>
                            <strong>7. Applicable Law and Jurisdiction</strong>
                        </p>
                        <p>
                            Privacy Policy Organic.Lingua Platform and their conditions of use are governed by European legislation on data protection, continue to apply the Directive 95/46/EC
                            on the Protection of Personal Data. And, specifically, the provisions of Article 4, which provides the relevant national legislation.
                        </p>
                        <p>
                            According to the article "
                            <em>
                                1. Each Member State shall apply the national provisions it adopts pursuant to this Directive to the processing of personal data where: (a) the
                                processing is carried out in the context of the activities of an establishment of the controller on the territory of the Member State; when the same
                                controller is established on the territory of several Member States, he must take the necessary measures to ensure that each of these establishments
                                complies with the obligations laid down by the national law applicable; (b) the controller is not established on the Member State's territory, but in a
                                place where its national law applies by virtue of international public law; (c) the controller is not established on Community territory and, for
                                purposes of processing personal data makes use of equipment, automated or otherwise, situated on the territory of the said Member State, unless such
                                equipment is used only for purposes of transit through the territory of the Community
                            </em>
                            î.
                        </p>
                        <p>
                            The services offered by this Platform are part of the objectives of the European Research Project Organic.Lingua, being the principal responsible for its design the
                            Spanish member of the Consortium, that is, the group of researchers from the University of Alcal·. But offered services and applications can be accessed
                            from outside Spain, to be used by any person or entity in any country or jurisdiction in which its use would be contrary to local laws or regulations in
                            force at all times.
                        </p>
                        <p>
                            So, determine current regulations Governing laws and jurisdiction to be aware of the relations between the platform makers and users of the services
                            provided by it.
                        </p>
                        <p>
                            The use of the services and / or platform applications by users within a particular country will be under their responsibility. Here, the user is solely
                            responsible for compliance with the laws of the countries from which you access those services and / or applications.
                        </p>
                        <p>
                            Nevertheless, in cases where such regulations do not provide the obligation for the parties to submit to a special Court, and in case of disputes between
                            the user and the Platform, the parties expressly covenant and agree submit to the national Courts of Organic.Lingua Project Partners where the problem had ocurred.
                        </p>
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
                                    <button type="submit" class="btn btn-primary" id="form-register-submit">c
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
                        <h2>Retrieve password</h2>
                        <p>Please click in the following link to request a new password for the site for your account.</p>
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
                                    <button type="submit" class="btn btn-primary" id="form-retrieve-submit">Retrieve password</button>
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
                        <h4 class="modal-title">Change account details</h4>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
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

        <!-- jQuery + Bootstrap -->
        <script src="/js/jquery.js"></script>
        <script src="/js/vendor/bootstrap/bootstrap.js"></script>
        <script src="/js/vendor/twitter/typeahead.js"></script>
        <!-- Activate IE8 responsive features -->
        <!--<script src="/js/respond.js"></script>-->
        <!-- Libraries for using Backbone.js -->
        <!--<script data-main="/js/app/main"  src="/js/require.js"></script>-->
        <script src="/js/underscore.js"></script>
        <script src="/js/backbone.js"></script>
        <!-- App javaScript files -->
        <script src="/js/app.js?date=<?php echo VERSION?>"></script>
        <script src="/js/app.models.js?date=<?php echo VERSION?>"></script>
        <script src="/js/app.views.js?date=<?php echo VERSION?>"></script>
        <script src="/js/app.collections.js?date=<?php echo VERSION?>"></script>
        <script src="/js/app.router.js?date=<?php echo VERSION?>"></script>
        <!--Default language file -->
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
            $('.carousel').carousel();

            $('.sections-categories').on('mouseover', 'li', function(){
                var img = $(this).find('img');
                img.attr('src', img.attr('data-hover'));
            });
            $('.sections-categories').on('mouseout', 'li', function(){
                var img = $(this).find('img');
                img.attr('src', img.attr('data-leave'));
            });
        </script>

    </body>
</html>