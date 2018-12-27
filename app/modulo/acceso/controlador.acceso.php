<?php
class acceso extends App{

    public function index(){

        if(isset($_SESSION["usuario"])){
            $this->vista->reenviar("index", "portada");
        }
        if(isset($_POST["usuario"]) and $_POST["usuario"]!="" and isset($_POST["clave"]) and $_POST["clave"]!=""){
            $modelo = new modeloAcceso();
            $usuario = $modelo->getSesion($_POST["usuario"], $_POST["clave"]);
            if(!empty($usuario)){
                $_SESSION["usuario"] = $usuario;
                $this->vista->reenviar("index", "portada");
            }else{
                $this->vista->MensajeAlerta("Usuario no válido.","error");
            }
        }
    }

    public function cerrar(){
        unset($_SESSION);
        session_destroy();
        $this->vista->reenviar("index");
    }



}
