<?php

namespace App\DAO;

use PDO;
use App\Modelo\Usuario;

class UsuarioDAO {

    private $bd;

    function __construct($bd) {
        $this->bd = $bd;
    }

    function crea(Usuario $usuario) {
        
    }

    function modifica(Usuario $usuario) {
        
    }

    function elimina(string $nombre) {
        
    }
    
     /**
     * Recupera un objeto usuario dado su nombre de usuario y clave
     * 
     * @param string $nombre Nombre de usuario
     * @param string $pwd Clave del usuario
     * 
     * @returns Usuario que corresponde a ese nombre y clave o null en caso contrario
     */

    function recuperaPorCredencial(string $nombre, string $pwd): Usuario {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = 'select * from usuarios where nombre=:nombre and clave=:pwd';
        $sth = $this->bd->prepare($sql);
        $sth->execute([":nombre" => $nombre, ":pwd" => $pwd]);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Usuario::class);
        $usuario = ($sth->fetch()) ?: null;
        return $usuario;
    }

}
