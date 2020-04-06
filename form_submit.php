<?php
$host = "localhost";
$db_name = "mydatabase";
$username = "root";
$password = "1015";
$connection = null;
try{
$connection = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
$connection->exec("set names utf8");
}catch(PDOException $exception){
echo "Connection error: " . $exception->getMessage();
}

function saveData($first_name, $last_name, $email){
global $connection;
$query = "INSERT INTO data2(first_name, last_name, email) VALUES(:first_name, :last_name, :email)";
$callToDb = $connection->prepare( $query );
$first_name=htmlspecialchars(strip_tags($first_name));
$last_name=htmlspecialchars(strip_tags($last_name));
$email=htmlspecialchars(strip_tags($email));
$callToDb->bindParam(":first_name",$first_name);
$callToDb->bindParam(":last_name",$last_name);
$callToDb->bindParam(":email",$email);


if($callToDb->execute()){
return '<h3 style="text-align:center;">We will get back to you very shortly!</h3>';
}
}

if( isset($_POST['submit'])){
$first_name = htmlentities($_POST['first_name']);
$last_name = htmlentities($_POST['last_name']);
$email = htmlentities($_POST['email']);

//then you can use them in a PHP function.
$result = saveData($first_name, $last_name, $email);
echo $result;
$sorted0=("ALTER TABLE data2 DROP COLUMN id;");
$sorted1=("CREATE table data3 as select * from data2 ORDER BY first_name DESC;");
$sorted2=("DROP table data2;");
$sorted3=("CREATE table data2 as select * from data3 ORDER BY first_name DESC;");
$sorted4=("DROP table data3");
$sorted5=("ALTER TABLE data2 ADD id int NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;");
$connection->query($sorted0);
$connection->query($sorted1);
$connection->query($sorted2);
$connection->query($sorted3);
$connection->query($sorted4);
$connection->query($sorted5);


}
else{
echo '<h3 style="text-align:center;">A very detailed error message ( ͡° ͜ʖ ͡°)</h3>';
}
?>

