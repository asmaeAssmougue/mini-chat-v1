<?php
session_start();
include "connexion.php";
if(isset($_POST['submit'])){
if(isset($_POST['password']) && isset($_POST['name']) && isset($_POST['re_password']) && isset($_POST['prenom']) && isset($_POST['login'])){
  function validate($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


$pass = $_POST['password'];
$name = validate($_POST['name']);
$re_pass = $_POST['re_password'];
$prenom =validate($_POST['prenom']);
$login =validate($_POST['login']);
$user_data = 'name='. $name. '&prenom='. $prenom;
 if(isset($_FILES['fichier']) and $_FILES['fichier']['error']==0)
  {
    $dossier = 'photo/';
    $temp_name = $_FILES['fichier']['tmp_name'];
    if(!is_uploaded_file($temp_name))
    {
            exit("le fichier est introuvable");
    }
        if($_FILES['fichier']['size'] >= 1000000){
          exit("Erreur le fichier est volumineux");
        }
        $infosfichier = pathinfo($_FILES['fichier']['name']);
        $extension_upload = $infosfichier['extension'];
        $extension_upload = strtolower($extension_upload);
        $extensions_autorisee = array('jpg','png','jpeg');
        if(!in_array($extension_upload,$extensions_autorisee))
        {
          exit("Erreur , veuillez inserer une image(extension autorise: png)");

        }
        $nom_photo=$login.".".$extension_upload;
        if(!move_uploaded_file($temp_name, $dossier.$nom_photo)){
          exit("Problem dans le téléchargement de l'image, ressayez");

        }
        $ph_name=$nom_photo;
        
  }
  else{
     $ph_name="inconnu.jpg";
  }
if(empty($pass)){
  header("Location: nouveau.php?error=Password is required&$user_data");
  exit();
}else if(empty($name)){
  header("Location: nouveau.php?error=name is required&$user_data");
  exit();
}
else if(empty($re_pass)){
  header("Location: nouveau.php?error=Re Password is required&$user_data");
  exit();
}
else if($re_pass != $pass){
  header("Location: nouveau.php?error=the confirmation password does not match&$user_data");
  exit();
}
else{
  $sql = "SELECT * FROM `user` WHERE login = '$login'";
  $reslt = mysqli_query($link, $sql);
  if(mysqli_num_rows($reslt) > 0){
    
      header("Location: nouveau.php?error=The login is taken try another&$user_data");
      exit();
    }
    else{
      $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
      $sql2 = "INSERT INTO `user`(`login`, `pass`, `nom`, `prenom`, `photo`) VALUES ('$login', '$pass_hash', '$name', '$prenom','$ph_name')";
      $reslt2 = mysqli_query($link, $sql2);
      if($reslt2){
       header("Location: index.php?success=Your account has been created successflly");
       exit();
      }
      else{
        header("Location: nouveau.php?error=unknown error occurred&$user_data");
        exit();
      }

    }
  
}
}


  else{
    header("Location: nouveau.php");
    exit();
  }
}
  ?>
<!DOCTYPE html>
<html>
<head>
	 <title>Login</title>
	 <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="navbar">
  <ul>
    <li><a href="nouveau.php">SIGN UP</a></li>
    <li><a href="index.php">LOGIN</a></li>
    <li><a href="message.php">MESSAGE</a></li>
    <li><a href="deconnexion.php">LOG OUT</a></li>
  </ul>
</div>
	<form action="" method="post" enctype="multipart/form-data">
    <h2>SIGN UP</h2>	
    <?php if(isset($_GET['error'])){ ?>
    <p class="error"><?php echo $_GET['error'];  ?></p>
    <?php } ?>

    <?php if(isset($_GET['success'])){ ?>
    <p class="success"><?php echo $_GET['success'] ?></p>
    <?php } ?>


    <label>Name</label>
    <?php if(isset($_GET['name'])){ ?>
    <input type="text" name="name" placeholder="Name" value="<?php echo $_GET['name'];  ?>"><br>
    <?php }else{ ?>
    <input type="text" name="name" placeholder="Name"><br>
    <?php } ?>
    <label>prenom</label>
    <?php if (isset($_GET['prenom'])) { ?>
               <input type="text" 
                      name="prenom" 
                      placeholder="prenom"
                      value="<?php echo $_GET['prenom']; ?>"><br>
          <?php }else{ ?>
               <input type="text" 
                      name="prenom" 
                      placeholder="prenom" required="required"><br>
          <?php }?>
          <label>login</label>
    <?php if (isset($_GET['login'])) { ?>
               <input type="text" 
                      name="login" 
                      placeholder="login"
                      value="<?php echo $_GET['login']; ?>"><br>
          <?php }else{ ?>
               <input type="text" 
                      name="login" 
                      placeholder="login" required="required"><br>
          <?php }?>
    <label>Password</label>
    <input type="password" name="password" placeholder="password"><br>
    <label>Re_Password</label>
    <input type="password" name="re_password" placeholder="re_password"><br>
    <label for="photo">Déposez votre photo:</label>
       <input type="file" name="fichier"><br><br>
    <button type="submit" name="submit">sign up</button>
    <a href="index.php" class="ca">Already have an account</a>

</form>
</body>	 	 
</html>
<?php  mysqli_close($link); ?>	
