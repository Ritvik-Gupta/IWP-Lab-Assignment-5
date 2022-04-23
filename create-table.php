<?php

const HOST = "localhost", USERNAME = "root", PASSWORD = "", DATABASE_NAME = "scheduler";

const CREATE_TABLE_QUERY = "CREATE TABLE tasks(
    id INT(6) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
    title VARCHAR(30) NOT NULL,
    body VARCHAR(200) NOT NULL,
    create_date DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    finishing_date DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_pending TINYINT NOT NULL DEFAULT 1
);";


$db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE_NAME);

if ($db->connect_error)
    die("Connection failed: " . $db->connect_error);


if ($db->query(CREATE_TABLE_QUERY) === true)
    echo "Tasks Scheduler Table created successfully";
else
    echo "Error creating table: " . $db->error;

$db->close();
