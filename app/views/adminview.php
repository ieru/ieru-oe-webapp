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
            <div class="row" style="margin: 10px 0; ">
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
                </div>
            </div>
            <div class="row">
                <form class="form-horizontal" method="POST">
                    <div class="col col-lg-4">
                        <button type="submit" class="btn btn-primary pull-right">Save changes</button>
                    </div>
                    <div class="col col-lg-8">
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

        <footer id="footer">
            <div class="container">
                <ul class="pull-left list-unstyled">
                </ul>
                <p>&copy; Organic.Edunet 2013</p>
            </div>
        </footer>

    </body>

</html>