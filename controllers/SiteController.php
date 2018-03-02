<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use app\models\ItemForm;
use app\models\OrderForm;
use app\models\UserOrder;
use app\models\HistoryOrder;
use app\models\User;
use yii\db\Query;
use yii\helpers\Json;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
    public function actionIndex()
    {
        return $this->render('index');
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
            return $this->goBack();
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
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
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

    public function actionRegistration()
    {

        $model = new RegistrationForm();
        if (isset($_POST['RegistrationForm'])) {
            $model->attributes = Yii::$app->request->post('RegistrationForm');

            if ($model->validate() && $model->signup()) {

                return $this->goHome();
            }
        }
        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    public function actionOrder()
    {

        $userorder = new UserOrder();

        if (isset($_POST['UserOrder'])) {
            $userorder->attributes = Yii::$app->request->post('UserOrder');

            if ($userorder->validate() && $userorder->insertOrder()) {
                // return $this->goHome();
                return $this->render('entry-confirm', [
                    'userorder' => $userorder,
                ]);
            } else {
                return $userorder->errors;
            }


        } else {

            return $this->render('order_form', [
                'userorder' => $userorder,
            ]);
        }
    }

    public function actionHistory()
    {
        $query = new Query;

        $id_user = Yii::$app->user->identity->id_user;
        $id_role = Yii::$app->user->identity->id_role;
        if ($id_role == 1) {
            $query->select([
                    'uo.id_order',
                    'uo.restaurant',
                    'uo.date_order',
                    'uo.total',
                    'u.name',
                    'u.surname']
            )->from('user_order uo')
                ->join('INNER JOIN', 'user u', 'u.id_user=uo.id_user')
                ->orderBy('date_order desc');
        } else {
            $query->select([
                    'id_order',
                    'restaurant',
                    'date_order',
                    'total']
            )->from('user_order')
                ->where('id_user= ' . $id_user)
                ->orderBy('date_order desc');
        }
        $command = $query->createCommand();
        $historyorder = $command->queryAll();



        return $this->render('history', [
            'historyorder' => $historyorder,
        ]);

    }
    public function actionItems(){
        //        if (Yii::$app->request->isAjax) {
        //    return "sacasc";
        //echo "HOHOHO";
        //  if ($_POST['a']) {
//                $a = $_POST['a'];
//                $query_items->select([
//                        'item_name',
//                        'item_quantity',
//                        'price',
//                        'id_order']
//                )->from('item_order')
//                    ->where('id_order=' . $a);
//                $command = $query_items->createCommand();
//                $items = $command->queryAll();
//
//                return $this->render('history', [
//                    'historyorder' => $historyorder,
//                    'items' => $items
//                ]);
        // }
        //   }
        if(\Yii::$app->request->isAjax) {
            $a=$_POST['a'];
            $query_items = new Query;
            $query_items->select([
                        'item_name',
                        'item_quantity',
                        'price',
                        'id_order']
                )    ->from('item_order')
                    ->where('id_order=' . $a);
                $command = $query_items->createCommand();
                $items = $command->queryAll();
          return json_encode($items);

        }
        else{
            return "Cry";
        }
    }


}
