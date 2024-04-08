<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'kreative_interview');
if (!isset($_SESSION['auth'])) {
    header('Location: Q4_UserRegistration.php');
}
$user_id = $_SESSION['auth']['user_id'];
if (isset($_POST['operation'])) {
    $operation = $_POST['operation'];
    if ($operation == 'logout') {
        session_unset();
        session_destroy();
        header('Location: Q4_UserRegistration.php');
    } else if ($operation == 'delete_user') {
        $user_id_delete = $_POST['user_id'];
        $update_sql = "DELETE FROM users WHERE id ='$user_id_delete'";
        mysqli_query($conn, $update_sql);
        if ($user_id == $user_id_delete) {
            session_unset();
            session_destroy();
            header('Location: Q4_UserRegistration.php');
        }
    } else {
        $name = $_POST['name'];
        $user_id = $_POST['user_id'];
        $update_sql = "UPDATE users SET name = '$name' WHERE id ='$user_id'";
        mysqli_query($conn, $update_sql);
        echo 'Success';
    }

    exit;
}



$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$user_type = $row['user_type'];
$user_typeAr = array('U' => 'User', 'A' => 'Admin');
$trows = '';
if ($user_type == 'U') {
    $trows = '<tr>
        <td><input value="' . $row['name'] . '" user_id="' . $row['id'] . '" class="update_name"></td>
        <td>' . $row['email'] . '</td>

        <td>' . $user_typeAr[$user_type] . '</td>
        <td>   <form action="Q4_UserView.php" method="post"  onsubmit="return validate_form()">
            <input type="hidden" name="operation" value="delete_user">
            <input type="hidden" name="user_id" value="' . $row['id'] . '">
            <button>Delete</button>
         </form>
        </td>
     </tr>
   ';
} else {
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        if ($user_type == 'A') {
            $update_name = '<input value="' . $row['name'] . '" user_id="' . $row['id'] . '" class="update_name">';
        } else {
            $update_name = $row['name'];
        }
        $trows .= '<tr>
                <td>' . $update_name . '</td>
                <td>' . $row['email'] . '</td>

                <td>' . $user_typeAr[$user_type] . '</td>
                <td>
                <form action="Q4_UserView.php" method="post" onsubmit="return validate_form()">
                    <input type="hidden" name="operation" value="delete_user">
                    <input type="hidden" name="user_id" value="' . $row['id'] . '">
                    <button>Delete</button>
                </form>
                </td>
            </tr>
        ';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap5/css/bootstrap.min.css">
    <title>User Registration & Login</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="Q4_UserView.php" method="post">
                    <input type="hidden" name="operation" value="logout">
                    <button>Logout</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Press Enter to update</th>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User type</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        echo $trows;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
<script src="jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.update_name').on('keypress keydown', function(e) {
            if (e.which == 13 || e.keyCode == 13) {
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "Q4_UserView.php",
                    data: {
                        'user_id': $(this).attr('user_id'),
                        'name': $(this).val(),
                        'operation': 'update_name'
                    },
                    success: function(response) {
                        alert(response);
                    }
                });

            }

        });
    });

    function validate_form() {
        if (!window.confirm("Are you sure want to delete?")) {
            return false;
        }
    }
</script>