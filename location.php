<?php

// $hostname="localhostname";
// $db="locations";
// $username="root";
// $password="";
//$conn= new PDO ("Mysql:host=$hostname;dbname=$db",$username,$password);
 if(isset($_POST['submit'])){
$address = $_POST['addressback'];
$title = $_POST['title'];
$description = $_POST['description'];
$lat = $_POST['lat'];
$lng = $_POST['lng'];

$conn = mysqli_connect("localhost", "root", "", "locations");
if(mysqli_connect_error()){
    die('connect Error('.mysqli_connect_error().')'. mysqli_connect_error());
}
else{
    
    $test="mdsm,flm";
    $Insert="Insert into getlocation (Address,title,Description,lat,lng) values(?,?,?,?,?)";
    $stmt=$conn->prepare($Insert);
    $stmt->bind_param("sssss",$address,$title,$description,$lat,$lng);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    header("LOCATION:./addlocation.php");
}
}
//     $value="value";
// $sql = $conn->prepare("Insert into location (name)
// values (:value)");
// $conn ->beginTransaction();
// $sql->execute(array(':value'=>$value));
 


?>
