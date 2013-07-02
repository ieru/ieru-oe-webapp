<?php

Class EducationalsType extends Eloquent
{

    protected $table='educationals_types';
    protected $primaryKey = 'educationals_type_id';

    public function educational()
    {
        return $this->belongsTo('Educational');
    }

}