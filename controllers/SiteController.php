<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Category;
use app\models\Album;
use app\models\Photos;
use yii\web\UploadedFile;
use yii\data\Pagination;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
        $category = Category::find()->all();
        $query = Album::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
    
        return $this->render('index', [
             'models' => $models,
             'pages' => $pages,
             'category' => $category,
        ]);
        return $this->render('index');
    }

    public function actionGallery($id){
        if(Yii::$app->request->get()){
            $query = Photos::find()->where(['aid' => $id]);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        
            return $this->render('gallery', [
                 'models' => $models,
                 'pages' => $pages,
            ]);
        }
    }
    public function actionGallerytwo($id){
        if(Yii::$app->request->get()){
            $query = Photos::find()->where(['cid' => $id]);
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        
            return $this->render('gallerytwo', [
                 'models' => $models,
                 'pages' => $pages,
            ]);
        }
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

    public function actionCreateAlbum(){
        $album = new Album();
        $photos = new Photos();
        $category = new Category();
        if ($category->load(Yii::$app->request->post()) 
        && $album->load(Yii::$app->request->post()) 
        && $photos->load(Yii::$app->request->post())) {
            $cat;
            //echo $album->name;
            //echo $category->name;
            if($cat = Category::findOne(['name'=>$category->name])){
                //echo $cat->cid;
            }else{
                $category->save();
                $cat = Category::findOne(['name'=>$category->name]);
            }
            $album->uid = Yii::$app->user->identity->uid;
            $album->save();
            $aid = $album->getPrimaryKey();
            $photos->url = UploadedFile::getInstances($photos, 'url');
            foreach ($photos->url as $file) {
                $photo = new Photos();
                $photo->aid = $aid;
                $photo->cid = $cat->cid;
                $photo->url = 'uploads/' . $file->baseName . '.' . $file->extension;
                $photo->save(false);
                $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
            }
            return $this->render(
                'CreateAlbum',
                [
                    'flag' => '1',
                    'album' => $album,
                    'photos' => $photos,
                    'category' => $category,
                ]
            );
        }else{
            return $this->render(
                'CreateAlbum',
                [
                    'flag' => '0',
                    'album' => $album,
                    'photos' => $photos,
                    'category' => $category,
                ]
            );
        }
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
}
