<?php

namespace app\controllers;

use app\models\AddWordForm;
use Yii;
use app\models\Word;
use yii\data\Pagination;
use yii\db\Exception;
use yii\web\Controller;


class WordEditController extends Controller
{

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $word = $request->post('Word');
        $delete = [];
        $update = [];

        if (isset($word)) {
            $word = Word::findOne(['id' => $word['id']]);
            $word->deleteWord();
        }

        $models = Word::find()->with('translate');
        $pages = new Pagination([
            'totalCount' => $models->count(),
            'pageSize'   => 10
        ]);
        $models = $models
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages'  => $pages,
        ]);
    }

    public function actionAddWords()
    {
        $model = new AddWordForm();
        $request = Yii::$app->request;
        $form = $request->post('AddWordForm');

        if(isset($form)) {
            $model->raw_words = $form['raw_words'];
            $words = $model->rawWordsProcessing();
            try {
                Word::addWords($words);
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        return $this->render('addWords', [
            'model' => $model,
        ]);
    }
}