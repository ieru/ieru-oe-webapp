<?php

Class EducationalsLanguage extends Eloquent
{

    protected $table='educationals_languages';
    protected $primaryKey = 'educationals_language_id';

    public function educational()
    {
        return $this->belongsTo('Educational');
    }

}