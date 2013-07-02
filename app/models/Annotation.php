<?php

Class Annotation extends Eloquent
{

    protected $table='annotations';
    protected $primaryKey='annotation_id';

    public function lom()
    {
        return $this->belongsTo('Annotation');
    }

}