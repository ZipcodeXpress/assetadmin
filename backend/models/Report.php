<?php

namespace backend\models;

use Yii;

class Report extends \yii\db\ActiveRecord
{
    //统计公寓房间数
    public function  getAllRoomCount(){
        $sql="SELECT a.organization_id,a.organization_name, count(r.room_id) as room_count FROM `o_organization` a left join o_building b on a.organization_id=b.organization_id left JOIN o_room r on b.building_id = r.building_id GROUP BY a.organization_id";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
    public function  getAllMemberCount(){
        $sql="SELECT a.organization_id,a.organization_name,count(m.member_id) as member_count FROM o_organization a left join `o_member_organization` m on a.organization_id=m.organization_id GROUP BY a.organization_id";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
    public function  getAllMemberAmount(){
        $sql="SELECT m.email,m.phone,s.*,sum(amount) as amount FROM  statement s left join member m on s.member_id=m.member_id GROUP BY member_id";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
    public function  getOrganizationAmount(){
        $sql="SELECT a.organization_id,a.organization_name,SUM(s.amount) as amount FROM o_organization a left join `o_member_organization` m on a.organization_id=m.organization_id 
LEFT join statement s on m.member_id = s.member_id GROUP BY a.organization_id";
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        return $data;
    }
}