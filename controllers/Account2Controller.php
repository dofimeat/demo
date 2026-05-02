<?php

namespace app\controllers;

use app\models\Application;
use app\models\Course;
use app\models\Feedback;
use app\models\PayType;
use app\models\Status;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Account2Controller implements the CRUD actions for Application model.
 */
class Account2Controller extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function beforeAction($action)
    {
        // your custom code here, if you want the code to run before action filters,
        // which are triggered on the [[EVENT_BEFORE_ACTION]] event, e.g. PageCache or AccessControl

        if (!parent::beforeAction($action)) {
            return false;
        }

        if (Yii::$app->user->isGuest || Yii::$app->user->identity->isAdmin) {
            return $this->redirect('/');
        }

        return true; // or false to not run the action
    }

    /**
     * Lists all Application models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Application::find(),
            
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param int $id №
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Application();
        $courses = Course::getCourse();
        $payTypes = PayType::getPayTypes();
        // VarDumper::dump($courses, 10, true);
        // die;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) ) {
                $model->user_id = Yii::$app->user->id;
                $model->status_id = Status::getStatusId('new');

                if ($model->save()) {
                    Yii:$app->session->setFlash('succes', 'Заявка успешно добавлена');
                    return $this->redirect(['view', 'id' => $model->id]);
                } 
                // return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'courses' => $courses,
            'payTypes' => $payTypes,
        ]);
    }

    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id №
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionFeedback($id)
    {
        $model = new Feedback();
        $model->application_id = $id;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
             Yii::$app->session->setFlash('succes', 'Отзыв о курсе успешно добавлен');
            return $this->redirect(['view', 'id' => $model->application_id]);
        }

        return $this->render('feedback', [
            'model' => $model,
        ]);
    }


    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id №
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
