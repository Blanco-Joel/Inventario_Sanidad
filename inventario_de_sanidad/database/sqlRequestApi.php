<?php
    //funcion para recuperar los datos de los usuarios
    $sql = "SELECT user_id,first_name, last_name, email, password, user_type,created_at 
    FROM users ";
    // DEVUELVE : 
    // user_id,
    // first_name,
    //  last_name,
    //  email,
    //  password,
    //  user_type,
    // created_at

    // --------------------------------------------------------------------
    // --------------------------------------------------------------------

    //funcion para crear usuario
    $first_name      = $conn->real_escape_string($data['first_name']);
    $last_name       = $conn->real_escape_string($data['last_name']);
    $email           = $conn->real_escape_string($data['email']);
    $password        = $conn->real_escape_string($data['password']);
    $hashed_password = $conn->real_escape_string($data['hashed_password']);
    $user_type       = $conn->real_escape_string($data['user_type']);
    $first_log       = $conn->real_escape_string($data['first_log']);
    $created_at      = $conn->real_escape_string($data['created_at']);

    $sql = "INSERT INTO USERS first_name, last_name, email, password, hashed_password, user_type, first_log, created_at
    VALUES ('$first_name','$last_name','$email','$password','$hashed_password','$user_type','$first_log','$created_at'";
    
    // --------------------------------------------------------------------
    // --------------------------------------------------------------------

    //funcion para dar de baja un usuario
    $user_id = $conn->real_escape_string($data['user_id']);

    $sql = "DELETE FROM Users WHERE user_id = '$user_id' CASCADE";

    // --------------------------------------------------------------------
    // --------------------------------------------------------------------

    // funcion para Cambiar contraseña usuario

    $user_id = $conn->real_escape_string($data['user_id']);
    $password = $conn->real_escape_string($data['password']);
    $hashed_password = $conn->real_escape_string($data['hashed_password']);

    $sql = "UPDATE users set password = '$password', hashed_password = '$hashed_password', first_log = 'true' WHERE user_id = '$user_id' ";

    // --------------------------------------------------------------------
    // --------------------------------------------------------------------

    // funcion para Cambiar contraseña usuario

    $sql = "SELECT materials.name, storages.units, storage_type FROM materials, storage WHERE storages.material_id = materials.material_id AND storage.units < storages.min_units ";

    // DEVUELVE : 
    // name
    // units
    // storage_type

?>
