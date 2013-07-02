<?php

Class GeneralsKeyword extends Eloquent
{
    protected $table = 'generals_keywords';
    protected $primaryKey = 'generals_keyword_id';

    public function general()
    {
    	return $this->belongsTo('General');
    }

    public function generalskeywordtext()
    {
        return $this->hasMany('GeneralsKeywordsText');
    }
}