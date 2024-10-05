<?php
session_start(); // Start or resume session

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: home.php");
    exit; // Stop further execution
}

include 'config/dbconn.php'; // Include database connection
$msg = ""; // Initialize message variable

// Handle account verification if verification token is present in URL
if (isset($_GET['verification'])) {
    $verification_token = mysqli_real_escape_string($conn, $_GET['verification']);

    $query = "SELECT * FROM users WHERE verify_token=?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $verification_token);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Update verification token in database
            $update_query = "UPDATE users SET verify_token='' WHERE verify_token=?";
            $update_stmt = mysqli_prepare($conn, $update_query);

            if ($update_stmt) {
                mysqli_stmt_bind_param($update_stmt, "s", $verification_token);
                mysqli_stmt_execute($update_stmt);

                $msg = "<div class='alert alert-success'>Account verification has been successfully completed.</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Failed to update verification status.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Invalid verification token.</div>";
        }

        mysqli_stmt_close($stmt); // Close statement
    } else {
        $msg = "<div class='alert alert-danger'>Failed to execute verification query.</div>";
    }
}

// Handle form submission for login
if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $query = "SELECT * FROM users WHERE email=? AND password=?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (empty($row['verify_token'])) {
                $_SESSION['user_id'] = $row['id']; // Set user ID in session
                header("Location: home.php");
                exit; // Stop further execution
            } else {
                $msg = "<div class='alert alert-info'>Please verify your account to continue.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Email or password do not match.</div>";
        }

        mysqli_stmt_close($stmt); // Close statement
    } else {
        $msg = "<div class='alert alert-danger'>Failed to execute login query.</div>";
    }
}

mysqli_close($conn); // Close database connection
?>