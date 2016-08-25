<?php

namespace backend\modules\member\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MoneyLog;

/**
 * MoneyLogSearch represents the model behind the search form about `common\models\MoneyLog`.
 */
class MoneyLogSearch extends MoneyLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'member_id', 'type', 'money_type', 'create_time', 'from'], 'integer'],
            [['money', 'old_money', 'new_money'], 'number'],
            [['remark'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = MoneyLog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => '3',
         ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $this->member_id=$this->member_id?$this->member_id:$_GET['member_id'];
        $query->andFilterWhere([
            'id' => $this->id,
            'member_id' => $this->member_id,
            'type' => $this->type,
            'money_type' => $this->money_type,
            'money' => $this->money,
            'create_time' => $this->create_time,
            'old_money' => $this->old_money,
            'from' => $this->from,
            'new_money' => $this->new_money,
        ]);

        $query->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
