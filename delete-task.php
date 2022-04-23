<?php

const HOST = "localhost", USERNAME = "root", PASSWORD = "", DATABASE_NAME = "scheduler";

const DELETE_MUTATION = "DELETE FROM tasks WHERE id  = ?;";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(400);
    die("Invalid Request Method");
}

$db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE_NAME);

if ($db->connect_error)
    die("Connection failed: " . $db->connect_error);

$delete_stmt = $db->prepare(DELETE_MUTATION);
$delete_stmt->bind_param("i", $task_id);

$task_id = $_POST["taskId"];

if ($delete_stmt->execute() === false) http_response_code(500);

$db->close();
