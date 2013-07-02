<?php
Class TechnicalsLocation extends Eloquent
{

    protected $table='technicals_locations';
    protected $primaryKey = 'technicals_location_id';

    public function technical()
    {
        return $this->belongsTo('Technical');
    }

}