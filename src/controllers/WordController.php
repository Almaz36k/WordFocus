<?php

namespace app\controllers;

use app\models\AddWordForm;
use Yii;
use app\models\Word;
use app\models\SearchWord;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WordController implements the CRUD actions for Word model.
 */
class WordController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SearchWord();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->loadModel($id),
        ]);
    }

    public function actionCreate()
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

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $model->translate[0]->setAttributes(Yii::$app->request->post('Translate'));
            $model->translate[0]->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        foreach ($model['translate'] as $translate)
            $translate->delete();
        $model->delete();

        return $this->redirect(['index']);
    }

    protected function loadModel($id)
    {
        $model = Word::find()
            ->with('translate')
            ->where(['id' => $id])
            ->one();

        if ( $model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
