<?php

namespace App\Modelo;

use App\Almacen\AlmacenPalabrasInterface;

/**
 * Hangman representa una partida del juego del ahorcado
 */
class Hangman {

    /**
     * Id de la partida de ahorcado
     */
    private int $id;

    /**
     * Número de errores cometidos en la partida
     */
    private int $numErrores;

    /**
     * Palabra secreta usada en la partida
     */
    private string $palabraSecreta;

    /**
     * Estado de la palabra según va siendo descubierta. Por ejemplo c_c_e
     */
    private string $palabraDescubierta;

    /**
     * Lista de jugadas que ha realizado el jugador en la partida
     */
    private string $letras;

    /**
     * Número de errores permitido en la partida
     */
    private int $maxNumErrores;

    /**
     * Constructor de la clase Hangman
     * 
     * @param AlmacenPalabrasInterface $almacen Almacen de donde obtener palabras para el juego
     * @param int $maxNumErrores Número maximo de errores
     * 
     * @returns Hangman
     */
    public function __construct(AlmacenPalabrasInterface $almacen, int $maxNumErrores) {
        $this->setPalabraSecreta(strtoupper($almacen->obtenerPalabraAleatoria()));
        // Inicializa la estado de la palabra descubierta a una secuencia de guiones, uno por letra de la palabra oculta
        $this->setPalabraDescubierta(preg_replace('/\w+?/', '_', $this->getPalabraSecreta()));
        $this->setLetras("");
        $this->setNumErrores(0);
        $this->setMaxNumErrores($maxNumErrores);
    }

    public function getId(): ?int {
        return ($this->id) ?? null;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getPalabraSecreta(): string {
        return $this->palabraSecreta;
    }

    public function setPalabraSecreta(string $palabra): void {
        $this->palabraSecreta = $palabra;
    }

    public function getPalabraDescubierta(): string {
        return $this->palabraDescubierta;
    }

    public function setPalabraDescubierta(string $palabra): void {
        $this->palabraDescubierta = $palabra;
    }

    public function getLetras(): string {
        return $this->letras;
    }

    public function setLetras(string $letras): void {
        $this->letras = $letras;
    }

    public function getMaxNumErrores(): ?int {
        return $this->maxNumErrores;
    }

    public function setMaxNumErrores(int $maxNumErrores): void {
        $this->maxNumErrores = $maxNumErrores;
    }

    public function getNumErrores(): int {
        return $this->numErrores;
    }

    public function setNumErrores(int $numErrores): void {
        $this->numErrores = $numErrores;
    }

    /**
     * Comprueba la letra elegida por el jugador, modifica el estado de la palabra descubierta y añade la letra
     * 
     * @param string $letra Letra elegida por el jugador
     * 
     * @returns string El estado de la palabra descubierta
     */
    public function compruebaLetra(string $letra): string {
        $nuevaPalabraDescubierta = implode(array_map(function ($letraSecreta, $letraDescubierta) use ($letra) {
                    return ((strtoupper($letra) === $letraSecreta) ? $letraSecreta : $letraDescubierta);
                }, str_split($this->getPalabraSecreta()), str_split($this->getPalabraDescubierta())));
        if ($nuevaPalabraDescubierta == $this->getPalabraDescubierta()) {
            $this->numErrores++;
        } else {
            $this->setPalabraDescubierta($nuevaPalabraDescubierta);
        }
        $this->setLetras("{$this->getLetras()}$letra");
        return ($nuevaPalabraDescubierta);
    }

    /**
     * Comprueba si la palabra oculta el juego ya ha sido descubierta
     * 
     * @returns bool Verdadero si ya ha sido descubierta y falso en caso contrario
     */
    public function esPalabraDescubierta(): bool {
        // Si ya no hay guiones en la palabra descubierta
        return strstr($this->getPalabraDescubierta(), "_") === false;
    }

    /**
     * Comprueba si la partida se ha acabado
     * 
     * @returns bool Verdadero si ya se ha acabado y falso en caso contrario
     */
    public function esFin(): bool {
        return ($this->esPalabraDescubierta() || ($this->getNumErrores() === $this->getMaxNumErrores()));
    }

    /**
     * Devuelve la puntuación de la palabra.
     * 
     * Si la palabra no se acierta la puntuación es 0.
     * Si la palabra tiene entre 3 y 5 letras se suman 2 ptos en otro caso 1 pto
     * Se suma un punto por cada combinación de dos vocales seguidas de la palabra
     * Se suma un punto si se descubre en 3 o menos fallos
     * Se suma un punto si se avergua en menos de 1 minuto
     *  
     * @returns int Puntuación de la palabra
     */
    public function getPuntuacion(): int {
        $puntuacion = 0;
        if ($this->esPalabraDescubierta()) {
            $puntuacion = 1 + preg_match_all('/[AEIOU]{2,}/', $this->getPalabraSecreta())
                            + (strlen($this->getPalabraSecreta()) >= 3 && strlen($this->getPalabraSecreta()) <= 5)
                            + ($this->getNumErrores() <= 3);
        }
        return $puntuacion;
    }

}
