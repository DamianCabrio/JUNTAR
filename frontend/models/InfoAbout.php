<?php

namespace frontend\models;

use yii\base\Model;

/**
 * ImagenEvento is the model behind the ImagenQR.
 */
class InfoAbout extends Model {

    public function mensajeRandomCardPWA($nombre) {
        $mensajo = "";
        switch ($nombre) {
            case "Felipe Bastidas":
                $arrayMensojos = [
                    "Yii Modales tiene modales",
                    "Me dijeron que era único, pero nunca me validaron",
                    "Más allá del bien y del mal.",
                    "Smile while it's free :-)",
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
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                // JAJAJAJAJAJ adoro los mensajes de Felipe XDD       by: Kevin (?
                break;

            case "Norbert Strange":
                $arrayMensojos = [
                    "We aim above the mark to hit the mark.",
                    "Ich esse gern Brot mit warmem Käse.",
                    "私はビールを飲み、チップを食べるのが好きです。"
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            case "Laura Murillo":
                $arrayMensojos = [
                    "Este es el resultado de muchas noches de desvelo.",
                    "Este equipo es lo más. ",
                    "Programado 100% en modo remoto - casita.",
                    "¿Sabes todo el helado que necesité para hacer este proyecto?",
                    "Nunca dudes de un grupo de entusiastas.",
                    "¡Proyecto exitoso realizado en cuarentena!."
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            case "Damian Cabrio":
                $arrayMensojos = [
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
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            case "Leandro Casanova":
                $arrayMensojos = [
                    "Señor SSH Master. Infraestructura",
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            case "Emanuel Araya":
                $arrayMensojos = [
                    "Metimos cuchara en verEvento",
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            case "Maximiliano Bajamon":
                $arrayMensojos = [
                    "Metimos cuchara en verEvento",
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            case "Kevin Espinoza":
                $arrayMensojos = [
                    "omae wa mou shindeiru",
                    "Mira mamá!!! Aparezco en los créditos :D",
                    "¿En cuántos proyectos universitarios ves algo así de genial?",
                    "Me miraba 3 o 4 videos en YouTube antes de ponerme a programar (?",
                    "Si jugás al League of Legends, agregame: ''Mekuru'' (LAS)"
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            case "Marcos Benitez":
                $arrayMensojos = [
                    "Metimos cuchara en verEvento",
                    "Estoy pensando...",
                    "Lo voy hacer tranquilo",
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            case "Mauro Saracini":
                $arrayMensojos = [
                    "Metimos cuchara en verEvento",
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;
            case "Natalia Baeza":
                $arrayMensojos = [
                    "Profesora Cátedra PWA - 2020",
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            case "Valeria Zoratto":
                $arrayMensojos = [
                    "Profesora Cátedra PWA - 2020",
                ];
                $randomIndex = array_rand($arrayMensojos, 1);
                $mensajo = $arrayMensojos[$randomIndex];
                break;

            default:
                //algun chiste
                break;
        }
        return $mensajo;
    }

    private function estiloContenido() {
        $contenido = [
            'tabla',
            'enlace',
            'texto',
            'boton',
            'broma',
        ];
        $randomIndex = array_rand($contenido, 1);

        return $contenido[$randomIndex];
    }

}
