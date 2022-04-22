<?php

// const HOST = "localhost", USERNAME = "root", PASSWORD = "", DATABASE_NAME = "scheduler";

// $db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE_NAME);

// echo $db;

//! Fetch all records from Tasks Table

$data = array(
    array(
        "id" => 1,
        "title" => "T1",
        "body" => "B1",
        "create_date" => "2021-11-01",
        "finishing_date" => "2022-11-01",
        "is_pending" => true
    ),
    array(
        "id" => 2,
        "title" => "T2",
        "body" => "B2",
        "create_date" => "2021-11-01",
        "finishing_date" => "2022-11-01",
        "is_pending" => false
    ),
    array(
        "id" => 3,
        "title" => "T3",
        "body" => "B3",
        "create_date" => "2021-11-01",
        "finishing_date" => "2022-11-01",
        "is_pending" => false
    ),
    array(
        "id" => 4,
        "title" => "T4",
        "body" => "B4",
        "create_date" => "2021-11-01",
        "finishing_date" => "2022-11-01",
        "is_pending" => true
    ),
    array(
        "id" => 5,
        "title" => "T5",
        "body" => "B5",
        "start_date" => "2021-11-01",
        "finishing_date" => "2022-01-01",
        "is_pending" => false
    ),
);

$show_error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //! Insert in Tasks Table

    array_push($data, array(
        "id" => 6,
        "title" => $_POST["title"],
        "body" => $_POST["body"],
        "start_date" => date("Y-m-d"),
        "finishing_date" => $_POST["finishing_date"],
        "is_pending" => true
    ));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <title>Task Scheduler</title>
</head>

<body>

    <section>
        <form action="index.php" method="post">
            <h1 class="title">Create a New Task</h1>
            <input type="text" name="title" placeholder="Title">
            <textarea name="body" placeholder="Body"></textarea>
            <input type="date" name="finishing_date" min="<?php echo date("Y-m-d") ?>">
            <input type="submit" value="Add Task">
        </form>
        <main>
            <?php
            foreach ($data as $task) {
                $has_expired = strtotime(date("Y-m-d")) >= strtotime($task["finishing_date"]);
                $state = ($task["is_pending"] ? "pending" : "") . ($has_expired ? " expired" : "");
            ?>
                <div data-id="<?php echo $task["id"] ?>" class="<?php echo $state ?>">
                    <div class="tooltip-text"><?php echo "Task finishes at :\n" . $task["finishing_date"] ?></div>
                    <div class="content">
                        <h5><?php echo $task["title"] ?></h5>
                        <p><?php echo $task["body"] ?></p>
                    </div>
                    <div class="delete-action">
                        <img src="./icons8-delete.svg" alt="Delete">
                    </div>
                </div>
            <?php } ?>
        </main>
    </section>

    <script src="main.js"></script>
</body>

</html>
