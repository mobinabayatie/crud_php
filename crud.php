<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
</head>
<body>

    <div class="container my-5">
            <h2>Search Clients</h2>
            <input type="text" id="search" class="form-control" placeholder="Search clients by name or email">
            <br>
            <div id="result"></div>
        </div>

        <script>
            $(document).ready(function() {
                $('#search').on('keyup', function() {
                    var query = $(this).val();
                    if (query !== '') {
                        $.ajax({
                            url: "search.php",
                            method: "POST",
                            data: { query: query },
                            success: function(data) {
                                $('#result').html(data);
                            }
                        });
                    } else {
                        $('#result').html('');
                    }
                });
            });
        </script>
    </body>
    <div class="container my-5">
        <h2>list of clients</h2>
        <a  class="btn btn-primary" href="/test/create.php" role="button">new client</a>
         <br>
         <table class="table">
          <thead>
            <tr>
                <th>ID</th>
                <th>FIRSTNAME</th>
                <th>LASTNAME</th>
                <th>PHONE</th>
                <th>EMAIL</th>
                <th>CREATED AT</th>
                <th>ACTION</th>

            </tr>
          </thead>
            <TBody>
                <?php 
                $servername = "localhost";
                $username = "mobina";
                $password = "80838083";
                $dbname = "my_shop";

                $connection  = new mysqli($servername, $username, $password,$dbname);
                 if ($connection->connect_error){
                    die("connection failed".$connection->connect_error);
                 }echo "Connected successfully";

                 $sql="SELECT * FROM clients";
                 $result=$connection->query($sql);
                 if (!$result){
                    die("query failed".$connection->error);
                 }


                while($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['first_name'] . "</td>
                            <td>" . $row['last_name'] . "</td>
                            <td>" . $row['phone_number'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['created_at'] . "</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='/test/edit.php?id=$row[id]'>Edit</a> 
                                <a class='btn btn-primary btn-sm' href='/test/delete.php?id=$row[id]'>Delete</a> 
                            </td>
                        </tr>
                        ";
                    }
                    $connection->close();


                ?>
               
            </TBody>
         </table>
    </div>
</body>
</html>