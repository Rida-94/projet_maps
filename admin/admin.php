<!DOCTYPE html> 
<html lang="fr"> 
 
	<head>
		<meta charset="utf-8">
		<title>Administration</title>
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
			<h1>Administration du blog</h1>
			<div id="add"><a href="add_article.php">Ajouter un nouveau point sur la carte</a><br /><br />
			               <a href="itineraire.php">Tracer l'itineraire</a></div>

			<a href="SQLtoXML.php">génération du fichier XML (à partir de la BDD)</a> - 
			<a href="../xml/point.xml"> lecture du fichier XML</a><br />
			<br /><br />
			<?php
				require('../id_connexion.php');

				$req = $bdd->query('SELECT * FROM map ORDER BY ville ASC');
				while($data = $req->fetch()){
					echo '<div class="comment">';
					echo '<a class="delete" href="delete.php?p='.$data['id'].'"><img src="../images/false.png" /></a>';
						echo '<h3>'.stripslashes($data['ville']).'</h3>';
						echo '<p>Description : '.stripslashes($data['description']).'</p>';
						echo '<p>Longitude : '.stripslashes($data['longitude']).'</p>';
						echo '<p>Latitude : '.stripslashes($data['latitude']).'</p>';
						echo '<p>population : '.stripslashes($data['population']).'</p>';
						echo '<p class="edit"><a href="edit.php?p='.$data['id'].'">Editer cet article</a></p>';
					echo '</div>';
				}
				$req->closeCursor();
			?>

			<a href="deconnection.php">déconnexion</a>
		</div>
	</body>
</html>
