<?php

class Util {

    public $aDireccion = 'aMemberVar Member Variable';
    public $aFuncName = 'aMemberFunc';
    public $archivos = array();
    public $flagg;

    public function __construct($SESSION) {
        $this->archivos = $SESSION["listas"];
        $this->flagg = $SESSION["flagg"];
    }

    function aMemberFunc() {
        print 'Inside `aMemberFunc()`';
    }

    function descargaProtegida($archivo) {
        $filename = "dtos/" . $archivo;
        header("Expires: -1");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Content-type: application/zip;\n"); //or yours?
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0");
        header("Pragma: no-cache");
        $len = filesize($filename);
        //header("Content-Length: $len;\n");
        $outname = $archivo;
        header("Content-Disposition: attachment; filename=" . $outname . ";\n\n");
        readfile($filename);
    }

    /**
     * Downloader
     *
     * @param $archivo
     *  path al archivo
     * @param $downloadfilename
     *  (null|string) el nombre que queres usar para el archivo que se va a descargar.
     *  (si no lo especificas usa el nombre actual del archivo)
     *
     * @return file stream
     */
    function download_file($archivo, $downloadfilename = null) {

        if (file_exists($archivo)) {
            $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $downloadfilename);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($archivo));

            ob_clean();
            flush();
            readfile($archivo);
            exit;
        }
    }

    function extension($filename) {		
        return substr(strrchr($filename.'', '.'), 1);
    }

    public function SetArchivos($archivos) {
        $this->archivos = $archivos;
    }

    function listado_completo($ruta, $PROFUNDIDAD,$web='',$carpeta_master='%') {
		$datatottal34de="";
		$datatottal12as="";
        //$this->log_data(889466681233644489440, print_r($this->archivos, true), 'KlActiveDataLog2Z34.log');
        IF ($PROFUNDIDAD <= 0) {
            exit;
        }
// abrir un directorio y listarlo recursivo 
        if (is_dir($ruta)) {

            //echo "<ul>";
            if ($dh = opendir($ruta)) {
				$uniko=uniqid('accordion_');
				$datatottal12as.="<script>	$(function() {		$( \"#".$uniko."\" ).accordion({ heightStyle: \"content\" ,collapsible: true   });	});	</script>";
				$datatottal12as.="<div id=\"".$uniko."\">";
                while (($file = readdir($dh))) {
                    //echo "<li>Nombre de archivo: $file : Tiene un tamaño ".filesize($ruta.$file)." con fecha de último acceso ".fileatime($ruta.$file).", fecha de última modificación ".filemtime($ruta.$file)." y fecha de creación: ".filectime($ruta.$file);         
                    $coddee = '';

                    if (is_dir($ruta . $file) && $file != "." && $file != "..") {						
						$datatottal12as.= "<h3>Directorio: ".utf8_decode($file)."</h3>";
						$datatottal12as.= "<div><ul>";
						$datatottal12as.=$this->listado_completo($ruta . $file . "/", $PROFUNDIDAD - 1,$web.$file.'/',$carpeta_master);
						$datatottal12as.= '</ul></div>';						
                    } else {

                        if (!$this->flagg) {
                            $coddee = uniqid('manu_') . md5(utf8_encode($file));
                            $this->archivos[$coddee] = array(
							'file'=>$file,
							'dir'=>$web
							);                            
                        } else {
                            $coddee = '';
                            foreach ($this->archivos as $k => &$n) {
                                //echo '<pre>Busca en el ' . $k . '\n<br/>' . print_r($n,true) . '</pre>';
								if ($n['file'] == $file) {
                                    $coddee = $k;
                                }
                            }
                        }						
                        if (strlen($file) >= 3) {
							if ( stripos(utf8_decode($web),utf8_decode($carpeta_master)) !== FALSE  || utf8_decode($carpeta_master)=="%"){								 
								$datatottal34de.= "<li>Nombre de archivo: ".utf8_decode($file)." : <a href='?T=DES&nombre=$coddee' class=\"ui-state-default ui-corner-all\">Descarga</a></li>";
								}
							//"<li  title=\".ui-icon-disk\"></li>"span
                        }
                        //echo "</li>";
                    }
                }
				$datatottal12as.="</div>";
                closedir($dh);
                //echo "</ul>";
            }
			$datatottal34de.=$datatottal12as;
        }
        else
            $datatottal34de.= "<br>No es ruta valida";
		return $datatottal34de;
    }

    function log_data($numero, $texto, $archivo = 'error.log') {
        $ddf = fopen($archivo, 'a');
        fwrite($ddf, "[" . date("r") . "] Error $numero:$texto\r\n");
        fclose($ddf);
    }
	function get_ip_address(){
                    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
                }

}
?>
