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

	/**************************************************************************************************************/

	/***************************************************************************************************************/
	
	private static $Key = "";
 
    public static function encrypt ($input) {
        $output = urlencode(base64_encode($input));
        return $output;
    }
 
    public static function decrypt ($input) {
        $output = urldecode(base64_decode($input));
        return $output;
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
            header('Content-Disposition: attachment; filename="' . $downloadfilename.'"');
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
        return substr(strrchr($filename . '', '.'), 1);
    }

    public function SetArchivos($archivos) {
        $this->archivos = $archivos;
    }
	
	//
	public $myusername, $mypassword, $database_manuales7sd, $manuales7sd,$sitio_manuales7sd,$sitio;
	public function setSite($sitio_manuales7sd){
		$this->sitio_manuales7sd=$sitio_manuales7sd;
	}
	public function setDbData($myusername, $mypassword, $database_manuales7sd, $manuales7sd,$sitio, $SESSION){
		$this->sitio=$sitio;
		$this->myusername=$myusername;
		$this->mypassword=$mypassword;
		$this->database_manuales7sd=$database_manuales7sd;
		$this->manuales7sd=$manuales7sd;
	}

public function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
        if (PHP_VERSION < 6) {
            $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        }

        $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

        switch ($theType) {
            case "text":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "double":
                $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                break;
        }
        return $theValue;
    }
	public function setLogNavega($sitio_manuales7sd,$id_users,$tipo,$id_archivo,$archivo){ 
		///////////////////////////////////////
			$updateSQL = sprintf("INSERT INTO `log_".$sitio_manuales7sd."` (`username`, `tipo`, `id_archivo`, `archivo`, `fechainsert`) VALUES 
			(%s,%s,%s,%s,CURRENT_TIMESTAMP)",
			$this->GetSQLValueString($id_users, "text"), $this->GetSQLValueString($tipo, "text"), 
			$this->GetSQLValueString($id_archivo, "text"), $this->GetSQLValueString($archivo, "text"));			
			mysql_select_db($this->database_manuales7sd, $this->manuales7sd);
			$Result1 = mysql_query($updateSQL, $this->manuales7sd) or die(mysql_error());			
		
		///////////////////////////////////////
	}	
	
	
	public function putarchivo($sitio_manuales7sd,$filesize, $filemtime, $filedate, $filetype, $filename, $filename_url,$nombre ,$email,$id_perfiles){

		///////////////////////////////////////
			$updateSQL = sprintf("INSERT INTO `archivos_".$sitio_manuales7sd."`( `filesize`, `filemtime`, `filedate`, `filetype`, `filename`, `filename_url`, `email`, `created_at`, `updated_at`, `nombre`,id_perfiles) 
		VALUES (%s,%s,%s,%s,%s,%s,%s,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,%s,%s)",
			$this->GetSQLValueString($filesize, "text"), $this->GetSQLValueString($filemtime, "text"), 
			$this->GetSQLValueString($filedate, "text"), $this->GetSQLValueString($filetype, "text"), 
			$this->GetSQLValueString($filename, "text"), $this->GetSQLValueString($filename_url, "text"), 			
			$this->GetSQLValueString($email, "text"),     $this->GetSQLValueString($nombre, "text"),
			$this->GetSQLValueString($id_perfiles, "int"));
			/*echo "1.-".$this->GetSQLValueString($filesize, "text")."\n";
			echo "2.-".$this->GetSQLValueString($filemtime, "text") ."\n";
			echo "3.-".$this->GetSQLValueString($filedate, "text")."\n";
			echo "4.-".$this->GetSQLValueString($filetype, "text")."\n";
			echo "5.-".$this->GetSQLValueString($filename, "text")."\n";
			echo "6.-".$this->GetSQLValueString($filename_url, "text") ."\n";			
			echo "7.-".$this->GetSQLValueString($email, "text")."\n";
			echo "8.-".$this->GetSQLValueString($nombre, "text")."\n";*/
			mysql_select_db($this->database_manuales7sd, $this->manuales7sd);
			$Result1 = mysql_query($updateSQL, $this->manuales7sd) or die(mysql_error());
			echo $updateSQL.'\n';
			
		
		///////////////////////////////////////
	}	
	public function getarchivo($sitio_manuales7sd,$id_perfiles){
		mysql_select_db($this->database_manuales7sd, $this->manuales7sd);
		$query_rs_user = sprintf("SELECT * FROM `archivos_".$sitio_manuales7sd."` WHERE `id_perfiles` =%s", GetSQLValueString($id_perfiles, "int"));
		$rs_user = mysql_query($query_rs_user, $this->manuales7sd) or die(mysql_error());
		$row_rs_user = mysql_fetch_assoc($rs_user);
		$totalRows_rs_user = mysql_num_rows($rs_user);
		echo "<pre>";
		echo "*****************************************".$query_rs_user;
		/*print_r($totalRows_rs_user);
		print_r($row_rs_user);
		print_r($rs_user);*/
		$models = array();
		while($res = mysql_fetch_assoc($rs_user)) {
			$models[] = $res;
		}
		print_r($models);
		echo "</pre>";
		mysql_free_result($rs_user);
	}

    function listado_completo_permisos($ruta, $PROFUNDIDAD, $web = '', $carpeta_master = '%',$spaciox="",$padre_id=-1,$id_perfiles,$ClaseLogin=null) {
        $datatottal34de = "";
        $datatottal12as = "";
        //$this->log_data(889466681233644489440, print_r($this->archivos, true), 'KlActiveDataLog2Z34.log');
		
        IF ($PROFUNDIDAD <= 0) {
            exit;
        }
// abrir un directorio y listarlo recursivo 
        if (is_dir($ruta)) {
			$id_propio=$padre_id++;
            //echo "<ul>";
            if ($dh = opendir($ruta)) {
                $uniko = uniqid('accordion_');
				//$datatottal12as.= $spaciox."<ul>\n";
				$ctn=0;
				$this->getarchivo($this->sitio_manuales7sd,"1");
                while (($file = readdir($dh))) {
					//echo "+++<pre>";
					//echo (filesize($ruta.'/'.$file)/(1024))/(1024);
					$filename=$ruta.'/'.$file;
					//echo $file;echo("\n");
					//echo filesize($filename);echo("\n");
					//echo "$filename was last modified: " . date ("F d Y H:i:s.", filemtime($filename));
					//echo date ("F d Y H:i:s.", filemtime($filename));echo("\n");
					//echo filetype($filename);echo("\n");
					//$this->putarchivo($this->sitio_manuales7sd,filesize($filename), filemtime($filename), date ("F d Y H:i:s.", filemtime($filename)),filetype($filename), $filename, urlencode(utf8_decode($file)),$file, 'admin@admin.com',$id_perfiles);
					//echo "</pre>---";
					$id_propio++;
                    $coddee = '';
                    if (is_dir($ruta . $file) && $file != "." && $file != "..") {
						$datatottal12as.= $spaciox."<fieldset data-role=\"controlgroup\">";
                        $datatottal12as.= $spaciox."<h3>Directorio: " . utf8_decode($file) . "</h3>";
						echo '<ul data-role="listview">';
						$this->log_data(77777777777777777777,$id_propio.';'.$padre_id.';'.'Carpeta'.utf8_decode($file) , 'KlArbol2Z34.log');
                        //$datatottal12as.= "<div>";
					    $datatottal12as.="".$spaciox.$this->listado_completo_permisos($ruta . $file . "/", $PROFUNDIDAD - 1, $web . $file . '/', $carpeta_master,$spaciox."",$id_propio);
						echo '</ul>';
                        $datatottal12as.= '</fieldset>';
                    } else {

                        if (!$this->flagg) {
                            $coddee = uniqid('manu_') . md5(utf8_encode($file));
                            $this->archivos[$coddee] = array(
                                'file' => $file,
                                'dir' => $web
                            );
                        } else {
                            $coddee = '';
							if(isset($this->archivos))
                            foreach ($this->archivos as $k => &$n) {                                
                                if ($n['file'] == $file) {
                                    $coddee = $k;
                                }
                            }
                        }
                        if (strlen($file) >= 3) {
								$nombre_code=urlencode(utf8_decode($file));
                            //if (stripos(utf8_decode($web), utf8_decode($carpeta_master)) !== FALSE || utf8_decode($carpeta_master) == "%") {
								$datatottal34de.= '
								<input name="'.$nombre_code.'" id="'.$nombre_code.'" data-theme="b" type="checkbox"><label for="'.$nombre_code.'">'.utf8_decode($file).'</label>' ;
//								$datatottal34de.= "<li>" . utf8_decode($file) . " : <a href='?T=DES&nombre=$coddee' class=\"ui-state-default ui-corner-all\" data-ajax=\"false\">Descarga</a></li>";								
								$this->log_data(77777777777777777777,$id_propio.';'.$padre_id.';'.'Archivo'.utf8_decode($file) , 'KlArbol2Z34.log');
								$ctn++;
                            //}
                            //"<li  title=\".ui-icon-disk\"></li>"span
                        }
                        //echo "</li>";
                    }
                }
                //$datatottal12as.=$spaciox."</ul>\n";
                closedir($dh);
                //echo "</ul>";
            }
            $datatottal34de.=$datatottal12as;
        }
        else
            $datatottal34de.= "<br>No es ruta valida";
        return $datatottal34de;
    }
	function listado_archivos_base($user){
		$sql="SELECT DISTINCT  users_".$this->sitio.".username,
       archivos_".$this->sitio.".nombre as nombre,
	   archivos_".$this->sitio.".id as id_archivo,
       archivos_".$this->sitio.".nuevo
  FROM    (   (   db69751_manuales.perfiles_usuario_".$this->sitio." perfiles_usuario_".$this->sitio."
               INNER JOIN
                  db69751_manuales.users_".$this->sitio." users_".$this->sitio."
               ON (perfiles_usuario_".$this->sitio.".id_users = users_".$this->sitio.".id))
           INNER JOIN
              db69751_manuales.archivos_perfiles_".$this->sitio." archivos_perfiles_".$this->sitio."
           ON (archivos_perfiles_".$this->sitio.".id_perfiles =
                  perfiles_usuario_".$this->sitio.".id_perfiles))
       INNER JOIN
          db69751_manuales.archivos_".$this->sitio." archivos_".$this->sitio."
       ON (archivos_".$this->sitio.".id = archivos_perfiles_".$this->sitio.".id_archivos)
	   where users_".$this->sitio.".username = %s order by archivos_".$this->sitio.".nombre asc ";
	   mysql_select_db($this->database_manuales7sd, $this->manuales7sd);
		$query_Recordset1 = sprintf($sql, $this->GetSQLValueString($user, "text"));
		$Recordset1 = mysql_query($query_Recordset1, $this->manuales7sd) or die(mysql_error());
		$row_Recordset1 = mysql_fetch_assoc($Recordset1);
		$totalRows_Recordset1 = mysql_num_rows($Recordset1);
		$dfg3="<ul data-role=\"listview\" data-filter-placeholder=\"Buscar Manual...\" data-autodividers=\"true\" data-filter=\"true\" data-inset=\"true\">";      
		 do { 
			$nuevo=($row_Recordset1['nuevo']!=-1)?"<span style=\"color:red\"> Nuevo</span>":""; 
			$dfg3=$dfg3."<li><a data-ajax=\"false\" href=\"?T=DES&idA=".Util::encrypt($row_Recordset1['id_archivo'])."&nombre=".Util::encrypt($row_Recordset1['nombre'])."\" class=\"ui-btn ui-icon-action ui-btn-icon-right ui-shadow ui-corner-all\">".$row_Recordset1['nombre']."".$nuevo."</a></li>";
		 } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
		 $dfg3=$dfg3."</ul>";
		 mysql_free_result($Recordset1);
		 return $dfg3;
	}
	function listado_completo($ruta, $PROFUNDIDAD, $web = '', $carpeta_master = '%',$spaciox="",$padre_id=-1,$ClaseLogin=null) {
        $datatottal34de = "";
        $datatottal12as = "";
        //$this->log_data(889466681233644489440, print_r($this->archivos, true), 'KlActiveDataLog2Z34.log');
		
        IF ($PROFUNDIDAD <= 0) {
            exit;
        }
// abrir un directorio y listarlo recursivo 
        if (is_dir($ruta)) {
			$id_propio=$padre_id++;
            //echo "<ul>";
            if ($dh = opendir($ruta)) {
                $uniko = uniqid('accordion_');
				//$datatottal12as.= $spaciox."<ul>\n";
                while (($file = readdir($dh))) {
					$id_propio++;
                    $coddee = '';
                    if (is_dir($ruta . $file) && $file != "." && $file != "..") {
						$datatottal12as.= $spaciox."<div data-role=\"collapsible\" data-inset=\"false\">";
                        $datatottal12as.= $spaciox."<h3>Directorio: " . utf8_decode($file) . "</h3>";
						echo '<ul data-role="listview">';
						$this->log_data(77777777777777777777,$id_propio.';'.$padre_id.';'.'Carpeta'.utf8_decode($file) , 'KlArbol2Z34.log');
                        //$datatottal12as.= "<div>";
					    $datatottal12as.="".$spaciox.$this->listado_completo($ruta . $file . "/", $PROFUNDIDAD - 1, $web . $file . '/', $carpeta_master,$spaciox."",$id_propio);
						echo '</ul>';
                        $datatottal12as.= '</div>';
                    } else {

                        if (!$this->flagg) {
                            $coddee = uniqid('manu_') . md5(utf8_encode($file));
                            $this->archivos[$coddee] = array(
                                'file' => $file,
                                'dir' => $web
                            );
                        } else {
                            $coddee = '';
							if(isset($this->archivos))
                            foreach ($this->archivos as $k => &$n) {                                
                                if ($n['file'] == $file) {
                                    $coddee = $k;
                                }
                            }
                        }
                        if (strlen($file) >= 3) {
                            if (stripos(utf8_decode($web), utf8_decode($carpeta_master)) !== FALSE || utf8_decode($carpeta_master) == "%") {
								$datatottal34de.= "<li>" . utf8_decode($file) . " : <a href='?T=DES&nombre=$coddee' class=\"ui-state-default ui-corner-all\" data-ajax=\"false\">Descarga</a></li>";
								$this->log_data(77777777777777777777,$id_propio.';'.$padre_id.';'.'Archivo'.utf8_decode($file) , 'KlArbol2Z34.log');
                            }
                            //"<li  title=\".ui-icon-disk\"></li>"span
                        }
                        //echo "</li>";
                    }
                }
                //$datatottal12as.=$spaciox."</ul>\n";
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

    function get_ip_address() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

}

?>
