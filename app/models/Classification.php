<?php

Class Classification extends Eloquent
{

    protected $table='classifications';
    protected $primaryKey='classification_id';

    public function classificationskeyword()
    {
        return $this->hasMany('ClassificationsKeyword');
    }

    public function taxonpath()
    {
        return $this->hasMany('Taxonpath');
    }

    public function lom()
    {
        return $this->belongsTo('Lom');
    }
}