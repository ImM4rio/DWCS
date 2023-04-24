<?php

ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);

require '../vendor/autoload.php';
$url="http://localhost/EX3aval/server/servidorSoap/servicio.wsdl";
try{
$server = new SoapServer($url);
$server->setClass('Clases\Operacions');
$server->handle();
} catch(SoapFault $f) {
die('erro en server: ' . $f->getMessage());
}
