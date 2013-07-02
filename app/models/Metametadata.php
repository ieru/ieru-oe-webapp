<?php


Class Metametadata extends Eloquent
{
    protected $table='metametadatas';
    protected $primaryKey = 'metametadata_id';

    public function contribute()
    {
        return $this->hasMany('Contribute');
    }

    public function identifier()
    {
        return $this->hasMany('Identifier');
    }

    public function metametadatasschema()
    {
        return $this->hasMany('MetametadatasSchema');
    }

    public function lom()
    {
        return $this->belongsTo('Lom');
    }

}