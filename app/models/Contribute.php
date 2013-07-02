<?php

Class Contribute extends Eloquent
{

    protected $table = 'contributes';
    protected $primaryKey = 'contribute_id';

    public function contributesentity()
    {
        return $this->hasMany('ContributesEntity');
    }

    public function lom()
    {
        return $this->belongsTo('Lom');
    }

    public function metametadata()
    {
        return $this->belongsTo('Metametadata');
    }

    public function lifecycle()
    {
        return $this->belongsTo('Lifecycle');
    }

}