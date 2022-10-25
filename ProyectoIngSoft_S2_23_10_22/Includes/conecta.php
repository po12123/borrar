<?php
$servidor = "sql10.freesqldatabase.com:3306";
$usuario = "sql10529152";
$password = "L93ygJjdQY";
$bd = "sql10529152";

$conecta = mysqli_connect($servidor, $usuario,$password,$bd);
if($conecta->connect_error){
  die("Error al conectar la base de datos de la pagina".$conecta->connect_error);
}
