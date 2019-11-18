<?php


namespace app\controllers;

use Yii;
use yii\rest\Controller;
class ApiController extends Controller
{
    public function actionIndex()
    {
        return [ 'item' => 'Hello world'];
    }
}