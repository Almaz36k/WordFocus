<?php


namespace app\controllers;


use yii\base\DynamicModel;
use yii\rest\ActiveController;

class WordController extends ActiveController
{
    public $modelClass = 'app\models\Words';

    public function actions() {
        $actions = parent::actions();

        $actions['index']['dataFilter'] = [
            'class' => 'yii\data\ActiveDataFilter',
            'searchModel' => function () {
                return (new DynamicModel([
                    'id' => null,
                    'word' => null
                ]))->addRule('id', 'integer')
                    ->addRule('word', 'string');
            }
        ];

        return $actions;
    }

    public function actionRandom()
    {
        $i = 1;

        return $i;
    }
}