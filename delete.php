<?php

include 'connection.php';


if (isset($_GET['delete_id'])) {


    $id_to_delete = $_GET['delete_id'];


    $sql = "DELETE FROM inventory WHERE id = $id_to_delete";

    if ($conn->query($sql) === TRUE) {

        header("Location: inventory.php");
        exit();
    } else {
        echo "Delete karne me dikkat aayi: " . $conn->error;
    }
}
