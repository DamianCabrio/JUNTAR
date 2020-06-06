<?php

namespace frontend\models;

use Yii;
use backend\models\Usuario;

/**
 * This is the model class for table "expositor".
 *
 * @property int $idExpositor
 * @property int $idUsuario
 *
 * @property Usuario $idUsuario0
 * @property PresentacionExpositor[] $presentacionExpositors
 */
class Expositor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expositor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idUsuario'], 'required'],
            [['idUsuario'], 'integer'],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idUsuario' => 'idUsuario']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idExpositor' => 'Id Expositor',
            'idUsuario' => 'Id Usuario',
        ];
    }

    /**
     * Gets query for [[IdUsuario0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuario::className(), ['idUsuario' => 'idUsuario']);
    }

    /**
     * Gets query for [[PresentacionExpositors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPresentacionExpositors()
    {
        return $this->hasMany(PresentacionExpositor::className(), ['idExpositor' => 'idExpositor']);
    }
}
