<?php


Class GeneralsKeywordsText extends Eloquent
{
    protected $table = 'generals_keywords_texts';
    protected $primaryKey = 'generals_keywords_text_id';

    public function generalkeyword()
    {
        return $this->belongsTo('GeneralsKeyword');
    }
}