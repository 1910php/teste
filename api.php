<?php

require_once 'src/config.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    global $conn;

    $sql = "SELECT * FROM user where email = '" . $_POST['email'] . "' limit 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        echo 1;
    } else {
        echo 0;
    }

} elseif (isset($_POST['acao']) && $_POST['acao'] === 'delete') {

    $id_user = $_POST['id_user'];

    $sql = "DELETE  FROM user where id_user = {$id_user} limit 1";
    $result = $conn->query($sql);

    // Executa a instrução SQL
    if ($conn->affected_rows > 0) {
        echo 1;
    } else {
        echo 0;
    }
}
