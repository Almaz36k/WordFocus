<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\UnauthorizedHttpException;

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

        $new_user = new User;
        $create_user = $new_user->createUser($user_attribute);

        if($create_user) {
            Yii::$app->mailer->compose()
                ->setFrom('aksakal1243@gmail.com')
                ->setTo($email)
                ->setSubject('Подтверждение регистрации')
                ->setHtmlBody(
                    '<a href="http://word_focus.azition.pro/confirm?token=' . $token . '">
                         Подтвердить регистрацию
                       </a>'
                )
                ->send();
        } else {
            throw new UnauthorizedHttpException("Login или Email уже заняты!");
        }
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;

        $name = $request->post('name');
        $password = $request->post('password');

        $user = User::findByName($name);
        if ($user->validatePassword($password)) {
            if ($user->confirmed == 1) {
                $user->token = Yii::$app->security->generateRandomString(64);
                $user->save();
                return $user->token;
            } else {
                throw new UnauthorizedHttpException("Подтвердите почту!");
            }
        }
        throw new UnauthorizedHttpException("Неверные данные!");
    }

    public function actionLogout()
    {
        $request = Yii::$app->request;
        $token = $request->post('token');
        $user = User::findOne(['token' => $token]);
        $user->token = '';
        $user->save();
    }

}