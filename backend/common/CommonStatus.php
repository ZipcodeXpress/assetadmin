<?php

namespace backend\common;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class CommonStatus
{
    public static function courier_status()
    {
        return [
            0 => 'Normal',
            1 => 'Blocked',
        ];
    }
    public  static function member_status()
    {
        return [
            0 => 'register completed',
            1 => 'profile has not been completed',
            2 => 'member has no binded cabinet',
            3 => 'member has no binded credit card'
        ];
    }
    public static function member_c_status()
    {
        return  [
            0 => 'register completed',
            1 => 'member has not added cetification materials',
            2 => 'member has not been verified by the Zippora Official'
        ];
    }
    public  static function member_organization_approve_status()
    {
        return [
            0 => 'to be approved',
            1 => 'approved',
            2 => 'not approved',
        ];
    }
    public static function member_organization_status()
    {
        return  [
            0 => 'to be charged',
            1 => 'bill already charged',
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
    
    public static function box_size()
    {
        return [
            10001 => 'Small',
            10002 => 'Middle',
            10003 => 'Large',
            10013 => 'S',
            10014 => 'M1',
            10015 => 'M2',
            10016 => 'M3',
            10017 => 'L',
            10018 => 'XL',
        ];
    }



    public static function product_inv_status()
    {
        return [
            0 => 'initial input to system',
            1 => 'in locker-available',
            2 => 'in locker- reserved',
            3 => 'in Possession by member',
            4 => 'damaged but in locker',
            5 => 'ended (out of service)',
        ];
    }

    public static  function deliver_status()
    {
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

            '47'  => 'timeout to token', //not used

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
            '101' => 'pick complain',
        ];
    }
    public static function card_status()
    {
        return [
            0 => 'Blocked',
            1 => 'Normal',
        ];
    }
    public static function service_type()
    {
        return [
            'zippora' => 'Zippora',
            'store' => 'Store',
            'share' => 'Share',
            'asset' => 'Asset',
            'ziplocker' => 'Ziplocker',
        ];
    }
    public  static function member_product_approve_status()
    {
        return [
            0 => 'to be approved',
            1 => 'approved',
            2 => 'not approved',
        ];
    }
    public static function member_product_status()
    {
        return  [
           1 => 'authorized',
           0 => 'not authorized',
            3 => 'cancelled'
        ];
    }

    public static function rental_status()
    {
        return [
            0 => 'initial input to system',
            1 => 'in locker-available',
            2 => 'in locker- reserved',
            3 => 'in Possession by member',
            4 => 'damaged but in locker',
            5 => 'ended (out of service)',
        ];
    }
}


