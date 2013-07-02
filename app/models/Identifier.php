<?php


Class Identifier extends Eloquent
{

    protected $table = 'identifiers';
    protected $primaryKey = 'identifier_id';

    public function lom()
    {
        return $this->belongsTo('Lom');
    }

    public function resource()
    {
        return $this->belongsTo('Resource');
    }

    public function general()
    {
        return $this->belongsTo('General');
    }

    public function metametadata()
    {
        return $this->belongsTo('Metametadata');
    }

}