<?php

namespace weixin\modules\member\controllers;

use Yii;
use yii\web\Controller;
use common\service\BankService;
use common\models\Bank;

/**
 * BankController implements the CRUD actions for Bank model.
 */
class BankController extends Controller
{

    /**
     *设置默认
     */
    public function actionSetdefault($id){
        $bankService=new BankService();
        echo $bankService->setDefalut($id);
    }

    /**
     *删除
     */
    public function actionDelete($id)
    {
        $bs = new BankService;
        echo $bs->delete($id);
    }

    /**
     * 列表
     */
    public function actionIndex()
    {
        $bs = new BankService;
        $model = $bs->getList();
    	return $this->render('index', ['list'=>$model]);
    }

    /**
     * 创建
     */
    public function actionCreate(){
        $model=new Bank();
        if ($model->load(Yii::$app->request->post())) {
            $model->member_id = Yii::$app->user->id;
            $model->card_type = 0;
            $model->create_time = time();
            //若用户没有记录，用户没选默认，自动设置为默认
            if (!isset($_POST['is_default'])) {
                $count = Bank::find()->where(['member_id'=>$model->member_id
                    , 'is_del'=>0])->count();
                if ($count == 0) {
                    $model->is_default = 1;
                }
            } else {
                $model->is_default = 1;
            }
            if ($model->save()) {
                if ($model->is_default) {
                    Bank::updateAll(['is_default'=>false],'id <> '.$model->id);
                }
                return $this->redirect('index');
            }
        }
        return $this->render('create',['model'=>$model]);
    }
}
