<?php

Class Taxon extends Eloquent
{

    protected $table='taxons';
    protected $primaryKey = 'taxon_id';

    public function taxonpath()
    {
        return $this->belongsTo('Taxonpath');
    }
}