<?php

namespace backend\modules\member\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Member;
use common\widgets\datepicker\DatePicker;

/**
 * MemberSearch represents the model behind the search form about `common\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * 截至时间
     * @var unknown
     */
    public $create_time_end;
    
    /**
     * 继承方法
     * (non-PHPdoc)
     * @see \common\models\Member::attributeLabels()
     */
     public function attributeLabels()
     {
         $data = parent::attributeLabels();
         $data['create_time_end']= '';
         return $data;
     }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_buy', 'r_member_id', 'cash_time', 'source', 'store_id'], 'integer'],
            [['username', 'password', 'mobile', 'zf_pwd', 'level_id', 'relations', 'cash_code', 'operator','level'], 'safe'],
            [['money', 'cash_money', 'gold_points', 'fronze_cash_money', 'fronze_money', 'cz_money'], 'number'],
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
        $query = Member::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => '15',
            ]
        ]);

        //关联查询
        $query->joinWith('member_info')
                ->joinWith('levels')
                ->joinWith('r_member');
        DatePicker::strToTime($this, $params, ['create_time','create_time_end']);

        $this->load($params);
        $query->andFilterWhere(['=', Member::tableName().'.level', $this->level])
            // ->andFilterWhere(['>', 'dmall_member.store_id', $this->store_id])
            ->andFilterWhere(['=', Member::tableName().'.id', $this->id])
            ->andFilterWhere(['like', Member::tableName().'.username', $this->username])
            ->andFilterWhere(['like', Member::tableName().'.mobile', $this->mobile]);
        // if($this->store_id)
        if($this->store_id!=null){
            $gx=$this->store_id?'>':'=';
            $query->andFilterWhere([$gx, Member::tableName().'.store_id', 0]);
        }
        $create_time=$this->getSearchTime(Member::tableName().'.create_time',$this->create_time ,$this->create_time_end);
        if($create_time){
             $query->andFilterWhere($create_time);
        }
            
        return $dataProvider;
    }
}
