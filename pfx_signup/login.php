<?php  

$u = $_POST['name'];
$e = $_POST['email'];
$p = $_POST['pass'];
$cp = $_POST['cpass'];
$plan = $_POST['plan'];
$type = $_POST['user']; 
$phone=$_POST['phn'];
$userSkypeID = $_POST['skype'];  

// for pfx user registeration
if($type=="SafePixel (Verify)" || $type=="SafePixel (Block)" || $type=="SafePixel Analytics" || $type=="SafeGateway" || $type=="SafeLink"){

    $hp = password_hash($p, PASSWORD_DEFAULT); // hashed password
    $bizid='0';
    $grpid='9999';
    $org='PufferFox';
    $supusr=0;
    $rw='R';

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "botman-mines";
    
    $conn = new mysqli($servername, $username, $password,$dbname);
    $conn->connect_error;

    $sql = "INSERT INTO t_mines_api_users (APIUSER_NAME, APIUSER_ORG, APIUSER_EMAIL, APIUSER_SKYPE, APIUSER_BIZID, APIUSER_GROUP_ID, APIUSER_SUPER_USER, APIUSER_PASSWORD, APIUSER_USER_RIGHTS) VALUES ('$u', '$org', '$e', '$userSkypeID' , '$bizid', '$grpid', '$supusr', '$hp', '$rw')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully\n";
      } else {
        echo "User with same email already exist, try another.";
        exit();
      }

    $sql = "SELECT APIUSER_ID FROM t_mines_api_users WHERE APIUSER_EMAIL=('$e')";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();
    $bizid = $row["APIUSER_ID"]+80000;

    $sql = "UPDATE t_mines_api_users SET APIUSER_BIZID=('$bizid') WHERE APIUSER_EMAIL=('$e')";
    $result = $conn->query($sql);

    echo "Welcome to pfx....id:",$bizid;

    $conn->close();
}
?>  
