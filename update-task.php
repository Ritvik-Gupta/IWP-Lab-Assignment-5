<?php

if ($_SERVER["REQUEST_METHOD"] != "POST") http_response_code(400);

$task_id = $_POST["taskId"];
$will_be_pending = $_POST["willBePending"];

//! Update Task Pending State in the Table
