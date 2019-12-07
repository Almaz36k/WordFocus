<?php
namespace app\controllers;

use Yii;
use yii\rest\Controller;
use \app\models\UserNew;

class AuthController extends Controller
{
    public function actionIndex()
    {
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;

        $name = $request->post('name');
        $password = $request->post('password');

        $user = UserNew::findByName($name);
       if($user->validatePassword($password)) {
           $user->token = Yii::$app->security->generateRandomString(64);
           $user->save();
           return $user->token;
       }
       return false;
    }

    public function actionLogout()
    {
        $request = Yii::$app->request;
        $token = $request->post('token');
        $user = UserNew::findOne(['token' => $token]);
        $user->token = '';
        $user->save();
    }

}