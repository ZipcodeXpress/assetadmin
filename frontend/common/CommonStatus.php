<?php
namespace frontend\common;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class CommonStatus
{
    public static function courier_status(){
        return [   
                0 => 'Normal',
                1 => 'Blocked',
            ];
    }
    public  static function member_status() {
        return [   0 => 'register completed',
            1 => 'profile has not been completed',
            2 => 'member has no binded cabinet',
            3 => 'member has no binded credit card'
        ];
    }
    public static function member_c_status() {
        return  [   0 => 'register completed',
            1 => 'member has not added cetification materials',
            2 => 'member has not been verified by the Zippora Official'
        ];
    }
    public  static function member_organization_approve_status() {
        return [
            0 => 'to be approved',
            1 => 'approved',
            2 => 'not approved',
        ];
    }
    public static function member_organization_status() {
        return  [
            0 => 'to be charged',
            1 => 'bill alreay charged',
            2 => 'recharged failed',
            3 => 'cancelled'
        ];
    }
    public static function proces_result_status()
    {
        return [  
            1 => 'to be approved',
            2 => 'approved',
            3 => 'rejected',
        ];
    }
    
    public static  function deliver_status() {
        return [        
            '0'   => 'unknown status',

            //order
    
            '7'   => 'timeout to pay',
            '8'   => 'wait for payment',
            '9'   => 'fail to pay',
    
            '10'  => 'order success',
            '11'  => 'member cancel',
    
            '27'  => 'timeout to store',
    
            //store
            '29'  => 'fail to store',
            '30'  => 'store success',
    
            '47'  => 'timeout to token',//not used
    
            //token
            '50'  => 'order has been token',
                '51'  => 'courier cancel',
                '67'  => 'timeout to fetch',
    
            //fetch
            '69'  => 'fail to fetch',
            '70'  => 'fetch success',
            '71'  => 'fetch complain',
            '79'  => 'lost',
    
            '87'  => 'timeout to deliver',
    
            //deliver
            '89'  => 'fail to deliver',
            '90'  => 'deliver success',
    
            '97'  => 'timeout to pick',
    
            //pick
            '99' => 'fail to pick',
            '100' => 'pick success',
            '101' => 'pick complain',];
    }
    public static function card_status(){
        return [
            0 => 'Blocked',
            1 => 'Normal',
        ];
    }
    public static function service_type()
    {
        return [
            'ziplocker' => 'Ziplocker',
            'zippora' => 'Zippora',
            'store' => 'Store',
            'share' => 'Share',
        ];
    }
}
