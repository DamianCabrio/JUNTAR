<?php

namespace frontend\models;

use yii\base\Model;

/**
 * ImagenEvento is the model behind the ImagenQR.
 */
class InfoAbout extends Model {

    public function mensajeRandomAlumnosPWA($nombreAlumno) {
        $mensajo = "";
        $arrayMensajos = [];
        switch ($nombreAlumno) {
            case "Felipe Bastidas":
                $arrayMensajos = [
                    "Yii Modales tiene modales",
                    "Me dijeron que era único, pero nunca me validaron",
                    "Más allá del bien y del mal.",
                    "Smile while it's free (:",
                    "Si no funcionó con un foreach, puede que funcione con dos",
                    "Fixer nocturno",
                    "Me llama usted, entonces voy. Don Yii Modales es quien yo soy",
                    "O sea sí. Pero no.",
                    "Tienes que hacerlo por mi Pipo, por Yii Modales",
                    "Cuatro lineas más y termino el código..",
                    "OIGA! Estoy tratando de terminar mi código espaguetti.",
//            "100% real no fake, 1 link juntar",
//            "Si los leés, te entretenés xD",
                ];
// JAJAJAJAJAJ adoro los mensajes de Felipe XDD       by: Kevin (?
                break;

            case "Norbert Strange":
                $arrayMensajos = [
                    "We aim above the mark to hit the mark.",
                    "Ich esse gern Brot mit warmem Käse.",
                    "私はビールを飲み、チップを食べるのが好きです。"
                ];
                break;

            case "Laura Murillo":
                $arrayMensajos = [
                    "Este es el resultado de muchas noches de desvelo.",
                    "Este equipo es lo más. ",
                    "Programado 100% en modo remoto - casita.",
                    "¿Sabes todo el helado que necesité para hacer este proyecto?",
                    "Nunca dudes de un grupo de entusiastas.",
                    "¡Proyecto exitoso realizado en cuarentena!."
                ];
                break;

            case "Damian Cabrio":
                $arrayMensajos = [
                    "Si encuentran algún error, yo no fui..",
                    "你在浪费你的时间来翻译这个",
                    "Pase días haciendo los formularios dinámicos, espero que les gusten.",
                    "Si estás leyendo esto, espero que tengas un lindo día.",
                    "Si nosotros pudimos, todos pueden.",
                    "La persona de al lado tiene olor a pata",
                    "Campeón mundial de borrar archivos en los commits",
                    "No busquen mensajes secretos, porque no los van a encontrar...",
                    "Hola persona del futuro, ¿Cómo te va?",
                    "Fire, Walk with me",
                    "Nos esforzamos mucho en hacer la página, no la rompan por favor",
                    "Rompe paga",
                    "Era penal"
                ];
                break;

            case "Leandro Casanova":
                $arrayMensajos = [
                    "Señor SSH Master. Infraestructura",
                ];
                break;

            case "Emanuel Araya":
                $arrayMensajos = [
                    "Metimos cuchara en verEvento",
                ];
                break;

            case "Maximiliano Bajamon":
                $arrayMensajos = [
                    "Metimos cuchara en verEvento",
                ];
                break;

            case "Kevin Espinoza":
                $arrayMensajos = [
                    "omae wa mou shindeiru",
                    "Mira mamá!!! Aparezco en los créditos :D",
                    "¿En cuántos proyectos universitarios ves algo así de genial?",
                    "Me miraba 3 o 4 videos en YouTube antes de ponerme a programar (?",
                    "Si jugás al League of Legends, agregame: ''Mekuru'' (LAS)"
                ];
                break;

            case "Marcos Benitez":
                $arrayMensajos = [
                    "Metimos cuchara en verEvento",
                    "Estoy pensando...",
                    "Lo voy hacer tranquilo",
                ];
                break;

            case "Mauro Saracini":
                $arrayMensajos = [
                    "Metimos cuchara en verEvento",
                ];
                break;
            default:
//algun chiste
                break;
        }
        $randomIndex = array_rand($arrayMensajos, 1);
        $mensajo = $arrayMensajos[$randomIndex];

        return $mensajo;
    }

