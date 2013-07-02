<?php

Class ContributesEntity extends Eloquent
{

    protected $table='contributes_entitys';
    protected $primaryKey = 'contributes_entity_id';

    public function contribute()
    {
        return $this->belongsTo('Contribute');
    }

}