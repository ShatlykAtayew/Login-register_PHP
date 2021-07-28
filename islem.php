<?php 

session_start();

$servername = "localhost";
$username = "root";
$password = "****";

try {
  $baglanti = new PDO("mysql:host=$servername;dbname=yazilim_yolcusu", $username, $password);
  // set the PDO error mode to exception
  $baglanti->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


if (isset($_POST["signIn"])) {
	$email = htmlspecialchars($_POST["email"]);
	$password = htmlspecialchars($_POST["password"]);

if ($email && $password) {
	$kullanicisor=$baglanti->prepare("SELECT * FROM kullanici WHERE k_adi=:email AND sifre=:password");
	$kullanicisor->execute(array(
		'email'=>$email,
		'password'=>$password));
	$count=$kullanicisor->rowCount();

if ($count > 0) {
	$_SESSION['ad'] = $email;
	header('Location:./index.php');


} else {
	header('Location:./login.php?durum=no');
	
}
}
}



if (isset($_POST["register"])) {
	
	$kaydet=$baglanti->prepare("INSERT INTO kullanici SET
	ad_soyad=:fullname,
	yetki=:role,
	sifre=:password,
	k_adi=:email
	");

	$insert=$kaydet->execute(array(
	'fullname'=>$_POST['fullName'],
	'email'=>$_POST['email'],
	'role'=>$_POST['role'],
	'password'=>$_POST['password']

	));
if ($insert){
	Header("Location:./kullanici.php?durum=ok");

}
else{
	Header("Location:./kullanici.php?durum=no");
}
}

 ?>