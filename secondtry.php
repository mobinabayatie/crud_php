<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            background-color:  #D6EEEE;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: rgba(255, 255, 128, .5);
        }
    </style>
</head>
<body>
<h2>Insert New Record</h2>
<form method="post" action="">
    First name:<br>
    <input type="text" name="firstname" required><br>
    Last name:<br>
    <input type="text" name="lastname" required><br>
    E-mail:<br>
    <input type="email" name="email" required><br>
    Phone number:<br>
    <input type="text" name="phonenumber"><br><br>
    <input type="submit" value="Submit">
</form>

<?php
$servername = "localhost";
$username = "mobina";
$password = "80838083";
$dbname = "test2";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['id'])) {
            $sql = "UPDATE USERS SET firstname = :firstname, lastname = :lastname, email = :email, phonenumber = :phonenumber WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $_POST['id']);
        } else {
            $sql = "INSERT INTO USERS (firstname, lastname, email, phonenumber) VALUES (:firstname, :lastname, :email, :phonenumber)";
            $stmt = $conn->prepare($sql);
        }
        
        $stmt->bindParam(':firstname', $_POST['firstname']);
        $stmt->bindParam(':lastname', $_POST['lastname']);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':phonenumber', $_POST['phonenumber']);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $stmt = $conn->prepare("DELETE FROM USERS WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $stmt = $conn->query("SELECT id, firstname, lastname, email, phonenumber FROM USERS");
    $users = $stmt->fetchAll();

    if (count($users) > 0) {
        echo "<h2>Users List</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>Actions</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['id']) . "</td>";
            echo "<td>" . htmlspecialchars($user['firstname']) . "</td>";
            echo "<td>" . htmlspecialchars($user['lastname']) . "</td>";
            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
            echo "<td>" . htmlspecialchars($user['phonenumber']) . "</td>";
            echo "<td>";
            echo "<a href='?edit=" . $user['id'] . "'>Edit</a> | ";
            echo "<a href='?delete=" . $user['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No records found.";
    }

    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM USERS WHERE id=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            echo "<script>
                document.querySelector('[name=firstname]').value = '" . htmlspecialchars($user['firstname']) . "';
                document.querySelector('[name=lastname]').value = '" . htmlspecialchars($user['lastname']) . "';
                document.querySelector('[name=email]').value = '" . htmlspecialchars($user['email']) . "';
                document.querySelector('[name=phonenumber]').value = '" . htmlspecialchars($user['phonenumber']) . "';
                var hiddenField = document.createElement('input');
                hiddenField.type = 'hidden';
                hiddenField.name = 'id';
                hiddenField.value = '" . htmlspecialchars($user['id']) . "';
                document.querySelector('form').appendChild(hiddenField);
            </script>";
        }
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
</body>
</html>
