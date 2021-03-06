<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Texts;
use common\models\Services;
use common\models\GeoCities;
use common\models\SeoCatalogUrls;
use common\models\Pages;
use common\models\SystemFiles;
use common\services\auth\SignupService;
use yii\helpers\Html;
use common\models\BcItems;
use common\models\BcPlaces;
use common\models\BcPlacesSell;
use common\models\GeoDistricts;
use common\models\GeoSubways;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    public $title_main;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
     * @return mixed
     */
    public function actionIndex()
    {
        $city = GeoCities::find(1)->one();
        $seo = SeoCatalogUrls::find()->where(['id' => 88])->multilingual()->one();
        $rentLinks = json_decode($seo->links2);
        $saleLinks = json_decode($seo->links3);
        /* ссылки arenda-ofisa и prodazha-ofisov по умолчание в форме
        $mainRent = trim($seo->main_rent_link_href, '/');
        $mainSell = trim($seo->main_sell_link_href, '/');
        */
        //ссылки на arenda-ofisa-v-kieve и kupit-ofis-v-kieve по умолчание в форме
        $mainRent = $city->slug;
        $mainSell = $city->slug_sell;

        $slides = SystemFiles::find()->where(['attachment_type' => 'slide'])->orderBy('sort_order')->all();
        $images = [];
        if (!empty($slides)) {
            foreach ($slides as $index => $slide) {
                $images[$index]['url'] = $slide->imgSrc;
                $images[$index]['href'] = $slide->description;
                $images[$index]['title'] = $slide->title;
            }
        } else {
            $images[0]['url'] = '/img/promo_bg.jpg';
            $images[0]['href'] = '#';
            $images[0]['title'] = '';
        }
        //debug($images); die();
        //$bc_count = $city->bc_count;
        switch (Yii::$app->language) {
            case 'ru':
                $inflect = $city->inflect;
                break;
            case 'ua':
                $inflect = getDefaultTranslate('inflect', Yii::$app->language, $city);
                break;
            case 'en':
                $inflect = $city->name;
        }

        return $this->render('index', [
            'inflect' => $inflect,
            'seo' => $seo,
            'city' => $city,
            'rentLinks' => $rentLinks,
            'saleLinks' => $saleLinks,
            'mainRent' => $mainRent,
            'mainSell' => $mainSell,
            'images' => $images,
        ]);
    }


    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionSupport()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            //if(Yii::$app->user->returnUrl != '/')
            //return $this->goBack();
            //else return
            return Yii::$app->request->referrer ? $this->redirect(Yii::$app->request->referrer) : $this->goHome();

        } else {
            return $this->renderAjax('support', [
                'model' => $model,
            ]);
        }
    }

    //Форма подписки из виджета
    public function actionSubscription()
    {
        $model = new \common\models\Subscription();
        $str = '<div class="contact_popup_header">
                      <button type="button" class="close close_btn" data-dismiss="modal" aria-label="Close">
                      <i class="close_white"></i></button>
                      <div class="contact_person_desc">';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $email = Html::encode($model->email);
            $model->email = $email;
            $model->addtime = (string)time();
            if ($model->save()) {
                Yii::$app->response->refresh(); //очистка данных из формы
                $str .= '<p style="color:white">Подписка оформлена!</p>';
            }
        } else {
            //Проверяем наличие фразы в массиве ошибки
            if (strpos($model->errors['email'][0], 'already') !== false) {
                $str .= '<p style="color:red">Вы уже подписаны!</p>';
            } else {
                $str .= '<p style="color:red">Ошибка оформления подписки.</p>';
            }
        }
        $str .= '</div></div>';
        echo $str;
        exit;
    }

    public function actionSubscribe()
    {
        return $this->renderAjax('subscribe');
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

    public function actionPages()
    {
        $model = Pages::find()->where(['id' => 2])->multilingual()->one();

        return $this->render('pages', [
            'model' => $model,
        ]);
    }

    public function actionSitemap()
    {
        $model = Pages::find()->where(['id' => 4])->multilingual()->one();

        return $this->render('pages', [
            'model' => $model,
        ]);
    }

    public function actionContacts()
    {
        $model = Pages::find()->where(['id' => 1])->multilingual()->one();

        return $this->render('pages', [
            'model' => $model,
        ]);

    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        //debug(Yii::$app->user->identity);
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->returnUrl != '/')
                return $this->goBack();
            else return
                Yii::$app->request->referrer ? $this->redirect(Yii::$app->request->referrer) : $this->goHome();
        } else {
            $model->password = '';

            return $this->renderAjax('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->username = $model->email;
            if ($model->signup()) {
                Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
                return $this->goHome();
            }
        }

        return $this->renderAjax('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionSearch()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            $referal = Yii::$app->request->post('referal');
            $target = Yii::$app->request->post('target');
            $result = Yii::$app->request->post('result');
            $city = Yii::$app->request->post('city');
//echo $target; die();

            $bcitems = $result=='bc' ? BcItems::searchItems($referal, $city) : null;
            //$bcitems = ArrayHelper::getColumn($bcitems, 'id'); //tmp for debugging

            $placesQuery = $target==1 ? BcPlaces::find() : BcPlacesSell::find();
            
            $places = $result=='offices'
            ? $placesQuery
                ->where(['archive' => 0])
                ->andWhere(['hide' => 0])
                ->andWhere(['or',
                    ['like', 'name', $referal],
                    ['like', 'name_ua', $referal],
                    ['like', 'name_en', $referal],
                    ['=', 'id',$referal]
                ])
                ->limit(10)
                ->orderBy('updated_at DESC')
                ->all()
            : null;
            //$places = ArrayHelper::getColumn($places, 'id'); //tmp for debugging

            $subways = GeoSubways::find()->where(['like', 'name', $referal])
                ->andWhere(['city_id' => $city])
                ->all();

            $districts = GeoDistricts::find()->where(['like', 'name', $referal])->andWhere(['city_id' => $city])->all();


            $target = $target===1 ? 'rent' : 'sell';
            return $this->renderPartial('_partial/_search-result', [
                'target' => $target,
                'bcitems' => $bcitems,
                'places' => $places,
                'subways' => $subways,
                'districts' => $districts,
            ]);
        }
       return false;
    }


}
