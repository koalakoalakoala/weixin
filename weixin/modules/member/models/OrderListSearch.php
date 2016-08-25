<?php
/**
 * 商品列表搜索类
 * @author xiaoma
 */

namespace weixin\modules\member\models;

use common\models\Order;
use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use common\enum\OrderEnum;
/**
 * Categorysearch represents the model behind the search form about `common\models\Goods`.
 */
class OrderListSearch extends Order
{
    private $_type;

    public function __construct($type)
    {
        $this->_type = $type;
        parent::__construct();
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    /**
     * 商品列表页数据获取
     */
    public function search(){
        $query = Order::find();
        /**外接表 goods_count 和sku */
        $query->joinWith('ordergoods')->joinWith('store');

        $query->where(['member_id' => Yii::$app->user->id]);
        /** 默认查询条件 */
        if($this->_type == "wait-pay"){
            $query->andWhere(['orderstatus' => OrderEnum::WAITING_PAYMENT]);
        }else if($this->_type == "wait-receive"){
            $query->andWhere(['orderstatus' => OrderEnum::WAITING_RECEVE]);
        }else if($this->_type == "wait-comment"){
            $query->andWhere(['orderstatus' => OrderEnum::FINISHED]);
            //TODO加上没有评论的条件
            $query->andWhere(['sn'=>0]); //目前评论没做，所以加个条件，不返回数据,将来加上未评论的过滤
        }

        $query->orderBy('id desc');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
                //'pageParam' => 'page',
                'defaultPageSize'=> 9,
                'validatePage' => TRUE,
            ],
        ]);

        return $dataProvider;
    }

}
