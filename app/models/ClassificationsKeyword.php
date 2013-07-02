<?php

Class ClassificationsKeyword extends Eloquent
{

    protected $table='classifications_keywords';
    protected $primaryKey='classifications_keyword_id';

    public function classification()
    {
        return $this->belongsTo('Classification');
    }

}