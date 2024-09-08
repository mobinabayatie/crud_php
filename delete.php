<?php 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $servername = "localhost";
    $username = "mobina";
    $password = "80838083";
    $dbname = "my_shop";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "DELETE FROM clients WHERE id=$id";  

    if ($connection->query($sql) === TRUE) {
        
        header("Location: /test/crud.php");
        exit;
    } else {
        echo "Error: " . $connection->error;
    }

    $connection->close();
} else {
    header("Location: /test/crud.php");
    exit;
}
?>
