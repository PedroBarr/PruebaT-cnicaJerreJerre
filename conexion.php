<?php
function get_conexion( ) {
  $conexion_host = "127.0.0.1";
  $conexion_usuario = "root";
  $conexion_clave = "";
  $conexion_nombre = "GEMASAS_Prueba";
  $conexion_port = 3307;
  $conexion_db = new mysqli(
      $conexion_host,
      $conexion_usuario,
      $conexion_clave,
      $conexion_nombre,
      $conexion_port
    );
  return $conexion_db;
}
?>