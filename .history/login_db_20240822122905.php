<?php 
session_start();
include('connectdb.php');

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['usr']);
    $password = mysqli_real_escape_string($conn, $_POST['pwd']);

    if (empty($username)) {
        echo "<script>";
        echo "alert('Username ไม่ถูกต้อง');";
        echo "window.location.href='index.php';";
        echo "</script>";
    } elseif (empty($password)) {
        echo "<script>";
        echo "alert('Password ไม่ถูกต้อง');";
        echo "window.location.href='index.php';";
        echo "</script>";
    } else {
        $password = md5($password);
        $query = "
            SELECT e.*, r.role_name 
            FROM employees e 
            JOIN role r ON e.role_id = r.role_id 
            WHERE emp_user='$username' AND emp_pwd='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $data = mysqli_fetch_assoc($result); // Fetch the result as an associative array
            $_SESSION['username'] = $username;
            $_SESSION['aid'] = $data['emp_id']; // Store emp_id in session
            $_SESSION['aname'] = $data['emp_name']; // Store emp_name in session
            $_SESSION['role_id'] = $data['role_id']; // Store role_id in session
            $_SESSION['role_name'] = $data['role_name']; // Store role_name in session
    
            header("Location: homepage.php");
        } else {
            echo "<script>";
            echo "alert('Wrong username or password');";
            echo "window.location.href='index.php';";
            echo "</script>";
        }
    }
}
?>
