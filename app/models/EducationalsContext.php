<?php

Class EducationalsContext extends Eloquent
{

    protected $table='educationals_contexts';
    protected $primaryKey = 'educationals_context_id';

    public function educational()
    {
        return $this->belongsTo('Educational');
    }

}