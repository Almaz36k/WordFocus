<?php
namespace app\controllers;

use app\models\UserNew;
use app\models\Word;
use app\models\UserWords;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
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
        if($user = UserNew::findIdentityByAccessToken($token)) {

            if ($my_words) {
                $all_id = UserWords::find()
                    ->select('word_id as id')
                    ->where(['user_id' => $user->id, 'is_owner' => 1])
                    ->asArray()
                    ->all();
            } else {
                $all_id = Word::find()
                    ->select('id')
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
        return ' not valid token';
    }


    public function actionUpdateAnswers()
    {
        $request = Yii::$app->request;
        $token = $request->post('token');
        $word_id = $request->post('word_id');
        $translate_id = $request->post('translate_id');
        if ($user = UserNew::findIdentityByAccessToken($token)) {
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
    }

    public function actionAddWord()
    {
        $request = Yii::$app->request;
        $word = $request->post('word');
        $translate = $request->post('translate');
        $token = $request->post('token');

        if($user = UserNew::findIdentityByAccessToken($token)) {
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
        return 'not valid token';
    }
}