<!DOCTYPE html>
<html>
<head>
	<title>traitement</title>
	<meta charset="utf-8">
      <style type="text/css">
      .erreur{
      color:#fff;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color:red;
      }
      .index a{
         
         font-size:1.2em;
      }
      </style>
</head>
<body>
      <?php
      include('connexion.php');
      session_start();
       $login=$_GET['login'];
       $message=addslashes(htmlspecialchars($_GET['message']));
       $sql1 = "SELECT * FROM `user` WHERE login='".$login."'";
       $rslt1 = mysqli_query($link, $sql1);
       $data1 = mysqli_fetch_assoc($rslt1);
       if($data1==null){
            
            echo "<span class=\"erreur\">Login incorrect</span>";
            echo "<span class=\"index\"><a href=\"message.php\">Reessayez!!</span>";

       }

       else {
       $id_user = $data1['id_user'];
       $sql="INSERT INTO `messages`(`id_user`, `message`) VALUES ('$id_user', '$message')";
       $resultat=mysqli_query($link,$sql);
       if($resultat){
       $temps=365*24*3600;
       setcookie("login",$data1['login'],time()+$temps);
       header('Location: message.php');
      }
      else{
          echo $sql;
          echo "<span style=\"color:#fff; background-color:red;font-size:1.2em;\">prb sql</span>";
      }
      }
       ?>
</body>
</html>
<?php 
 mysqli_close($link);
 ?>