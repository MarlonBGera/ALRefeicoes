<?php
define( 'host', 'localhost' );
define( 'user', 'root' );
define( 'senha', 'root' );
define( 'dbname', 'alrefeicoes' );
date_default_timezone_set("America/Sao_Paulo");
try{
    $PDO = new PDO( 'mysql:host=' . host . ';dbname=' . dbname, user, senha);
}catch ( PDOException $e ){
    echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
}
?>