<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "photos".
 *
 * @property integer $pid
 * @property string $url
 * @property integer $aid
 * @property integer $cid
 *
 * @property Category $c
 * @property Album $a
 */
class Photos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'aid', 'cid'], 'required'],
            [['url'], 'string'],
            [['aid', 'cid'], 'integer'],
            [['cid'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cid' => 'cid']],
            [['aid'], 'exist', 'skipOnError' => true, 'targetClass' => Album::className(), 'targetAttribute' => ['aid' => 'aid']],
            [['url'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'url' => 'Url',
            'aid' => 'Aid',
            'cid' => 'Cid',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getC()
    {
        return $this->hasOne(Category::className(), ['cid' => 'cid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getA()
    {
        return $this->hasOne(Album::className(), ['aid' => 'aid']);
    }
    public function upload()
    {
        if ($this->validate()) { 
            
            return true;
        } else {
            return false;
        }
    }
}
