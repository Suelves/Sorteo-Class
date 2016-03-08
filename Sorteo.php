<?php


/**
* @abstract Clase que crea sorteos a partir de un array bidimensional. Necesita lanzar el método
* Sortear para funcionar. No devuelve nada. Simplemente modifica el array bidimensional global que le entra
* por parámetro con el nombre $participantes.
*
* @version 3.1
* @author Webmasters Team.
* @copyright Media-Saturn, 2015.
* 
* @param {Array} Array bidimensional @global en qué cada array de su contenido tiene ['id','nombre','correo','amigo a quien sortear']. 
* El campo 'amigo a quien sortear' debe estar vacío '' para que el objeto se encargue de rellenarlo con el sorteo. 
*/
class Sorteo {
	
	/**
	* Constructor de la clase Sorteo
	* @param {Array} Array bidimensional @global en qué cada array de su contenido tiene ['id','nombre','correo','amigo a quien sortear']. 
	* El campo 'amigo a quien sortear' debe estar vacío '' para que el objeto se encargue de rellenarlo con el sorteo. 
	*/
	public function Sorteo($total) {
		for ($i=0; $i <= $total; $i++) { 	
			$this->asignarAmigo($total, $i);
		}
		$this->verificarSorteo($total);
	}


	public function devolverArraySorteo(&$participantes){
		// global $participantes;
		// print "<br />";
		// print_r($participantes);
		return $participantes;
	}
	

	private function ExisteAmigoAsignado($amigo,$num_sorteados) {


		global $participantes;
		for ($i=0; $i < $num_sorteados; $i++) { 
			if ($participantes[$i][3] == $amigo) {			
			// echo "<span style='color:green'>i: ".$i."a: ".$participantes[$i][3]."amigo: ".$amigo." true</span>";
				return true;
			} else {
		// echo "<span style='color:red'>i: ".$i."a: ".$participantes[$i][3]."amigo: ".$amigo." false</span>";

			}
		//print "<br />";


		}
		return false;
	}

	private function asignarAmigo($total, $i){

		global $participantes;
		$num = rand(0, $total);
			// echo "num: ".$num;
		if($num != $i && $this->ExisteAmigoAsignado($num,$i)==false){
			//if($num != $i){
			$participantes[$i][3] = $num;
			print "A ".$participantes[$i][0]." le ha tocado ".$participantes[$i][3]." <br />";

		}else{
			if($participantes[$i][0] == $total){
					//Último participante
				$num = $this->BuscarUltimoAmigo($participantes,$total);
				if ($num != $participantes[$i][0]) {
					$participantes[$i][3] = $num;
					print "A ".$participantes[$i][0]." le ha tocado el último amigo".$participantes[$i][3]." <br />";
				}
					// si amigo != ultimo participante > $participantes[$i][3] = $num;

			} else {

				$this->asignarAmigo($total, $i);
			}
		}
	}

	private function ResetearSorteo($total) {
		for ($i=0; $i <= $total; $i++) { 	
			$participantes[$i][3] = "";
		}
	}

	private function verificarSorteo($total){
		global $participantes;
		print_r($participantes); print "<br />";
		$encontradoAmigoVacio = false;
		for ($i=0; $i <= $total; $i++) { 
			echo "p:".$participantes[$i][3];
			if (strlen($participantes[$i][3]) == 0) {				
				$encontradoAmigoVacio = true;
				echo "vacio?";
			}
			print "<br />";
		}
		if ($encontradoAmigoVacio == false) {
			return true;
		} else {
			echo "REPETIR SORTEO<br/>";
			$this->ResetearSorteo($total);
			$this->sorteo = new Sorteo($total);
		}	

	}

	private function BuscarUltimoAmigo($participantes,$total) {
		
		$i = 0;
		while ( $i <= $total) {
			$encontrado = false;
			for ($j=0; $j <=$total ; $j++) { 
				if ($participantes[$i][0] == $participantes[$j][3]) {
					$encontrado = true;
					break;
				}
			}
			if ($encontrado == false) {
				// echo "Último amigo: ".$participantes[$i][0]; print "<br />";
				return $participantes[$i][0];
			} else {
				$i++;
			}
		}
	}

}

?>