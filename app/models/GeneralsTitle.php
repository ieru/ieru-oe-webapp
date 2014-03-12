<?php

Class GeneralsTitle extends Eloquent
{
    protected $table = 'generals_titles';
    protected $primaryKey = 'generals_title_id';

    public function general()
    {
    	return $this->belongsTo('General');
    }

}