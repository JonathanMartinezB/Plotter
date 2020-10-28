<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php'); //Requerido para convertir un objeto en Array
require_once(__DIR__ . '/../Models/Persona.php');
require_once(__DIR__ . '/../Models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\Persona;

if (!empty($_GET['action'])) { //PersonaController.php?action=create
    PersonaController::main($_GET['action']);
}

class PersonaController
{

    static function main($action)
    {
        if ($action == "create") {
            PersonaController::create();
        } else if ($action == "edit") {
            PersonaController::edit();
        } else if ($action == "searchForID") {
            PersonaController::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            PersonaController::getAll();
        }  else if ($action == "changeStatus") {
            PersonaController::changeStatus();
        }
    }

    static public function create()
    {
        try {

            $arrayPersona = array();
            $arrayPersona['nombres'] = $_POST['nombres'];
            $arrayPersona['apellidos'] = $_POST['apellidos'];
            $arrayPersona['direccion'] = $_POST['direccion'];
            $arrayPersona['telefono'] = $_POST['telefono'];
            $arrayPersona['correo'] = $_POST['correo'];


            //$arrayPersona['cajaAutomatica'] = (!empty($_POST['cajaAutomatica']) && $_POST['cajaAutomatica'] == 'on') ? "si" : "no";
            //$arrayPersona['cantidadGasolina'] = $_POST['cantidadGasolina'];


            if (!Persona::PersonaRegistrado($arrayPersona['nombre'], $arrayPersona['apellido'])) {
                $Persona = new Persona($arrayPersona);
                if ($Persona->save()) {
                    //var_dump($Persona);
                    header("Location: ../../views/modules/persona/index.php?action=create&respuesta=correcto");
                }
            } else {
                // echo "persona ya registrado";
                header("Location: ../../views/modules/persona/create.php?respuesta=error&mensaje=Persona ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/persona/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {
            $arrayPersona = array();
            $arrayPersona['nombres'] = $_POST['nombres'];
            $arrayPersona['apellidos'] = $_POST['apellidos'];
            $arrayPersona['direccion'] = $_POST['direccion'];
            $arrayPersona['telefono'] = $_POST['telefono'];
            $arrayPersona['correo'] = $_POST['correo'];
            $arrayPersona['id'] = $_POST['id'];

            //$arrayPersona['cajaAutomatica'] = (!empty($_POST['cajaAutomatica']) && $_POST['cajaAutomatica'] == 'on') ? "si" : "no";persona
            //$arrayPersona['cantidadGasolina'] = $_POST['cantidadGasolina'];


            $persona = new Persona($arrayPersona);
            $persona->update();

            header("Location: ../../views/modules/persona/index.php?id=" . $persona->getId() . "&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/persona/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function searchForID($id)
    {
        try {
            return Persona::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            //header("Location: ../../views/modules/persona/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return Persona::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'log', 'errorStack');
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

}