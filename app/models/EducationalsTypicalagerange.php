<?php

Class EducationalsTypicalagerange extends Eloquent
{

    protected $table='educationals_typicalageranges';
    protected $primaryKey = 'educationals_typicalagerange_id';

    public function educational()
    {
        return $this->belongsTo('Educational');
    }

}