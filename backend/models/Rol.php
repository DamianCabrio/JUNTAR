<?php

namespace backend\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Rol extends ActiveRecord
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
     * @return PermisoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PermisoQuery(get_called_class());
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
            'name' => 'Rol',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Children]].
     *
     * @return ActiveQuery|PermisoQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Permiso::className(), ['name' => 'child'])->viaTable('permiso_rol', ['parent' => 'name']);
    }

    /**
     * Gets query for [[Parents]].
     *
     * @return ActiveQuery|PermisoQuery
     */
    public function getParents()
    {
        return $this->hasMany(Permiso::className(), ['name' => 'parent'])->viaTable('permiso_rol', ['child' => 'name']);
    }

    /**
     * Gets query for [[PermisoRols]].
     *
     * @return ActiveQuery|PermisoRolQuery
     */
    public function getPermisoRols()
    {
        return $this->hasMany(PermisoRol::className(), ['parent' => 'name']);
    }

    /**
     * Gets query for [[PermisoRols0]].
     *
     * @return ActiveQuery|PermisoRolQuery
     */
    public function getPermisoRols0()
    {
        return $this->hasMany(PermisoRol::className(), ['child' => 'name']);
    }

    /**
     * Gets query for [[RuleName]].
     *
     * @return ActiveQuery|ReglaQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(Regla::className(), ['name' => 'rule_name']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return ActiveQuery|UsuarioQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Usuario::className(), ['idUsuario' => 'user_id'])->viaTable('usuario_rol', ['item_name' => 'name']);
    }

    /**
     * Gets query for [[UsuarioRols]].
     *
     * @return ActiveQuery|UsuarioRolQuery
     */
    public function getUsuarioRols()
    {
        return $this->hasMany(UsuarioRol::className(), ['item_name' => 'name']);
    }
}
