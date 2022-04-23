<?php

const HOST = "localhost", USERNAME = "root", PASSWORD = "", DATABASE_NAME = "scheduler";

const INSERT_MUTATION = "INSERT INTO tasks(title, body, finishing_date) VALUES (?, ?, ?);";
const SELECT_QUERY = "SELECT * FROM tasks";

$db = new mysqli(HOST, USERNAME, PASSWORD, DATABASE_NAME);

if ($db->connect_error)
    die("Connection failed: " . $db->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $insert_stmt = $db->prepare(INSERT_MUTATION);
    $insert_stmt->bind_param("sss", $title, $body, $finishing_date);

    $title = $_POST["title"];
    $body = $_POST["body"];
    $finishing_date = $_POST["finishing_date"];

    if ($insert_stmt->execute() === false)
        die("Failed to Insert a new Task\n" . $insert_stmt->error);

    $insert_stmt->close();
}

$result = $db->query(SELECT_QUERY);

$dataset = array();
while ($row = $result->fetch_assoc()) {
    $row["create_date"] = date("Y-m-d", strtotime($row["create_date"]));
    $row["finishing_date"] = date("Y-m-d", strtotime($row["finishing_date"]));
    array_push($dataset, $row);
}

$db->close();

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
            foreach ($dataset as $task) {
                $has_expired = strtotime(date("Y-m-d")) >= strtotime($task["finishing_date"]);
                $state_classes = ($task["is_pending"] ? "pending" : "") . ($has_expired ? " expired" : "");
            ?>
                <div data-id="<?php echo $task["id"] ?>" class="<?php echo $state_classes ?>">
                    <div class="tooltip-text">
                        <?php
                        echo "Task started at : " . $task["create_date"] . "\n";
                        echo $has_expired ? "Task expired at : " : "Task finishes at : ";
                        echo $task["finishing_date"]
                        ?>
                    </div>
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
