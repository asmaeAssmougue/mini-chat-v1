 <?php
include('connexion.php');
session_start();
?>    
<!DOCTYPE html>
<html>
<head>
    <title>message</title>
    <meta charset="utf-8">
    <style type="text/css">
        #forme{
            border:1px solid #00b4d8;
            padding-top:10px;
            width:900px;
            margin-bottom:50px;
            height:40vh;

        }
        #mess{
            display:inline-block;
            color:red;
            font-size:1.3em;
            font-weight:bold;
            margin-left:10px;
            letter-spacing: 1px;
        }
        input[type="text"]{
            
            width:300px;
           
        }
        #pseud{
            display:inline-block;
            margin-left:50px;
            width:300px;
           
        }
         #messag{
               display: inline-block;
               margin-left:50px;
               width:350px;  
               margin-top:10px;
         }

        input[type="submit"]{
            margin-left:390px;
            margin-bottom:50px;
            margin-top:50px;
            cursor: pointer;
    background: #06d6a0;
    padding: 10px 15px;
    color: #fff;
    border-radius: 5px;
        }
        .button {
   
    float: right;
    background: #555;
    padding: 10px 15px;
    color: #fff;
    border-radius: 5px;
    margin-right: 10px;
    border: none;
    text-decoration:none;
    cursor: pointer;
    position:relative;
    bottom:13vh;
    right:20px;
}
       
    </style>
</head>
<body>
     <form method="get" action="traitement.php" id="forme">
        <label for="pseudo" id="pseud">login:</label><input type="text" name="login" id="pseud" value="<?php 
          if(isset($_COOKIE['login'])){
             echo $_COOKIE['login'];
         } ?>"><br>
        <label for="message" id="messag">Message:</label><input type="text" name="message" id="message"><br>
        <input type="submit" name="envoyer" value="envoyer"><br>
        <a href="deconnexion.php" class="button">logout</a>
     </form>
    <?php
     //recuperer les 10lign
     $sql="SELECT * FROM `messages` ORDER BY id_message DESC LIMIT 0,10 ";
     $result= mysqli_query($link,$sql);
      
     //affichage des mess des donn sont prot
     while ($data=mysqli_fetch_assoc($result)){
        $sql2 = "SELECT * FROM `user` WHERE  `id_user` = '".$data['id_user']."'";
        $rest2 = mysqli_query($link, $sql2);
        $data2 = mysqli_fetch_assoc($rest2);
        $nom = $data2['nom'];
        $prenom = $data2['prenom'];
        $photo = $data2['photo']; 
      
        if(!empty($nom) && !empty($prenom) && !empty($photo)){
      
        echo "<img src=\"photo/$photo\" alt=\"photo de profil\"  style=\"width: 50px;height: 50px; border:2px solid purple;border-radius: 50%;\"/>";
        echo '<span id="mess">'.htmlspecialchars($nom)." ".htmlspecialchars($prenom).":"."</span>";
        echo  "".htmlspecialchars($data['message'])."<br>";
  }

  else{
     header("location: message.php?error=Empty");
     exit();
}
}

      ?>

  
      
</body>
</html>
<?php 
 mysqli_close($link);
 ?>