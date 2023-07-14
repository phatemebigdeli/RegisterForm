<?php

include_once 'semej.php';
include_once 'config.php';




//signup method
function signup($data){
    $username = validate($data['username']);
    $email = validate($data['email']);
    $password = validate($data['password']);
    $passwordConfirm = validate($data['passwordConfirm']);

if($password !== $passwordConfirm){
    Semej ::set('Error','error',"Passwords dosn't match");
    header ('Location: index.php');die;

}
if(checkUsername($username)){
    Semej ::set('Error','error',"Username exists!");
    header ('Location: index.php');die;
}
if(checkEmail($email)){
    Semej ::set('Error','error',"Email exists!");
    header ('Location: index.php');die;
}
$password =sha1($password.SALT);

$dbs = dbsConnection();
$query = "INSERT INTO users_tb(username,email,password) VALUES (:username,:email,:password)";
$stmt =$dbs->prepare($query);
$stmt->bindParam(':username',$username);
$stmt->bindParam(':email',$email);
$stmt->bindParam(':password',$password);
$stmt->execute();
if($dbs->prepare($query)){
    Semej ::set('OK','OK',"Done!");
    header ('Location: index.php');die;
}else{
    Semej ::set('Error','error',"Signup failed!");
    header ('Location: index.php');die;
}


}



//login
function login($data){
    $email = validate($data['email']);
    $password = validate($data['password']);

if(!checkEmail($email)){
    Semej ::set('Error','error',"invalid email !");
    header ('Location: index.php');die;

}
$dbs = dbsConnection();
$query = "SELECT password,username FROM users_tb WHERE email = :email";
$stmt = $dbs->prepare($query);
$stmt->bindParam(':email',$email);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_ASSOC);
$hashedPassword = $result['password'];


if((sha1($password.SALT) != $hashedPassword)){
    Semej ::set('Error','error',"invalid email or password !");
    header ('Location: index.php');die;
}

$_SESSION['username'] = $result['username'];
$_SESSION['token'] = md5($result['username'].SALT);

header('Location: log.php');die;

}




//validate data
function validate($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;

}


function dbsConnection(){
    try{
    $server =DNS;
    $username = DB_USER;
    $pass = DB_PASS;
   $conn = new PDO($server,$username,$pass);
   $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
   catch (PDOException $e){
    die('DBS connection error!');
   }
   return $conn;
}


function checkUsername($username){
    $username = validate($username);
    $dbs = dbsConnection();
    $query = "SELECT id FROM users_tb WHERE username = :username";
    
    $stmt = $dbs->prepare($query);

    $stmt->bindParam('username',$username);
    $stmt->execute();

    if(($stmt->fetchColumn())>0){
        return true;
    }else{
        return false;
    }
}


function checkEmail($email){
    $email = validate($email);
    $dbs = dbsConnection();
    $query = "SELECT id FROM users_tb WHERE email = :email";
    $stmt = $dbs->prepare($query);
    $stmt->bindParam('email',$email);
    $stmt->execute();

    
    if(($stmt->fetchColumn())>0){
        return true;
    }else{
        return false;
    }
}


function logout(){
    session_unset();
    session_destroy();
    header('Location: log.php');die;
}