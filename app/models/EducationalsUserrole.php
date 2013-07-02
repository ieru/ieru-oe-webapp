<?php

Class EducationalsUserrole extends Eloquent
{

    protected $table='educationals_userroles';
    protected $primaryKey = 'educationals_userrole_id';

    public function educational()
    {
        return $this->belongsTo('Educational');
    }

}