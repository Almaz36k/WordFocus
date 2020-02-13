<?php

namespace app\models;

use Yii;
use yii\db\Exception;

/**
 * This is the model class for table "user_words".
 *
 * @property int $id
 * @property int $word_id
 * @property int $translate_id
 * @property int $user_id
 * @property int $is_owner
 * @property int $good_answers
 */
class UserWords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_words';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['word_id', 'translate_id', 'user_id'], 'required'],
            [['word_id', 'translate_id', 'user_id', 'is_owner', 'good_answers'], 'default', 'value' => null],
            [['word_id', 'translate_id', 'user_id', 'is_owner', 'good_answers'], 'integer'],
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
            'translate_id' => 'Translate ID',
            'user_id' => 'User ID',
            'is_owner' => 'Is Owner',
            'good_answers' => 'Good Answers',
        ];
    }

    public function updateAnswers()
    {
        $this->good_answers = ($this->good_answers + 1);
        if(!$this->save()){
            throw new Exception(json_encode($this->getErrors()));
        }
    }

    public static function checkUniquenessWordAndTransalte($word_id, $translate_id, $user_id)
    {
        return UserWords::find()
            ->where(['word_id' => $word_id, 'translate_id' => $translate_id, 'user_id' => $user_id])
            ->one();
    }

    public static function addWord($word_id, $translate_id, $user_id)
    {
        if(!$user_word = UserWords::checkUniquenessWordAndTransalte($word_id, $translate_id, $user_id)){
            $user_word = new UserWords();
            $user_word->word_id = $word_id;
            $user_word->translate_id = $translate_id;
            $user_word->user_id = $user_id;
            $user_word->is_owner = 1;
            $user_word->good_answers = 0;
            if(!$user_word->save()){
                throw new Exception(json_encode($user_word->getErrors()));
            }
        }
        $user_word->updateAnswers();
    }

    public function getWords()
    {
        return $this->hasOne(Word::className(), ['id' => 'word_id']);
    }
}
