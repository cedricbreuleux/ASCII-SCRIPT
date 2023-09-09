<?php
// Chemin vers l'image d'origine
$cheminImage = './Souvenir.jpg';

// Charger l'image
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

imagejpeg($image,"souvenir2.jpg",90);
?>