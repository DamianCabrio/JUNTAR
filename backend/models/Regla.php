<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "regla".
 *
 * @property string $name
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Permiso[] $permisos
 */
class Regla extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regla';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Permisos]].
     *
     * @return \yii\db\ActiveQuery|PermisoQuery
     */
    public function getPermisos()
    {
        return $this->hasMany(Permiso::className(), ['rule_name' => 'name']);
    }

    /**
     * {@inheritdoc}
     * @return ReglaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReglaQuery(get_called_class());
    }
}
