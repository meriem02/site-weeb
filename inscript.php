<?php
$BDD = array();
$BDD['host'] = "localhost";
$BDD['user'] = "root";
$BDD['pass'] = "";
$BDD['db'] = "nom_de_la_base_de_donnees";
$mysqli = mysqli_connect($BDD['host'], $BDD['user'], $BDD['pass'], $BDD['db']);
if(!$mysqli) {
    echo "Connexion non établie.";
    exit;
}
    echo mysqli_query($mysqli,"CREATE TABLE IF NOT EXISTS `".$BDD['db']."`.`membres` ( `id` INT NOT NULL AUTO_INCREMENT , `nom` varchar (20)NOT NULL , `password` varchat(30) NOT NULL , PRIMARY KEY (`num`)) ENGINE = MyISAM;")?"Table membres créée avec succès, vous pouvez maintenant supprimer la ligne ". __LINE__ ." de votre fichier ". __FILE__ ."!":"Erreur création table membres: ".mysqli_error($mysqli);
$AfficherFormulaire=1;
if(isset($_POST['nom'],$_POST['password'])){
    if(empty($_POST['nom'])){
        echo "Le champ nom est vide.";
    } elseif(!preg_match("#^[a-z0-9]+$#",$_POST['nom'])){
        echo "Le nom doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.";
    } elseif(strlen($_POST['nom'])>25){
        echo "Le nom est trop long, il dépasse 25 caractères.";
    } elseif(empty($_POST['password'])){
        echo "Le champ Mot de passe est vide.";
    } elseif(mysqli_num_rows(mysqli_query($mysqli,"SELECT * FROM membres WHERE nom='".$_POST['nom']."'"))==1){
        echo "Ce pseudo est déjà utilisé.";
    } else {
        if(!mysqli_query($mysqli,"INSERT INTO membres SET nom='".$_POST['nom']."', password='".md5($_POST['password'])."'")){
            echo "Une erreur s'est produite: ".mysqli_error($mysqli);
        } else {
            echo "Vous êtes inscrit avec succès!";
            $AfficherFormulaire=0;
        }
    }
}
if($AfficherFormulaire==1){
    ?>
    <br />
    <form method="post" action="inscript.php">
        Pseudo (a-z0-9) : <input type="text" name="pseudo">
        <br />
        Mot de passe : <input type="password" name="mdp">
        <br />
        <input type="submit" value="S'inscrire">
    </form>
    <?php
}
?>
