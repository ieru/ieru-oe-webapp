<?php

Class GeneralsDescription extends Eloquent
{
    protected $table = 'generals_descriptions';
    protected $primaryKey = 'generals_description_id';

    public function general()
    {
    	return $this->belongsTo('General');
    }

}