<?php

namespace app\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "word".
 *
 * @property int $id
 * @property string $word
 */
class Word extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'word';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['word'], 'required'],
            [['word'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word' => 'Word',
        ];
    }

    public static function searchWord($word)
    {
        return Word::findOne(['word' => $word]);
    }

    public static function addWord($new_word,$new_translate,$user_id)
    {
        $word = Word::searchWord($new_word);
        if(!$word){
            $word = new Word();
        }
        $word->word = $new_word;
        if(!$word->save()){
            throw new Exception(json_encode($word->getErrors()));
        }
        $translate = Translate::addTranslate($word->id, $new_translate);
        UserWords::addWord($word->id, $translate->id, $user_id);
    }

    public function getTranslate()
    {
        return $this->hasMany(Translate::className(), ['word_id' => 'id']);
    }

    public static function getAllWordsId()
    {
        $all_id = Word::find()
            ->select('id')
//          ->limit('count(t.id)/2')
//           ->orderBy('good_answers')
            ->asArray()
            ->all();

        $array_id = [];
        foreach ($all_id as $id) {
            $array_id[] = $id['id'];
        }

        return $array_id;
    }
}
