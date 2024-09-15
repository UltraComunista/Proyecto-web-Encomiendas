<?php
class Conexion {

    static public function conectar() {
        $link = new PDO("mysql:host=localhost;dbname=dbshalom",
                        "rodrigo",
                        "12599229");

        $link->exec("set names utf8");

        return $link;
    }
}

?>

