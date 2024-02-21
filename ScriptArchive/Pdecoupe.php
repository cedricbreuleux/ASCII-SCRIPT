<?php
require "./Sdecoupe.php";
function premiere_decoute($contenu, $max_ligne_vertical, $max_caracteres){
    $pages = array_chunk($contenu, $max_ligne_vertical,$preserve_keys = false);
    for ($i=0; $i < count($pages) ; $i++) { 
        foreach ($pages[$i] as $key => $value) {
            if(!$value) {
                unset($pages[$i][$key]);
                $pages[$i] = array_values($pages[$i]);
            }
        }
    }
    $count = 1;
    $contenus ="";
    $ligne = 0;

    foreach ($pages as $key => $value) {
        $fichier = fopen("../Imprimerie/page".$count.".html", 'w');
        foreach ($value as $key2 => $value2) {
            $contenus .= "<".$value2."\n";
        }
        fwrite($fichier, $contenus);
        $contenus="";
        $count+=1;
        $ligne++;
        Sdecoupe ("../Imprimerie/page".($count-1).".html", $ligne, $max_caracteres);
    }
    echo "Premiere decoupe fait.";
}
function Pdecoute($chemin, $max_ligne_vertical, $max_caracteres) {
    $html = file_get_contents($chemin);
    $contenu = explode("<", $html);
    $nombre_de_ligne = count($contenu);
    $nombres_de_caractere_par_ligne = strlen($contenu[1]);
    $nombres_de_page_largeur = ceil($nombres_de_caractere_par_ligne/360);
    $nombres_de_page_hauteur = ceil($nombre_de_ligne/106);
    $nombre_de_page_total = $nombres_de_page_hauteur*$nombres_de_page_largeur;


    premiere_decoute($contenu, $max_ligne_vertical, $max_caracteres);


    $tab = array (
        0 => "1234",
        1 => "5678",
        2 => "9abc",
        3 => "defg",
    );
    $tab1 = []; $tab2 = [];
    $tab3 = []; $tab4 = [];
    $tab5 = []; $tab6 = [];
    $tab7 = []; $tab8 = [];


    $limite = 2;
}
