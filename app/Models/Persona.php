<?php
namespace App\Models;
use Carbon\Carbon;

require_once ("BasicModel.php");

class Persona extends BasicModel
{
    //Propiedades
    protected int $id;
    protected string $nombres; //Nombres de Usuario
    protected string $apellidos; //Apellidos de las personas
    protected string $direccion; //lugar de vivienda o Local
    protected float $telefono; //Telefono personal
    protected string $correo;

    /**
     * Persona constructor.
     * @param int $id
     * @param string $nombres
     * @param string $apellidos
     * @param string $direccion
     * @param float $telefono
     * @param string $correo
     */

    //Constructor Persona
    public function __construct(int $id, string $nombres, string $apellidos, string $direccion, float $telefono, string $correo)
    {
        parent::__construct();
        $this->setId($arrPersona['id'] ?? 0);
        $this->setNombres($nombres);
        $this->setApellidos($apellidos);
        $this->setDireccion($direccion);
        $this->setTelefono($telefono);
        $this->setCorreo($correo);
    }

    //Destructor Persona
    public function __destruct()
    {
        // TODO: Implement __destruct() method.

    }




    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }



    /**
     * @return string
     */
    public function getNombres(): string
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;

    }

    /**
     * @return string
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return string
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return float
     */
    public function getTelefono(): float
    {
        return $this->telefono;
    }

    /**
     * @param float $telefono
     */
    public function setTelefono(float $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getCorreo(): string
    {
        return $this->correo;
    }

    /**
     * @param string $correo
     */
    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    } //Correo de contacto


    public function save() : Persona
    {
        $result = $this->insertRow("INSERT INTO plotter.persona VALUES (null, ?, ?, ?, ?, ?)", array(

                $this->getNombres(),
                $this->getApellidos(),
                $this->getDireccion(),
                $this->getTelefono(),
                $this->getCorreo()
        )
        );
        $this->Disconnect();
        return $this;
    }

    public function update()
    {
        $result = $this->updateRow("UPDATE plotter.persona SET nombres = ?, apellidos = ?, direccion = ?, telefono = ?, correo = ? WHERE id = ?", array(

                 $this->getNombres(),
                 $this->getApellidos(),
                 $this->getDireccion(),
                 $this->getTelefono(),
                 $this->getCorreo()
        )
        );
        $this->Disconnect();
        return $this;
    }


    protected static function search($query)
    {
        $arrPersona = array();
        $tmp = new Persona();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor){
        $Persona = new Persona();
        $Persona->setId($valor['id']);
        $Persona->setNombres($valor['nombres']);
        $Persona->setApellidos($valor['apellidos']);
        $Persona->setDireccion($valor['direccion']);
        $Persona->setTelefono($valor['telefono']);
        $Persona->setCorreo($valor['correo']);
        $Persona->Disconnect();
        array_push($arrPersona, $Persona);
        }
        $tmp->Disconnect();
        return $arrPersona;
    }

    public static function getAll()
    {
        return Persona::search("SELECT * FROM plotter.persona");
    }

    public static function searchForId($id)
    {
        $Persona = null;
        if ($id > 0){
        $Persona = new Persona();
        $getrow = $Persona->getRow("SELECT * FROM plotter.persona WHERE id =?", array($id));
            $Persona->setId($getrow['id']);
            $Persona->setNombres($getrow['nombres']);
            $Persona->setApellidos($getrow['apellidos']);
            $Persona->setDireccion($getrow['direccion']);
            $Persona->setTelefono($getrow['telefono']);
            $Persona->setCorreo($getrow['correo']);
            $Persona->Disconnect();
        }
        $Persona->Disconnect();
        return $Persona;

    }

    protected function create()
    {
        // TODO: Implement create() method.
    }



    protected function deleted($id)
    {
        {
            $result = $this->updateRow("UPDATE plotter.persona  WHERE id = ?");
            $this->Disconnect();
            return $this;
        }
    }
}