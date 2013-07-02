<?php

Class Educational extends Eloquent
{

    protected $table='educationals';
    protected $primaryKey = 'educational_id';

    public function educationalscontext()
    {
        return $this->hasMany('EducationalsContext');
    }

    public function educationalsdescription()
    {
        return $this->hasMany('EducationalsDescription');
    }

    public function educationalslanguage()
    {
        return $this->hasMany('EducationalsLanguage');
    }

    public function educationalstype()
    {
        return $this->hasMany('EducationalsType');
    }

    public function educationalstypicalagerange()
    {
        return $this->hasMany('EducationalsTypicalagerange');
    }

    public function educationalsuserrole()
    {
        return $this->hasMany('EducationalsUserrole');
    }

    public function lom()
    {
        return $this->belongsTo('Lom');
    }

}