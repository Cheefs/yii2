<?php

namespace app\controllers;

use app\models\forms\SignUpForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        return $this->redirect('login');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/account']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * сохранение посещенных пользователем страниц
     * @param $action
     * @param $result
     * @return mixed
     */
    public function afterAction($action, $result) {
        $session = Yii::$app->session;
        if ( $session->isActive ) {
            /** просто фильтрование от действия captcha которое не является страницей */
            if ( $action->id !== 'captcha' ) {
                $session->addFlash('prevAction', $action->id );
            }
        }
        return parent::afterAction($action, $result);
    }
    /**
     * Действие регистрации пользользователя
    */
    public function actionRegister() {
        $model = new SignUpForm();
        if ( $model->load(Yii::$app->request->post()) && $model->validate() ) {
            if ( $model->register() && Yii::$app->getUser()->login($model)  ) {
                return $this->goHome();
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }
}
