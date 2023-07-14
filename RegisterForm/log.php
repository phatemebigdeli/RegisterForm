<?php
include_once './controller/methods.php';
if(!isset($_SESSION['token'])){
    header('Location: index.php');die;
}

if(isset($_GET['logout'])){
    logout();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
</head>
<body>
    <h1>Welcome to your panel !</h1>
    <hr>
    <p>Username: <?php echo $_SESSION['username'];?> </p>
    <a href = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?logout'; ?>'>
        <button>logout</button>
    </a>

</body>
</html>