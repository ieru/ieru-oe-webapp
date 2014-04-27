<?php


Class MetametadatasSchema extends Eloquent
{

    protected $table='metametadatas_schemas';
    protected $primaryKey = 'metametadatas_schema_id';

    public function metametada()
    {
        return $this->belongsTo('Metametadata');
    }

}