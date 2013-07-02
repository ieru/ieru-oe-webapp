<?php


Class Lom extends Eloquent
{

    protected $table='loms';
    protected $primaryKey = 'lom_id';

    public function annotation()
    {
        return $this->hasMany('Annotation');
    }

    public function classification()
    {
        return $this->hasMany('Classification');
    }

    public function contribute()
    {
        return $this->hasMany('Contribute');
    }

    public function educational()
    {
        return $this->hasMany('Educational');
    }

    public function general()
    {
        return $this->hasOne('General');
    }

    public function identifier()
    {
        return $this->hasMany('Identifier');
    }

    public function lifecycle()
    {
        return $this->hasOne('Lifecycle');
    }

    public function metametadata()
    {
        return $this->hasOne('Metametadata');
    }

    public function relation()
    {
        return $this->hasMany('Relation');
    }

    public function right()
    {
        return $this->hasOne('Right');
    }

    public function technical()
    {
        return $this->hasOne('Technical');
    }

}