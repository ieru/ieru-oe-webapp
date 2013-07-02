<?php

Class EducationalsDescription extends Eloquent
{

    protected $table='educationals_descriptions';
    protected $primaryKey = 'educationals_description_id';

    public function educational()
    {
        return $this->belongsTo('Educational');
    }

}