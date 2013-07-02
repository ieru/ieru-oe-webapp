<?php

Class General extends Eloquent
{
    protected $table='generals';
    protected $primaryKey = 'general_id';

    public function generalscontribute()
    {
        return $this->hasMany('GeneralsContribute');
    }

    public function generalstitle()
    {
        return $this->hasMany('GeneralsTitle');
    }

    public function generalsdescription()
    {
        return $this->hasMany('GeneralsDescription');
    }

    public function generalskeyword()
    {
        return $this->hasMany('GeneralsKeyword');
    }

    public function generalscoverage()
    {
        return $this->hasMany('GeneralsCoverage');
    }

    public function generalslanguage()
    {
        return $this->hasMany('GeneralsLanguage');
    }

    public function identifier()
    {
        return $this->hasMany('Identifier');
    }

    public function lom()
    {
        return $this->hasOne('Lom');
    }

}