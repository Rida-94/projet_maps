<?php
session_start();
if(empty($_SESSION['admin'])){
	header('Location: index.php');
}
  
if(empty($_GET)){
	header('Location: index.php');
}

if(!empty($_GET)){
	extract($_GET);
	$p=strip_tags($p);


require('../id_connexion.php');
try{
  $bdd = new PDO('mysql:host='.$dbhost.';dbname='.$dbname,$dblogin,$dbpass) or die(print_r($bdd->errorInfo()));
  $bdd->exec('SET NAMES utf8');
}

catch(Exeption $e){
  die('Erreur:'.$e->getMessage());
}

$req = $bdd->prepare('SELECT * FROM map WHERE id=:id');
$req->execute(array('id'=>$p));
if($req->rowCount()==0){
	header('Location: index.php');
}
$req->closeCursor();

if(!empty($_POST)){
  extract($_POST);
  $valid=true;
  
  if($valid){

    $req = $bdd->prepare('UPDATE map SET ville=:ville, description=:description, longitude=:longitude, latitude=:latitude, population=:population WHERE id=:id');
    $req->execute(array(
	'ville'=>UTF8_decode(addslashes($ville)),
	'description'=>addslashes($description),
	'longitude'=>UTF8_decode(addslashes($longitude)),
	'latitude'=>UTF8_decode(addslashes($latitude)),
	'population'=>UTF8_decode(addslashes($population)),
	'id'=>$p
    ));
    $req->closeCursor();
    
    header('Location: admin.php');
  }
}
}

?>

<!DOCTYPE html> 
<html lang="fr"> 
	<head>	
		<meta charset="utf-8">

		<title>XML et Google Map</title>
		<meta name="description" content="test Google Map !">
		<meta name="keywords" content="Google Map !">
		<meta name="author" content="Guillaume RICHARD">
		<meta name="geo.placename" content="Aurillac-sur-Vendinelle">

		<link rel="stylesheet" href="../css/html.css">
		<link rel="stylesheet" href="../css/style.css" />
	</head>

	<body>
		<div id="header"></div>
		<div id="content">
			<h1>Modification</h1>
			<a href="admin.php">Administration</a>

			<?php
				$req = $bdd->prepare("SELECT ville,description,longitude,latitude, population FROM map WHERE id=".$p);
				$req->execute();
				$data = $req->fetch();
				$ville = $data['ville'];
				$description = $data['description'];
				$longitude = $data['longitude'];
				$latitude = $data['latitude'];
				$population = $data['population'];
				$req->closeCursor();
			?>
			<form name="edit" action="edit.php?p=<?php echo $p;?>" method="post">
			<label for="titre">Ville :</label>
			<input type="text" name="ville" value="<?php echo stripslashes($ville);?>" />

			<label for="titre">Longitude :</label>
			<input type="text" name="longitude" value="<?php echo stripslashes($longitude);?>" />

			<label for="titre">Latitude :</label>
			<input type="text" name="latitude" value="<?php echo stripslashes($latitude);?>" />

			<label for="titre">Population :</label>
			<input type="text" name="population" value="<?php echo stripslashes($population);?>" />
			
			<label for="article">Description : </label>
			<textarea name="description"><?php echo stripslashes($description); ?></textarea>

			<input id="ok" type="submit" name="envoyer" value="Modifier" />
			</form>
		</div>
	</body>
</html>
