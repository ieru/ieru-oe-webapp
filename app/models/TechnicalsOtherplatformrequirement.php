<?php
Class TechnicalsOtherplatformrequirement extends Eloquent
{

    protected $table='technicals_otherplatformrequirements';
    protected $primaryKey = 'technicals_otherplatformrequirement_id';

    public function technicals()
    {
        return $this->belongsTo('Technical');
    }

}
