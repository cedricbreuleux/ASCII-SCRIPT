<?php
function recupere_contenu($chemin){
    $html = file_get_contents($chemin);
    $contenu = explode("<", $html);

    foreach ($contenu as $key => $value) {
        if(!$value){
            unset($contenu[$key]);
        }
    }
    $contenu = array_values($contenu);
    return $contenu;
}
function divise_contenu($contenu, $max_caracteres){
    $tab1=[];
    $tab2=[];
    $tab3=[];
    $tab4=[];
    $tab5=[];
    $tab_finnal = [];

    foreach ($contenu as $key => $value) {
        $tab_tempo = str_split($contenu[$key], $length = $max_caracteres);
        foreach ($tab_tempo as $key2 => $value2) {
            if($key2 == 0){
                array_push($tab1, $value2);
            }else if($key2 == 1) {
                array_push($tab2, $value2);
            }
            else if($key2 == 2) {
                array_push($tab3, $value2);
            }else if($key2 == 3) {
                array_push($tab4, $value2);
            }else if($key2 == 4) {
                array_push($tab5, $value2);
            }
        }
    }
    array_push($tab_finnal, $tab1, $tab2);
    return $tab_finnal;
}
function writting($tab, $count, $ligne) {
    $fichier = fopen("../ImageFinnal/lion_ligne_".$ligne."_page_".$count.".html", 'w');
    fwrite($fichier, "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Document</title>
    </head>
    <body style='font-size: xx-small; line-height: 0%;'>
    <pre>");
    foreach ($tab as $key => $value) {
        fwrite($fichier, "<p>".$value."</p>");
    }
    fwrite($fichier, "</pre></body>
    </html>");
    echo "Page $count créée\n";
}
function Sdecoupe ($chemin, $ligne,$max_caracteres) {
    
    $contenu = recupere_contenu($chemin);


    
    $contenus = divise_contenu($contenu,$max_caracteres);


    $count = 0;
    foreach ($contenus as $key => $value) {
        $count++;
        writting($value, $count, $ligne);
    }
}