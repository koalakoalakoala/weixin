<?php

namespace backend\modules\member\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MemberInfo;

/**
 * MemberInfoSearch represents the model behind the search form about `common\models\MemberInfo`.
 */
class MemberInfoSearch extends MemberInfo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'member_id', 'province_id', 'city_id', 'area_id', 'is_verify', 'create_time'], 'integer'],
            [['realname', 'province', 'city', 'area', 'detail', 'avatar', 'idcard', 'heard_img', 'front_img', 'back_img'], 'safe'],
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
        $query = MemberInfo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'member_id' => $this->member_id,
            'province_id' => $this->province_id,
            'city_id' => $this->city_id,
            'area_id' => $this->area_id,
            'is_verify' => $this->is_verify,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'realname', $this->realname])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'idcard', $this->idcard])
            ->andFilterWhere(['like', 'heard_img', $this->heard_img])
            ->andFilterWhere(['like', 'front_img', $this->front_img])
            ->andFilterWhere(['like', 'back_img', $this->back_img]);

        return $dataProvider;
    }
}
