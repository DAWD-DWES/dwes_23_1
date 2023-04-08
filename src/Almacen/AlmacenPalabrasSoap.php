<?php

namespace App\Almacen;

use \SoapClient;
use \SoapFault;

class AlmacenPalabrasSoap implements AlmacenPalabrasInterface {

    private $clienteSoap;

    const URL = 'http://localhost/serviciopalabras/servicio.wsdl';

    public function __construct() {
        $this->cliente = new SoapClient(self::URL, ['trace' => true]);
    }

    public function obtenerPalabraAleatoria(): string {
        $palabra = $this->cliente->getPalabraAleatoria();
        return $palabra;
    }

}
