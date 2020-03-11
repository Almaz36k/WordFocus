<?php

namespace app\controllers;

use app\models\User;
use app\models\Word;
use app\models\UserWords;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class WordApiController extends Controller
{
    public function actionIndex()
    {

    }

    public function actionGetRandomWords()
    {
        $words_id = Word::getAllWordsId();

        $words = self::getRandomWordsById($words_id);

        return $words;
    }

    public function actionGetRandomUserWords()
    {
        $request = Yii::$app->request;
        $token = $request->post('token');

        if ($user = User::findIdentityByAccessToken($token)) {
            if ($user->getCountUserWords() >= 4) {
                $words_id = $user->getUserOwnerWordsId();

                $words = self::getRandomWordsById($words_id);

                return $words;
            }
            throw new BadRequestHttpException("not enough words");
        }
        throw new BadRequestHttpException("not valid token");
    }

    public function actionGetResultsAnswers()
    {
        $request = Yii::$app->request;
        $token = $request->post('token');

        if ($user = User::findIdentityByAccessToken($token)) {

            $words = $user->getAllUserWords();

            return $words;
        }
        throw new BadRequestHttpException("not valid token");
    }

    public function getRandomWordsById($array_with_keys)
    {
        $array_rand_id = array_rand(array_flip($array_with_keys), 4);

        $provider = new ActiveDataProvider([
            'query'      => Word::find()
                ->with('translate')
                ->asArray()
                ->where(['in', 'id', $array_rand_id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $posts = $provider->getModels();
        return $posts;
    }

    public function actionUpdateAnswers()
    {
        $request = Yii::$app->request;
        $token = $request->post('token');
        $word_id = $request->post('word_id');
        $translate_id = $request->post('translate_id');
        if ($user = User::findIdentityByAccessToken($token)) {

            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $user_word = UserWords::addWord($word_id, $translate_id, $user->id);
                $user_word->updateAnswers();

                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        throw new BadRequestHttpException("not valid token");
    }

    public function actionAddWord()
    {
        $request = Yii::$app->request;
        $word = $request->post('word');
        $translate = $request->post('translate');
        $token = $request->post('token');

        if ($user = User::findIdentityByAccessToken($token)) {
            $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {

                Word::addWord($word, $translate, $user->id);

                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        throw new BadRequestHttpException("not valid token");
    }
}