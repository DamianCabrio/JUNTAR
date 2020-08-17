<?php

namespace common\components;

use frontend\models\Inscripcion;

class funciones
{

    public static function getSlug($request)
    {
        return $request->get("slug");
    }

    public static function getEstaInscripto($idUsuario, $idEvento)
    {
        return Inscripcion::find()->where(["idUsuario" => $idUsuario, "idEvento" => $idEvento, "estado" => 1])->one();
    }

}

?>