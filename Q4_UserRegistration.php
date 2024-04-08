<?php
session_start();
$alert = '';
$name = '';
$email = '';
$password = '';
$phone = '';
$email_login = '';
$pass_login = '';
if (isset($_SESSION['alert'])) {
    $alert = '<div class="alert alert-' . $_SESSION['alert']['status'] . ' alert-sm">
        ' . $_SESSION['alert']['message'] . '
    </div>
    ';

    if (isset($_SESSION['alert']['name'])) {
        $name = $_SESSION['alert']['name'];
        $email = $_SESSION['alert']['email'];
        $phone = $_SESSION['alert']['phone'];
    } else if (isset($_SERVER['alert']['email_login'])) {
        $email_login = $_SESSION['alert']['email_login'];
    }
    unset($_SESSION['alert']);
} else if (isset($_SESSION['auth'])) {
    header('Location: Q4_UserView.php');
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
        <div class="row mt-2">
            <div class="col">
                <?php echo $alert; ?>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <h4>User Registration</h4>
            </div>
            <div class="col">
                <h4>User Login</h4>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <form action="Q4_UserRegistration.php" method="post">
                    <div class="form-group">
                        <label for="User Name">Name</label>
                        <input type="text" name="name" id="name" required placeholder="User name" class="form-control form-control-sm" value="<?php echo $name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" name="email" id="email" required placeholder="Email" class="form-control form-control-sm" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required placeholder="password" class="form-control form-control-sm">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="phone" name="phone" id="phone" required placeholder="phone" class="form-control form-control-sm" value="<?php echo $phone; ?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="operation" value="registration">
                        <button class="btn btn-sm btn-primary">Register</button>
                    </div>
                </form>
            </div>
            <div class="col">
                <form action="Q4_UserRegistration.php" method="post">
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" name="email_login" id="email_login" placeholder="Email" class="form-control form-control-sm" value="<?php echo $email_login; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="pass_login">Password</label>
                        <input type="password" name="pass_login" id="pass_login" placeholder="Password" class="form-control form-control-sm" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="operation" value="login">
                        <button class="btn btn-sm btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>

<?php
if (isset($_POST['operation'])) {
    $conn = new mysqli('localhost', 'root', '', 'kreative_interview');
    extract($_POST);
    if ($_POST['operation'] == 'login') {
        $pass_login = md5($pass_login);
        echo $sql = "SELECT id FROM users WHERE email = '$email_login' AND `password` = '$pass_login'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows == 0) {
            $_SESSION['alert'] = array(
                'status' => 'warning',
                'message' => 'Info ! User name or password is wrong',
                'email_login' => $email_login,
            );
            header('Location: Q4_UserRegistration.php');
        } else {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['auth'] = array(
                'username' => $email_login,
                'user_id' => $row['id'],
            );
            header('Location: Q4_UserView.php');
        }
    } else {
        $sql = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows == 0) {
            $password = md5($password);
            $sql_new = "INSERT INTO `users` (`name`, `password`, `email`, `user_type`, `phone`) 
            VALUES ('$name', '$password', '$email', 'U', '$phone')";
            mysqli_query($conn, $sql_new);
            $_SESSION['alert'] = array(
                'status' => 'success',
                'message' => 'Succesfully registered',
            );
        } else {
            $_SESSION['alert'] = array(
                'status' => 'warning',
                'message' => 'Info ! User already exist',
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'phone' => $phone,
            );
        }
        header('Location: Q4_UserRegistration.php');
    }
}

?>