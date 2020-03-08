<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\ContactForm;
use common\models\CmsArticle;
use common\models\CmsCategory;
use yii\data\Pagination;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [

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
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionArticle($id) {
        $model = CmsArticle::findOne((int)$id);

        if ($model == null) throw new NotFoundHttpException('Материал не найден!');

        return $this->render('article', [
            'model' => $model
        ]);
    }
    
    public function actionArticles(array $catids, $title = null, int $order = 0) {
        $query = CmsArticle::find()
                    ->joinWith(['cmsCategories', ])
                    ->where(['cms_category.id' => $catids])
                    ->andWhere(['cms_article.published' => true])
                    ->andWhere(['<=', 'publish_up', date('Y-m-d H:i:s')])
                    ->andWhere(['>=', 'publish_down', date('Y-m-d H:i:s')]);

        switch ($order) {
            case 0:
            default:
                $query->orderBy('created_at DESC');
                break;
        }

        $this->view->params['title'] = $title;
        if (count($catids) == 1) {
            $this->view->params['title'] = CmsCategory::findOne($catids[0])->title;
        }

        //if (empty($title)) 
            //$title = implode(', ', ArrayHelper::getColumn(Category::find()->select('title')->where(['IN', 'id', $catids])->all(), 'title'));

        $pagination = new Pagination([
            'defaultPageSize' => Yii::$app->params['defaultPageSize'] ?? 20,
            'totalCount' => $query->count(),
        ]);

        $models = $query->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();

        return $this->render('blog', [
            'title' => $title,
            'models' => $models,
            'pagination' => $pagination,
        ]);

    }

    public function actionAcceptCookiesPolicy() {
        $cookies = Yii::$app->response->cookies;

        $cookies->add(new \yii\web\Cookie([
            'name' => 'showAcceptCookiesNotify',
            'value' => false,
        ]));

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionCookies() {
        return $this->render('cookies');
    }
}
