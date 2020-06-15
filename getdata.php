<?php

// $hostname="localhostname";
// $db="locations";
// $username="root";
// $password="";
//$conn= new PDO ("Mysql:host=$hostname;dbname=$db",$username,$password);


$reply = array();
$tran = array();
$conn = mysqli_connect("localhost", "root", "", "locations");
if(mysqli_connect_error()){
    die('connect Error('.mysqli_connect_error().')'. mysqli_connect_error());
}
else{

  $result = mysqli_query($conn, "SELECT * FROM getlocation;");
  while ($row = mysqli_fetch_array($result)) {
    
    $tran["title"] = $row['title'];
    $tran["Address"]=$row['Address'];
     $tran['lat']=$row['lat'];
     $tran['lng']=$row['lng'];
    $tran['Description']=$row['Description'];
    array_push($reply, $tran);
    
  }
    // $test="mdsm,flm";
    // $Select="SELECT * FROM getlocation";
    // $stmt=$conn->prepare($Select);
    // $stmt->execute();
    // $stmt->store_result();
    // $userIDforWallet = $this->fetchAssocStatement($stmt);

    // $yy=$stmt->num_rows;
    echo json_encode($reply);
 

}
//     $value="value";
// $sql = $conn->prepare("Insert into location (name)
// values (:value)");
// $conn ->beginTransaction();
// $sql->execute(array(':value'=>$value));
 


?>
