<?php
if (isset($_POST['register_type'])) {
    $register_type = $_POST['register_type'];
    
    if ($register_type === 'admin') {
        header("Location: admin_register.html");
        exit();
    } elseif ($register_type === 'user') {
        header("Location: user_register.html");
        exit();
    }
} else {
    header("Location: register_choice.html");
    exit();
}
?>
