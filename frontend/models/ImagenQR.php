<?php

namespace frontend\models;

use Da\QrCode\QrCode;
use yii\base\Model;
use yii\helpers\Url;
use Yii;

/**
 * ImagenEvento is the model behind the ImagenQR.
 */
class ImagenQR extends Model {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['']
        ];
    }

    public function generarQREvento($slug, $idEvento) {
        $label = ($slug);

        $qrCode = (new QrCode((Url::base(true) . Url::to(['/eventos/ver-evento']) . "/" . $slug)))
                ->useLogo("../web/images/juntar-logo/png/juntar-avatar-bg-b.png")
                ->useEncoding('UTF-8')
                ->setLogoWidth(45)
                ->setSize(400)
                ->setMargin(5)
                ->setLabel($label);

//        $qrCode->writeFile('../web/eventos/images/qrcodes/' . $slug . '.png');
        $path = 'eventos/images/qrcodes/' . $slug . '.png';
        $insercion = $qrCode->writeFile('../web/' . $path);
        if ($insercion) {
            $model = new ImagenEvento();
            return $model->guardarImagen($path, 3, $idEvento);
        } else {
            return false;
        }
    }

    public function updateQREvento($slug, $idEvento) {
        $modelImage = ImagenEvento::findOne(['idEvento' => $idEvento, 'categoriaImagen' => 3]);
        $rutaQREvento = $modelImage->rutaArchivoImagen;
        if (file_exists($rutaQREvento)) {
            //elimina el archivo de la carpeta
            unlink($rutaQREvento);
        }

        //generamos el nuevo QR
        $label = ($slug);
        $qrCode = (new QrCode((Url::base(true) . Url::to(['/eventos/ver-evento']) . "/" . $slug)))
                ->useLogo("../web/images/juntar-logo/png/juntar-avatar-bg-b.png")
                ->useEncoding('UTF-8')
                ->setLogoWidth(45)
                ->setSize(400)
                ->setMargin(5)
                ->setLabel($label);

        $path = 'eventos/images/qrcodes/' . $slug . '.png';
        $insercion = $qrCode->writeFile('../web/' . $path);
        if ($insercion) {
            return $modelImage->updateImagen($path);
        } else {
            return false;
        }
    }

    public function generarQRAcreditacion($codigoAcreditacion, $slug, $idEvento) {
        $label = ($slug);

        $qrCode = (new QrCode((Url::base(true) . Url::to(['/acreditacion']) . '?slug=' . $slug . '&codigoAcreditacion=' . $codigoAcreditacion)))
                ->useLogo("../web/images/juntar-logo/png/juntar-avatar-bg-b.png")
                ->useEncoding('UTF-8')
                ->setLogoWidth(45)
                ->setSize(400)
                ->setMargin(5)
                ->setLabel($label);

        $path = "eventos/images/qrcodes/" . Yii::$app->security->generateRandomString() . "-Acreditacion.png";
        $insercion = $qrCode->writeFile('../web/' . $path);
        if ($insercion) {
            $model = new ImagenEvento();
            return $model->guardarImagen($path, 4, $idEvento);
        } else {
            return false;
        }
    }
    
    public function updateQRAcreditacion($codigoAcreditacion, $slug, $idEvento) {
        $modelImage = ImagenEvento::findOne(['idEvento' => $idEvento, 'categoriaImagen' => 4]);
        $rutaQREvento = $modelImage->rutaArchivoImagen;
        if (file_exists($rutaQREvento)) {
            //elimina el archivo de la carpeta
            unlink($rutaQREvento);
        }
        
        $label = ($slug);
        $qrCode = (new QrCode((Url::base(true) . Url::to(['/acreditacion']) . '?slug=' . $slug . '&codigoAcreditacion=' . $codigoAcreditacion)))
                ->useLogo("../web/images/juntar-logo/png/juntar-avatar-bg-b.png")
                ->useEncoding('UTF-8')
                ->setLogoWidth(45)
                ->setSize(400)
                ->setMargin(5)
                ->setLabel($label);

        $path = "eventos/images/qrcodes/" . Yii::$app->security->generateRandomString() . "-Acreditacion.png";
        $insercion = $qrCode->writeFile('../web/' . $path);
        if ($insercion) {
            return $modelImage->updateImagen($path);
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
//    public function attributeLabels() {
//        return [
//        ];
//    }
}
