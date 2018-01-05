<?php
//Lista de instalaciones y archivo a cargar en su caso.
$servidores= [
  //--'Nombre_PC_de_trabajo' => 'alias_de_fichero'
  'tomy_port' => 'tomas',
];
$uname= php_uname('n'); $config_file= false;
foreach( $servidores as $server_id => $config_id) {
  if (stripos( $uname, $server_id) !== false) {
    $config_file= __DIR__.DIRECTORY_SEPARATOR.'db_'.$config_id.'.php'; 
    //$config_file= 'db_'.$config_id.'.php'; 
    break;
  }//if
}//foreach

//Asegurar que los archivos que se creen son utilizables por apache, etc...
umask(0);
//Establecer el TimeZone para los servidores que no lo tienen configurado.
date_default_timezone_set( 'Europe/Madrid');

if (($config_file !== false) && is_readable($config_file)) {
  //Devolver la configuracion del fichero localizado.
//print_r('CONFIGURACION LOCALIZADA - '); print_r($config_file); phpinfo(); exit(0);
  return require_once( $config_file);
} else {
  //Devolver la configuracion por defecto de desarrollo.
//print_r('CONFIGURACION DEFECTO - '); print_r($config_file); phpinfo(); exit(0);
  return require_once( __DIR__.DIRECTORY_SEPARATOR.'db_defecto.php');
}//if

