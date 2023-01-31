<html>
<head>
    <title>login</title>
    <link rel="stylesheet" type="text/css" href="../asset/styles/login.css"> 
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3' crossorigin='anonymous'>
  <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js' integrity='sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p' crossorigin='anonymous'></script>
 
</head>
<body>
    <div class="box">
        
        <h2>Login</h2>
        <form method="POST">
                <div class="inputBox">
                     <input type="text" name="username" required>
                     <label>Username</label>
                </div>
                <div class="inputBox" >
                   <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <input type="submit" name="login" value="Login" required >
       </form>
    </div>
</body>
</html>

<?php 
if(isset($_POST['login'])){
    include '../asset/includes/dbconect.php' ;
    $username = $_POST['username'];
    $password = $_POST['password'];
    $check = $database->prepare("SELECT * FROM login WHERE  username =:username and password =:PASSWORD");
    $check->bindParam("username",$username);
    $check->bindParam("PASSWORD",$password);
    $check->execute();
    $user = $check->fetchObject();
    if($check->rowCount() >0){
        session_start();
        $_SESSION['name'] = $user->name;
        $_SESSION['id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['password'] = $user->password;
        header("location:index.php");
    }
    else{
        echo 'your password or user name is invaled';
    }

}
?>