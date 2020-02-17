<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AdminController
{
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /*public function actionMigrate()
    {
        $users = Users::find()->all();
        $errors=[];
        foreach ($users as $one) {
            $user = User::findOne($one->id);
            $user->last_seen = strtotime($one->last_seen);
            if(!$user->save()) $errors[] = $user->getErrors();
        }
        return $this->render('migrate', [
            'errors' => $errors,
        ]);
    }*/


    /*public function actionMigrate()
    {
        $users = Users::find()->all();
        $errors=[];
        foreach ($users as $one) {
            $user = new User();
            $user->id = $one->id;
            $user->username = $one->username;
            $user->email = $one->email;
            $user->password_hash = $one->password;
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->created_at = strtotime($one->created_at);
            $user->updated_at = strtotime($one->updated_at);
            $user->is_activated = $one->is_activated;
            $user->activated_at = $one->activated_at;
            $user->last_login = $one->last_login;
            $user->last_seen = $one->last_seen;
            $user->name = $one->name;
            $user->surname = $one->surname;
            $user->phone = $one->phone;
            $user->sex = $one->sex;
            $user->broker_phone = $one->broker_phone;
            $user->status = $one->is_activated==1 ? 10 : 9;

            if(!$user->save()) $errors[] = $user->getErrors();
            //var_dump($user->save());
        }


        return $this->render('migrate', [
            'errors' => $errors,
        ]);
    }*/


}
