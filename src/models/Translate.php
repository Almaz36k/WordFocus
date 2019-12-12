<?php

namespace app\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "translate".
 *
 * @property int $id
 * @property int $word_id
 * @property string $translate
 */
class Translate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translate';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['word_id', 'translate'], 'required'],
            [['word_id'], 'default', 'value' => null],
            [['word_id'], 'integer'],
            [['translate'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'word_id' => 'Word ID',
            'translate' => 'Translate',
        ];
    }

    public static function checkUniquenessTranslation($word_id, $translate)
    {
        return Translate::find()
            ->where(['word_id' => $word_id, 'translate' => $translate])
            ->exists();
    }

    public static function addTranslate($word_id, $new_translate)
    {
        if(!Translate::checkUniquenessTranslation($word_id, $new_translate)) {
            $translate = new Translate();
            $translate->word_id = $word_id;
            $translate->translate = $new_translate;
            if(!$translate->save()){
                throw new Exception(json_encode($translate->getErrors()));
            }
            return $translate;
        }
    }
}
