<?php

Class Technical extends Eloquent
{
    protected $table='technicals';
    protected $primaryKey = 'technical_id';

    public function requirement()
    {
        return $this->hasMany('Requirement');
    }

    public function technicalsformat()
    {
        return $this->hasMany('TechnicalsFormat');
    }

    public function technicalsinstallationremark()
    {
        return $this->hasMany('TechnicalsInstallationremark');
    }

    public function technicalslocation()
    {
        return $this->hasMany('TechnicalsLocation');
    }

    public function technicalsotherplatformrequirement()
    {
        return $this->hasMany('TechnicalsOtherplatformrequirement');
    }

    public function lom()
    {
        return $this->hasOne('Lom');
    }

}