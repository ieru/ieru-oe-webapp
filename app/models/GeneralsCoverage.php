<?php

Class GeneralsCoverage extends Eloquent
{
    protected $table = 'generals_coverages';
    protected $primaryKey = 'generals_coverage_id';

    public function general()
    {
    	return $this->belongsTo('General');
    }

    public function generalscoveragestext()
    {
        return $this->hasMany('GeneralsCoveragesText');
    }
}