    public function mensajeRandomCatedraPWA($nombre) {
        $mensajo = "";
        $arrayMensajos = [];
        switch ($nombre) {
            case "Natalia Baeza":
                $arrayMensajos = [
                    "Profesora Cátedra PWA - 2020",
                ];
                break;
            case "Valeria Zoratto":
                $arrayMensajos = [
                    "Profesora Cátedra PWA - 2020",
                    "El segundo va después del primero"
                ];
                break;

            case "Pablo Kogan":
                $arrayMensajos = [
                    "Product Owner de Juntar",
                    "Secretario de Extensión de la Facultad de Informática"
                ];
                break;

            case "Luis Coralle":
                $arrayMensajos = [
                    "TIC de la Facultad de Informática",
                    "Infraestructura de Juntar",
                ];
                break;
            default:
//algun chiste
                break;
        }
        $randomIndex = array_rand($arrayMensajos, 1);
        $mensajo = $arrayMensajos[$randomIndex];

        return $mensajo;
    }

    public function arregloContactoDesarrollador($nombre) {
        switch ($nombre) {
            case "Felipe Bastidas":
                $arrayContacto = [
                    'image' => 'images/devs/felipe.png',
                    'email' => 'Fbastidas_94@hotmail.com',
                ];
                break;

            case "Norbert Strange":
                $arrayContacto = [
                    'image' => 'images/devs/norbert.jpg',
                    'email' => 'norbert@stange.com.ar',
                    'instagram' => 'https://www.instagram.com/n0rb3rt/',
                    'lastfm' => 'https://www.last.fm/user/N0rb3r7',
                ];
                break;

            case "Laura Murillo":
                $arrayContacto = [
                    'image' => 'images/devs/laura.png',
                    'email' => 'lauradejaramillo@gmail.com',
                ];
                break;

            case "Damian Cabrio":
                $arrayContacto = [
                    'image' => 'images/devs/damian.png',
                    'email' => 'damian.cabrio@est.fi.uncoma.edu.ar',
                ];
                break;

            case "Leandro Casanova":
                $arrayContacto = [
                    'image' => 'images/devs/leandro.png',
                    'email' => 'leandro.casanova@est.fi.uncoma.edu.ar',
                ];
                break;

            case "Emanuel Araya":
                $arrayContacto = [
                    'image' => 'images/devs/emanuel.png',
                    'email' => 'emanuel.araya@est.fi.uncoma.edu.ar',
                ];
                break;

            case "Maximiliano Bajamon":
                $arrayContacto = [
                    'image' => 'images/devs/maximiliano.png',
                    'email' => 'maximiliano.bajamon@est.fi.uncoma.edu.ar',
                ];
                break;

            case "Kevin Espinoza":
                $arrayContacto = [
                    'image' => 'images/devs/kevin.png',
                    'email' => 'kevin.espinoza@est.fi.uncoma.edu.ar',
                ];
                break;

            case "Marcos Benitez":
                $arrayContacto = [
                    'image' => 'images/devs/marcos.png',
                    'email' => 'marcos.benitez@est.fi.uncoma.edu.ar',
                ];
                break;

            case "Mauro Saracini":
                $arrayContacto = [
                    'image' => 'images/devs/mauro.png',
                    'email' => 'mauro.saracini@est.fi.uncoma.edu.ar',
                ];
                break;

            case "Natalia Baeza":
                $arrayContacto = [
                    'image' => 'images/devs/natibaeza.png',
                    'email' => 'natalia.baeza@fi.uncoma.edu.ar',
                ];
                break;

            case "Valeria Zoratto":
                $arrayContacto = [
                    'image' => 'images/devs/valezoratto.png',
                    'email' => 'vzoratto@fi.uncoma.edu.ar',
                ];
                break;

            case "Pablo Kogan":
                $arrayContacto = [
                    'image' => 'images/devs/pablokogan.png',
                    'email' => 'pablo.kogan@fi.uncoma.edu.ar',
                ];
                break;

            case "Luis Coralle":
                $arrayContacto = [
                    'image' => 'images/devs/lusho.png',
                    'email' => 'luiscoralle@fi.uncoma.edu.ar',
                ];
                break;

            default:
                $arrayContacto = '<div class="row">' .
                        '<div class="col-12">' .
                        '<p class="text-center text-white"> <strong> ¿Otro error? <strong> </p>' .
                        '<div class="d-flex justify-content-center"> <audio controls controlsList="nodownload">' .
                        '<source src="../audio/pero-que-a-pasao.mp3" type="audio/mpeg">' .
                        'Your browser does not support the audio element.' .
                        '</audio>' .
                        '</div>' .
                        '</div>';
                '</div>';
                break;
        }
        return $arrayContacto;
    }

}
