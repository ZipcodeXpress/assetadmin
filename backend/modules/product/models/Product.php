<?php

namespace app\modules\product\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $product_id
 * @property integer $organization_id
 * @property string $product_name
 * @property integer $category_id
 * @property string $brand
 * @property string $manufacturer
 * @property string $UOM
 * @property integer $part_num
 * @property integer $model_num
 * @property integer $is_public
 * @property string $product_desc
 * @property string $product_image
 * @property string $product_thumbnail
 * @property string $instruction
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $end_date
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organization_id', 'category_id', 'part_num', 'model_num', 'is_public', 'create_time', 'update_time', 'end_date'], 'integer'],
            [['product_name'], 'string', 'max' => 60],
            [['brand', 'manufacturer', 'UOM'], 'string', 'max' => 20],
            [['product_desc'], 'string', 'max' => 120],
            [['product_image', 'product_thumbnail'], 'string', 'max' => 100],
            [['instruction'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'organization_id' => 'Organization ID',
            'product_name' => 'Product Name',
            'category_id' => 'Category ID',
            'brand' => 'Brand',
            'manufacturer' => 'Manufacturer',
            'UOM' => 'Uom',
            'part_num' => 'Part Num',
            'model_num' => 'Model Num',
            'is_public' => 'Is Public',
            'product_desc' => 'Product Desc',
            'product_image' => 'Product Image',
            'product_thumbnail' => 'Product Thumbnail',
            'instruction' => 'instruction',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'end_date' => 'End Date',
        ];
    }
}
