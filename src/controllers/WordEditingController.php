<?php
namespace app\controllers;

use Yii;
use app\models\Words;
use yii\data\Pagination;
use \yii\web\Controller;
class WordEditingController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index',[

        ]);
    }

    public function actionDeleteWords()
    {

        $form = $_POST['Words'];
        $models = [];
        $pages = [];

        if(isset($_POST['Words'])){

            $word = Words::findOne(['id'  => $form['id']]);
            $word->delete();

        }

        $models = Words::find();
        $pages = new Pagination([
            'totalCount' => $models->count(),
            'pageSize' => 10
        ]);
        $models = $models
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('deleteWords',[
            'models' => $models,
            'pages' => $pages,
        ]);
    }

}