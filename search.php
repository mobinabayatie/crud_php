<?php
$servername = "localhost";
$username = "mobina";
$password = "80838083";
$dbname = "my_shop";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if (isset($_POST['query'])) {
    $query = $_POST['query'];

    $sql = "SELECT * FROM clients WHERE first_name LIKE '%$query%' OR last_name LIKE '%$query%' OR email LIKE '%$query%'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        echo "<table class='table'>";
        echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
              </thead>";
        echo "<tbody>";
        
        while ($row = $result->fetch_assoc()) {
            echo "
            <tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['first_name'] . "</td>
                <td>" . $row['last_name'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['phone_number'] . "</td>
            </tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No clients found</p>";
    }
}

$connection->close();
?>
