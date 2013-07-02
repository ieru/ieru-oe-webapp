<?php

Class GeneralsCoveragesText extends Eloquent
{
    protected $table = 'generals_coverages_texts';
    protected $primaryKey = 'generals_coverages_text_id';

    public function generalcoverage()
    {
        return $this->belongsTo('GeneralsCoverage');
    }
}