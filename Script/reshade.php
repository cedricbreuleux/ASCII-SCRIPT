<?php
// Chemin vers l'image d'origine
$cheminImage = $argv[1];

// Charger l'image
if($cheminImage) {
    function reshade($cheminImage) {
        $image = imagecreatefromjpeg($cheminImage);

        // Obtenir les dimensions de l'image
        $largeur = imagesx($image);
        $hauteur = imagesy($image);

        // Parcourir chaque pixel de l'image et le convertir en noir et blanc
        for ($x = 0; $x < $largeur; $x++) {
            for ($y = 0; $y < $hauteur; $y++) {
                $pixel = imagecolorat($image, $x, $y);
                $rouge = ($pixel >> 16) & 0xFF;
                $vert = ($pixel >> 8) & 0xFF;
                $bleu = $pixel & 0xFF;
                $gris = round(($rouge + $vert + $bleu) / 3);
                $couleurGris = imagecolorallocate($image, $gris, $gris, $gris);
                imagesetpixel($image, $x, $y, $couleurGris);
            }
        }

        imagejpeg($image, "../ImagesGris/".explode("/",$cheminImage)[2],90);
        echo "Image reshade\n";
        return "../ImagesGris/".explode("/",$cheminImage)[2];
    }
}
?>