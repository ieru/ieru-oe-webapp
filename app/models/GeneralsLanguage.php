<?php

Class GeneralsLanguage extends Eloquent
{
    protected $table = 'generals_languages';
    protected $primaryKey = 'generals_language_id';

    public function general()
    {
    	return $this->belongsTo('General');
    }

}