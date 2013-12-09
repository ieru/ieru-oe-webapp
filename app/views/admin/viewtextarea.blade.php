@extends('layouts.admin')


@section('content')
<div class="col col-lg-12">
    Available languages: 
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_EN ) ): ?>
    <a href="?to=en">English</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_FR ) ): ?>
    | <a href="?to=fr">French</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_ES ) ): ?>
    | <a href="?to=es">Spanish</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_DE ) ): ?>
    | <a href="?to=de">German</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_LV ) ): ?>
    | <a href="?to=lv">Latvian</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_ET ) ): ?>
    | <a href="?to=et">Estonian</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_EL ) ): ?>
    | <a href="?to=el">Greek</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_TR ) ): ?>
    | <a href="?to=tr">Turk</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_IT ) ): ?>
    | <a href="?to=it">Italian</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_PL ) ): ?>
    | <a href="?to=pl">Polish</a>
    <?php endif; ?>
    <?php if ( AdminController::$_user->check_permission( PERMISSION_ACCESS_LANG_FILES_AR ) ): ?>
    | <a href="?to=ar">Arabic</a>
    <?php endif; ?>
</div>
<form class="form-horizontal" method="POST">
    <div class="col col-lg-3">
        <div id="save-button">
            <button type="submit" class="btn btn-primary col-lg-12">Save changes</button>
        </div>
    </div>
    <div class="col col-lg-9">
         <fieldset>
            <legend>Language Tools (current lang: <strong><?php echo @$_GET['to'] ? $_GET['to'] : 'en' ?></strong>)</legend>
            <?php foreach ( $lang as $key=>$line ): ?>
            <div class="control-group">
                <label class="control-label" for="inputEmail"><?php echo $key?></label>
                <div class="controls">
                    <textarea class="span5" rows="5" type="text" id="inputEmail" name="<?php echo $key?>"><?php echo $line?></textarea>
                    <span class="help-block"><?php echo $helpers[$key]?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </fieldset>
    </div>
</form>
@stop