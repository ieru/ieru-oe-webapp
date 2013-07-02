<?php

Class Taxonpath extends Eloquent
{

    protected $table='taxonpaths';
    protected $primaryKey = 'taxonpath_id';

    public function taxon()
    {
        return $this->hasMany('Taxon');
    }

    public function classification()
    {
        return $this->belongsTo('Classification');
    }

}