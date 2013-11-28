@extends('layouts.admin')


@section('content')
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
                    <span class="help-block"><?php echo $helpers[$key]?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </fieldset>
    </div>
</form>
@stop