<?php
session_start();
include ('connexion.php'); 
if(isset($_POST['connexion'])){ 
if(isset($_POST['login']) && isset($_POST['password'])){
    function validate($data){
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

$login = validate($_POST['login']);
$pass = $_POST['password'];
if(empty($login)){
    header("Location: message.php?error=login is required");
    exit();
}else if(empty($pass)){
    header("Location: message.php?error=Password is required");
    exit();
}else{
  
    
    $sql = "SELECT * FROM `user` WHERE login = '".$login."'";
   
    $reslt = mysqli_query($link, $sql);
    if(mysqli_num_rows($reslt) === 1){
        $row = mysqli_fetch_assoc($reslt);
       
       if($row['login'] == $login && password_verify($pass, $row['pass'])){
            $_SESSION['login'] = $row['login'];
            $_SESSION['nom'] = $row['nom'];
            $_SESSION['prenom'] = $row['prenom'];
            $_SESSION['photo'] = $row['photo'];
            $_SESSION['id_user'] = $row['id_user'];
            header("Location: message.php");
            exit();
        }
        else{
            
           
          header("Location: index.php?error=Incorect password");
          exit();
            }
        }
        else{
           header("Location: index.php?error=Incorect User name or password");
           exit();
        }
    }
    
}
}
mysqli_close($link);
?>
<!DOCTYPE html>
<html>
<head>
	 <title>Login</title>
	 <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form action="" method="post">
    <h2>Login</h2>	
    <?php if(isset($_GET['error'])){ ?>
    <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <label>login</label>
    <input type="text" name="login" placeholder="login"><br>
    <label>Password</label>
    <input type="password" name="password" placeholder="password"><br>
    <button type="submit" name="connexion">connexion</button>
    <a href="nouveau.php" class="ca">Create an account</a>

</form>
</body>	 	 
</html>


