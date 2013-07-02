<?php


Class TechnicalsInstallationremark extends Eloquent
{

    protected $table='technicals_installationremarks';
    protected $primaryKey = 'technicals_installationremark_id';

    public function technicals()
    {
        return $this->belongsTo('Technical');
    }

}
