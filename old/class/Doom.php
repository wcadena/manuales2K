<?php

class datos {

    public $adatos;
    private $fichero;

    public function __construct($fichero_xml) {
        $this->fichero = $fichero_xml;
        $this->adatos = $this->getDatos();
		//echo '1: '.$fichero_xml;
    }
	
	function setUsuarion($usuario, $clave) {
		$this->setUsuario($usuario, $clave, 'user');
	}
    function setUsuario($usuario, $clave, $permiso) {
        $arr = $this->getDatos();
		echo '<pre>00000';
            print_r($arr);
            echo '00000</pre>';
        $arr[] = array('Correo' => $usuario, 'clave' => $clave, 'tipo' => $permiso);
		echo '<pre>11111';
            print_r($arr);
            echo '111111</pre>';
        $this->setDatos($this->fichero, json_encode($arr));
    }

    function getDatos() {
	//echo $this->fichero;
	$Datoos2sw3=array();
	    $file = fopen($this->fichero, "r") or exit("Unable to open file!");;
        //Output a line of the file until the end is reached 
        while (!feof($file)) {
            $Datoos2sw3=json_decode($datoss=fgets($file));
            echo '<pre>';
            print_r($Datoos2sw3);
            echo '</pre>////////'.$datoss;
        }
		
		return $Datoos2sw3;
    }

    function porDefecto() {
        $arr = array();
        $arr[] = array('Correo' => 'wcadena', 'clave' => 'wcadena', 'tipo' => 'admin',);
        $arr[] = array('Correo' => 'user', 'clave' => 'user', 'tipo' => 'user',);
        $arr[] = array('Correo' => 'user1', 'clave' => 'user1', 'tipo' => 'user',);
        $page = json_encode($arr);
		echo $page;
        $this->setDatos($this->fichero, $page);
    }

    function setDatos( $jsonfile) {
	echo $this->fichero;
        //$page="algo de texto";
        $fd = fopen($this->fichero, "w");
        fwrite($fd, $jsonfile);
        fclose($fd);
        //echo __FILE__;
    }

}

?>

