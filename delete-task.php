<?php

if ($_SERVER["REQUEST_METHOD"] != "POST") http_response_code(400);

$task_id = $_POST["taskId"];

//! Delete Task from the Table
