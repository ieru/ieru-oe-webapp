<!DOCTYPE html>
<html lang="en">

    <head>
        <title><?php echo $title ?></title>
        <link href="/css/_app.css" rel="stylesheet" media="screen">
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

            </div>
        </div>

        <header id="header">
            <div class="container">
                <a href="/#"><h1 class="pull-left hidden-sm">Organic.Edunet</h1></a>
                <nav class="hidden-sm">
                    <ul class="list-inline">
                        <li><a href="/"><?php echo Lang::get('website.home') ?></a></li>
                        <li><a href="/#/navigation"><?php echo Lang::get('website.navigational_search') ?></a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="container">
            <div id="admin-view" class="row">
                <div id="admin-view-aside" class="col-lg-4">
                    <div class="well" style="padding: 0">
                        <ul class="nav bs-sidenav">
                            <li><a href="/admin/">Administration</a></li>
                            <li><a href="/admin/langfiles">Language files</a></li>
                        </ul>
                    </div>
                </div>
                <div id="admin-view-main" class="col-lg-8">
                    <div class="row">
                        <div class="col col-lg-12">
                            Available languages: 
                            <a href="?to=en">English</a>
                            | <a href="?to=fr">French</a>
                            | <a href="?to=es">Spanish</a>
                            | <a href="?to=de">German</a>
                            | <a href="?to=lv">Latvian</a>
                            | <a href="?to=et">Estonian</a>
                            | <a href="?to=el">Greek</a>
                            | <a href="?to=tr">Turk</a>
                            | <a href="?to=it">Italian</a>
                            | <a href="?to=pl">Polish</a>
                        </div>
                        <form class="form-horizontal" method="POST">
                            <div class="col col-lg-2">
                                <div id="save-button">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                            <div class="col col-lg-10">
                                 <fieldset>
                                    <legend>Language Tools (current lang: <strong><?php echo @$_GET['to'] ? $_GET['to'] : 'en' ?></strong>)</legend>
                                    <?php foreach ( $lang as $key=>$line ): ?>
                                    <div class="control-group">
                                        <label class="control-label" for="inputEmail"><?php echo $key?></label>
                                        <div class="controls">
                                            <input class="span5" type="text" id="inputEmail" name="<?php echo $key?>" value="<?php echo $line?>">
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </fieldset>
                            </div>
                        </form>
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
                offset:{
                    top: 250,
                }
            });
        </script>
    </body>
</html>