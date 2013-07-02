<?php

Class TechnicalsFormat extends Eloquent
{

    protected $table='technicals_formats';
    protected $primaryKey = 'technicals_format_id';

    public function technical()
    {
        return $this->belongsTo('Technical');
    }

}