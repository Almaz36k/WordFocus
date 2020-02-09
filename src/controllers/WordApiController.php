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
        $request = Yii::$app->request;
        $token = $request->post('token');
        $my_words = $request->post('myWords');

        if($user = User::findIdentityByAccessToken($token)) {
            if ($my_words == 'true' && $user->getCountUserWords() >= 4) {
                $all_id = $user->getUserWords();
            } else {
                $all_id = Word::find()
                    ->select('id')
//                    ->limit('count(t.id)/2')
//                    ->orderBy('good_answers')
                    ->asArray()
                    ->all();
            }

            $array_id = [];
            foreach ($all_id as $id) {
                $array_id[] = $id['id'];
            }
            $array_rand_id = array_rand(array_flip($array_id), 4);

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
        throw new BadRequestHttpException("not valid token");
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
                UserWords::addWord($word_id, $translate_id, $user->id);

                $transaction->commit();
                return true;
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch(\Throwable $e) {
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

        if($user = User::findIdentityByAccessToken($token)) {
           $db = Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {

                Word::addWord($word,$translate,$user->id);

                $transaction->commit();
                return true;
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch(\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        throw new BadRequestHttpException("not valid token");
    }
}