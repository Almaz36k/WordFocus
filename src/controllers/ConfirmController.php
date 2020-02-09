<?php
namespace app\controllers;

use Yii;
use app\models\User;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class ConfirmController extends Controller
{
    public function actionIndex()
    {
        $request = Yii::$app->request;

        $token = $request->get('token');

        $user = User::findIdentityByAccessToken($token);

        if ($user) {
            $user->confirmEmail();

            return $this->render('index');
        }
       throw new BadRequestHttpException('Что то пошло не так!');
    }
}