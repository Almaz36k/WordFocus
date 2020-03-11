<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AddWordForm extends Model
{
    public $word;
    public $translate;
    public $user_id;
    public $raw_words;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    public function rawWordsProcessing()
    {
        if ($this->validate()) {
           $words = explode(",", $this->raw_words);
           $result = [];
           foreach ($words as $raw_word){
              $word = explode('-', $raw_word);
              $result[] = ['word' => trim($word[0]), 'translate' => trim($word[1])];
           }

            return $result;
        }
        return false;
    }
}
