<?php
namespace app\controllers;

use app\models\Words;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
class WordRandomController extends Controller
{
    public function actionIndex()
    {
        $arrays_id = Words::find()
            ->select('id')
            ->asArray()
            ->all();
        $array_id = [];
        foreach ($arrays_id as $id){
            $array_id[] = $id['id'];
        }
        $array_rand_id = array_rand(array_flip($array_id),4);

        $provider = new ActiveDataProvider([
            'query' => Words::find()->where(['in','id', $array_rand_id]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $posts = $provider->getModels();
        return $posts;
    }
}