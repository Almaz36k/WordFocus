<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "words".
 *
 * @property int $id
 * @property string $word
 * @property string $translate
 */
class Words extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'words';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['word'], 'required'],
            [['word', 'translate'], 'string', 'max' => 255],
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
            'translate' => 'Translate',
        ];
    }
}
