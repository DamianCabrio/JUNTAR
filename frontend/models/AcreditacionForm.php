<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AcreditacionForm extends Model
{
    public $codigoAcreditacion;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigoAcreditacion'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigoAcreditacion' => 'Codigo de Acreditacion',
        ];
    }
}
