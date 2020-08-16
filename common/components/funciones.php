<?php
namespace common\components;

class funciones
{

    public static function getSlug($request){
        return $request->get("slug");
    }

    public static function getEstaInscripto($idUsuario, $idEvento){
        return Inscripcion::find()->where(["idUsuario" => $idUsuario, $idEvento, "estado" => 1])->one();
    }

}

?>