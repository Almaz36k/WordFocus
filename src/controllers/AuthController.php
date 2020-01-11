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

    public function actionRegistration()
    {
        $request = Yii::$app->request;

        $name = $request->post('name');
        $password = $request->post('password');
        $email = $request->post('email');
        $token = Yii::$app->security->generateRandomString(64);

        $user_attribute = [
            'name'      => $name,
            'password'  => $password,
            'email'     => $email,
            'token'     => $token,
            'isAdmin'   => 0,
            'confirmed' => 0
        ];

        $create_user = UserNew::createUser($user_attribute);

        if($create_user) {
            Yii::$app->mailer->compose()
                ->setFrom('aksakal1243@gmail.com')
                ->setTo($email)
                ->setSubject('подтверждение регистрации')
                ->setHtmlBody(
                    '<a href="http://word_focus.azition.pro/auth/confirm-email?token=' . $token . '">
                         Подтвердить регистрацию
                       </a>'
                )
                ->send();
        }
    }

    public static function actionConfirmEmail()
    {
        $request = Yii::$app->request;

        $token = $request->get('token');

        $user = UserNew::findIdentityByAccessToken($token);

        if ($user) {
            $user->confirmEmail();
            return true;
        }

        return 1;
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;

        $name = $request->post('name');
        $password = $request->post('password');

        $user = UserNew::findByName($name);
        if ($user->validatePassword($password)) {
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