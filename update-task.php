<?php

const HOST = "localhost", USERNAME = "root", PASSWORD = "", DATABASE_NAME = "scheduler";

const UPDATE_MUTATION = "UPDATE tasks SET is_pending = ? WHERE id  = ?;";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(400);
    die("Invalid Request Method");
}

$db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE_NAME);

if ($db->connect_error)
    die("Connection failed: " . $db->connect_error);

$update_stmt = $db->prepare(UPDATE_MUTATION);
$update_stmt->bind_param("ii", $task_id, $will_be_pending);

$task_id = $_POST["taskId"];
$will_be_pending = $_POST["willBePending"];

if ($update_stmt->execute() === false) http_response_code(500);

$db->close();
