<?php
class JPEGImageColor {
 
    private $img;
 
    /*
     * Charger une nouvelle image JPEG
     */
    public function load($filename) {
        $this->img=imagecreatefromjpeg($filename);
    }
 
    /*
     * Enregistrer l'image au format JPEG
     */
    public function save($filename) {
        imagejpeg($this->img,$filename,90);
    }
 
    /*
     * Libérer l'image
     */
    public function close() {
        imagedestroy($this->img);
    }
 
    /*
     * Lire la couleur d'un pixel
     */
    public function pixelAt($x,$y) {
        //Retourner l'index de la couleur sous forme d'un entier
        $ix = imagecolorat($this->img, $x, $y);
        //Décomposer l'index de la couleur en RGB
        return imagecolorsforindex($this->img, $ix);
    }
 
    /*
     * Fixer la couleur d'un pixel
     */
    public function setPixel($x,$y,$R, $G, $B) {
        //Retourner l'index de la couleur RGB 
        $col = imagecolorresolve($this->img, $R, $G, $B);
        imagesetpixel($this->img, $x, $y, $col);
    }
}