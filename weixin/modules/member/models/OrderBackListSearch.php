<?php
/**
 * 商品列表搜索类
 * @author xiaoma
 */

namespace weixin\modules\member\models;

use common\models\OrderBack;
use Yii;
use yii\data\ActiveDataProvider;
use yii\base\Model;
use common\enum\OrderBackEnum;
/**
 * Categorysearch represents the model behind the search form about `common\models\Goods`.
 */
class OrderBackListSearch extends OrderBack
{
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */

    /**
     *查询列表页数据获取
     */
    public function search(){
        $query = OrderBack::find();
        /**外接表 goods_count 和sku */
        $query->joinWith('order')->joinWith('goods')->joinWith('sku');

        $query->where(['back_member_id' => Yii::$app->user->id]);

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
