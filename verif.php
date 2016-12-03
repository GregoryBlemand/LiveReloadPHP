<?php
// On va se créer un petit live reload en Ajax
/*
Coté client, on insère un script dans la page qui fait une requète ajax régulière vers le fichier de vérification.
On envoie les liens des fichiers à surveiller

Le serveur récupère ces fichiers et vérifie leur date de modification
	- au premier passage, on enregistre leurs dates de modif dans un fichier JSON et on retourne false
	- aux passages suivant, on vérifie si les dates on changées
		- si non, on return false
		- si oui, on met à jour le fichier JSON et on return true

Au retour de la requète, si la réponse est true on reload la page avec document.location.reload(true);
*/

if(isset($_GET['watch'])) {

	$reload = 'false'; // un booléen qui permettra de forcer le reload
	$out = ''; // un liste "fichier|dateDeModif||fichier|dateDeModif..."
	$files = explode("|",$_GET['watch']);
	for($i = 0; $i < count($files); $i++){
		$filename = $files[$i];
		$date = date("d m Y H:i:s", filemtime($filename));
		if($i == 0){
			$out .= $filename . '|' . $date;
		} else {
			$out .= '||' . $filename . '|' . $date;
		}
	}

	if (!(file_exists('data.txt'))) { // si le fichier db n'existe pas, on le crée
		$db = fopen('data.txt', 'w+');
	    fputs($db, $out);
	    fclose($db);
	}
	$test = '';
	$db = fopen('data.txt', 'r+'); 
	$dateModif = fgets($db);
	if(strlen($dateModif) == 0){ // si le fichier est vide
		fputs($db, $out);
	} else { // s'il ne l'est pas 
		// si la $date est différente de $dateModif, fseek($db,0); fputs($db, $out); echo 'true';
		for($i = 0; $i < count($files); $i++){ 
			$filename = $files[$i];
			$date = date("d m Y H:i:s", filemtime($filename));
			$position[$i] = stripos($dateModif, $filename); // on cherche le nom du fichier dans la liste
			if(!$position){ // on ne le trouve pas, on le rajoute
				$out .= '||' . $filename . '|' . $date;
			} else { // on le trouve, on vérifie si les dates sont identiques
				$dateDB = substr($dateModif, ($position[$i] + strlen($filename) +1), 19);

				$test .= $filename . ' ' . $dateDB . ' => ' . $date . '<br>';

				if(!($dateDB == $date)){
					$reload = 'true';
				}
			}
		}
		fseek($db,0); fputs($db, $out);
	}
	
	fclose($db);
	echo $reload;
}
?>