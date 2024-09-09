<?php 

$servername = "localhost";
$username = "mobina";
$password = "80838083";
$dbname = "my_shop";

$connection  = new mysqli($servername, $username, $password,$dbname);

$id="";
$first_name = "";
$last_name = "";
$email = "";
$phone_number = "";

$errormessage = "";
$successmessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (!isset($_GET['id'])){
        header("location: /test/crud.php");
        exit;
    }
    $id = $_GET['id'];
    
    
    $sql = "SELECT * FROM clients WHERE id = $id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
    
    if (!$row) {
        header("location: /test/crud.php");
        exit;
    }
    
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $phone_number = $row['phone_number'];
    

}else{
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];


    do{

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errormessage = "Invalid email format";
            break;
        }
        if (empty($first_name) || empty($last_name) || empty($email) || empty($phone_number|| empty($id))) {
            $errormessage = "Please enter all the fields";
            break;
        }
        $sql = "UPDATE clients SET first_name='$first_name', last_name='$last_name', email='$email', phone_number='$phone_number' WHERE id=$id";

        $result=$connection->query($sql);

        if (!$result){
            $errormessage="query failed".$connection->error;
            break;    
        }

        $successmessage = "client updated successfully";

        header("location: /test/crud.php");
        exit;


    }while(true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>New Client</h2>
        <?php 
        if (!empty($errormessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errormessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <<form action="" method="POST">
    <input type="hidden" name="id" value="<?php echo $id ;?>">
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">First Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="first_name" value="<?php echo $first_name ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Last Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="last_name" value="<?php echo $last_name ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="email" value="<?php echo $email ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Phone Number</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" name="phone_number" value="<?php echo $phone_number ?>">
        </div>
    </div>

    <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col-sm-3 d-grid">
            <a class="btn btn-outline-primary" href="/crud.php" role="button">Cancel</a>
        </div>
    </div>
</form>


            <?php 
            if (!empty($successmessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successmessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <!-- <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/crud.php" role="button">Cancel</a>
                </div>
            </div> -->
        </form>
    </div>
</body>
</html>
