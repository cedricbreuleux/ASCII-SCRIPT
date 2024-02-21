<?php
require 'CloseNumber.php';
require 'Class.php';
require 'reshade.php';

$jpegImageColor=new JPEGImageColor();

$image_load = reshade($cheminImage);
$name_result = $argv[2];
$info_image = getimagesize($image_load);
$longueur=$info_image[0];
$largeur=$info_image[1];

if($longueur && $largeur && $name_result && $image_load) {

    $jpegImageColor->load($image_load);
    // recupere les nuances de gris et les stocks
    function get_shade($longueur, $largeur, $jpegImageColor){
        $tab = [];
        for ($x=0; $x < $longueur ; $x++) { 
            for ($y=0; $y < $largeur; $y++) { 
                $RGB=$jpegImageColor->pixelAt($x, $y);
                if(count($tab) == 0) {
                    array_push($tab, $RGB);
                }
                $count1 = true;
                for ($i=0; $i < count($tab) ; $i++) { 
                    if ($tab[$i]['red'] == $RGB['red'] || $tab[$i]['red'] < $RGB['red']+20 && $tab[$i]['red'] > $RGB['red']-20 )
                    {
                        $count1 = false;
                    }
                }
                if($count1) {
                    array_push($tab, $RGB);
                }
                else {
                    $count1 = true;
                }
            }
        }
        return $tab;
    }
    $tab = get_shade($longueur, $largeur, $jpegImageColor);

    // fais un trie et recupere juste les valeurs qui nous interesse
    function trie($tab){
        $tab2 = [];
        foreach ($tab as $key => $value) {
            array_push($tab2, $value['red']);
        }
        sort($tab2);
        return $tab2;
    }
    $tab2 = trie($tab);
    // tableau de caractere
    $caract = array(
        11 =>  " ",
        10 =>  " ",
        9 =>   " ",
        8 =>   " ",
        7 =>   ".",
        6 =>   ":",
        5 =>   "i",
        4 =>   "z",
        3 =>   "x",
        2 =>   "X",
        1 =>   "@",
        0 =>   "b",
    );


    // creer une matrice
    function create_matrice($largeur, $hauteur){


        // Matrice représentant l'image
        $image = array();

        // Initialiser la matrice avec des espaces (pixels vides)
        for ($y = 0; $y < $hauteur; $y++) {
            for ($x = 0; $x < $largeur; $x++) {
                $image[$y][$x] = ' ';
            }
        }
        return $image;
    }
    $matrice = create_matrice($longueur, $largeur);


    // modifie les pixel de la matrice
    function feed_matrice($matrice, $jpegImageColor, $longueur, $largeur, $tab, $caract, $tab2) {
        for ($x=0; $x < $longueur ; $x++) { 
            // horizontal
            for ($y=0; $y < $largeur; $y++) { 
            // vertical
                $RGB=$jpegImageColor->pixelAt($x, $y);

                $count1 = true;
                for ($i=0; $i < count($tab) ; $i++) { 
                    if ($tab[$i]['red'] == $RGB['red'] || $tab[$i]['red'] < $RGB['red']+20 && $tab[$i]['red'] > $RGB['red']-20 )
                    {
                        // recupere la valeur qui ce rapproche le plus du tableau $tab2
                        $key = get_the_closest_number($RGB['red'], $tab2);
                        // changer le pixel avec cette couleur
                        $matrice[$x][$y] = $caract[$key];
                    }
                }
            }
        }
        return $matrice;
    }
    $matrice = feed_matrice($matrice, $jpegImageColor, $longueur, $largeur, $tab, $caract, $tab2);

    $jpegImageColor->close();


    // creer le rendu
    function create_result($matrice, $cheminFichier, $longueur, $largeur, $jpegImageColor, $cheminImage) {
        $fichier = fopen("../ImageFinnal/".$cheminFichier, 'w');
        $image = imagecreatefromjpeg($cheminImage);

        fwrite($fichier, "<!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Document</title>
            <link rel='stylesheet' href='style.css'>
        </head>
        <body style=\"line-height: 0;
        font-size: 4px;
        letter-spacing: 0.1rem;\">
            <pre>");
        // Boucle pour générer le contenu
        for ($x = 0; $x < $largeur; $x++) {
            fwrite($fichier, "<p>");
            for ($y = 0; $y < $longueur; $y++) {

                $pixel = imagecolorat($image, $y, $x);
                $rouge = ($pixel >> 16) & 0xFF;
                $vert = ($pixel >> 8) & 0xFF;
                $bleu = $pixel & 0xFF;

                $contenu = "<span style=\"color: rgb(".$rouge.", ".$vert.", ".$bleu.");\">". $matrice[$y][$x]."</span>";
                fwrite($fichier, $contenu);
            }
            fwrite($fichier, "</p>");
        }
        fwrite($fichier, "</pre>
        </body>
        </html>");
        fclose($fichier);
    }
    echo $cheminImage;
    create_result($matrice, $name_result.".html", $longueur, $largeur, $jpegImageColor, $cheminImage);
    echo "Resultat créé\n";

    $command = "wkhtmltopdf ".$name_result.".html ".$name_result.".pdf";
    $output = shell_exec($command);
}
else {
    echo "Argument(s) manquant ou erroné \n";
    echo "arg1: chemin image: string \n";
    echo "arg2: Nom fichier resultat: string \n";
}

?>