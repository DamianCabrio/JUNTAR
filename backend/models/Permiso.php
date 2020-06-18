<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "permiso".
 *
 * @property string $name
 * @property int $type
 * @property string|null $description
 * @property string|null $rule_name
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Permiso[] $children
 * @property Permiso[] $parents
 * @property PermisoRol[] $permisoRols
 * @property PermisoRol[] $permisoRols0
 * @property Regla $ruleName
 * @property Usuario[] $users
 * @property UsuarioRol[] $usuarioRols
 */
class Permiso extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'permiso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            ['description', 'string'],
            ['name', 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Permiso',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Children]].
     *
     * @return \yii\db\ActiveQuery|PermisoQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Permiso::className(), ['name' => 'child'])->viaTable('permiso_rol', ['parent' => 'name']);
    }

    /**
     * Gets query for [[Parents]].
     *
     * @return \yii\db\ActiveQuery|PermisoQuery
     */
    public function getParents()
    {
        return $this->hasMany(Permiso::className(), ['name' => 'parent'])->viaTable('permiso_rol', ['child' => 'name']);
    }

    /**
     * Gets query for [[PermisoRols]].
     *
     * @return \yii\db\ActiveQuery|PermisoRolQuery
     */
    public function getPermisoRols()
    {
        return $this->hasMany(PermisoRol::className(), ['parent' => 'name']);
    }

    /**
     * Gets query for [[PermisoRols0]].
     *
     * @return \yii\db\ActiveQuery|PermisoRolQuery
     */
    public function getPermisoRols0()
    {
        return $this->hasMany(PermisoRol::className(), ['child' => 'name']);
    }

    /**
     * Gets query for [[RuleName]].
     *
     * @return \yii\db\ActiveQuery|ReglaQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(Regla::className(), ['name' => 'rule_name']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|UsuarioQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Usuario::className(), ['idUsuario' => 'user_id'])->viaTable('usuario_rol', ['item_name' => 'name']);
    }

    /**
     * Gets query for [[UsuarioRols]].
     *
     * @return \yii\db\ActiveQuery|UsuarioRolQuery
     */
    public function getUsuarioRols()
    {
        return $this->hasMany(UsuarioRol::className(), ['item_name' => 'name']);
    }

    /**
     * {@inheritdoc}
     * @return PermisoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PermisoQuery(get_called_class());
    }
}
