<?php
	
	$fila = 1;
if (($gestor = fopen("user/USUARIOS_ready.csv", "r")) !== FALSE) {
    while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
        $numero = count($datos);
        //echo "<p> $numero de campos en la l?a $fila: <br /></p>\n";
        $fila++;
        for ($c=0; $c < $numero; $c++) {
            //echo $datos[$c];
			//$datos = trim($datos[$c]," ");
			$datos = str_replace("  "," ",$datos);
			 /* if(substr($datos[$c],-1)==" "){
				//$datos = substr($datos,0,-1);
				echo "---".substr($datos[$c],-1);
			} */
			$arreglo = explode(" ", $datos[$c]);
			//echo " - ";
			//echo "---".substr($datos[$c],-1);
			$name = arr($arreglo);

			echo "$name<br/>";
			
        }
    }
    fclose($gestor);

}

function arr($arreglo){
		$size = sizeof($arreglo);

		//si el nombre tiene solo 2 palabras
		if($size==2){
			//el primero es nombre
			$nombre =$arreglo[0];
			//el segundo es apellido
			$apellidop = $arreglo[1];
			$apellidom = "";
		}else{
		
		
		//los tokens se utilizan para crear apellidos compuestos
		$tokens = "de la del las los mac mc van von y i san santa ";
		$nombre ="";
		$apellidop = "";
		$apellidom = ""; 
		

		//echo $size;
		//los tokens son utilizados para saber sobre que palabra estamos trabajando
		$estadoName=" ";
		//empezamos a trabajar con el apellido paterno
		$estadoAP="token";
		$estadoAM=" "; 

		//recorre el nombre palabra por palabra
		for($size;-1<$size;$size--){
			//echo $arreglo[$size]."-";
			//si la palabra no está vacia
		    if(!empty($arreglo[$size])){
		    	//si la palabra para trabajar es apellido paterno
				if($estadoAP=="token"){
					$apellidop = $arreglo[$size]." ".$apellidop;
					//echo "($apellidop--)";
					//Si la palabra anterior existe y es diferente a cadena vacia
					if ($size-1>=0 and $arreglo[$size-1]!="") {
						//Si la palabra anterior tiene alguna palabra token
						if(!buscarCadena($tokens,$arreglo[$size-1])){	
							$estadoName=" ";
							$estadoAP="";
							$estadoAM="token";
						}
					}	
				}
				else if($estadoAM=="token"){
					$apellidom = $arreglo[$size]." ".$apellidom;
					
					//Si la palabra anterior existe y es diferente a cadena vacia
					if ($size-1>=0 and $arreglo[$size-1]!="") {
						//Si la palabra anterior tiene alguna palabra token
						
						if(!buscarCadena($tokens,$arreglo[$size-1])){	
							$estadoName="token";
							$estadoAP=" ";
							$estadoAM=" ";
						}
					}
					
				}else if($estadoName=="token"){
					$nombre = $arreglo[$size]." ".$nombre;
				
				}
				
			}
		}
		}
		//limpia espacios en blanco
		$nombre    = trim($nombre);
		$apellidom = trim($apellidom);
		$apellidop = trim($apellidop);

		$complete_name = "";
		//si existe nombre lo imprime
		if ($nombre!="") {
			$complete_name .= $nombre.",";
			//echo "$nombre,";
		}
		//si existe apellido paterno lo imprime
		if ($apellidom!="") {
			//echo "$apellidom,";
			$complete_name .= $apellidom.",";
		}
		//si existe apellido materno lo imprime
		if($apellidop!=""){
			//echo "$apellidop";
			$complete_name .= $apellidop;
		}
		return $complete_name;
	}
	
function buscarCadena($cadena,$palabra){
        if(stristr($cadena,$palabra)){
			return true;
        }else{
			return false;
        }   
    }
	
	
?>