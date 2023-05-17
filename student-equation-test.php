<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

$connection = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();

$query = "SELECT question, latexFile, task, imageTask FROM equation"; // Replace your_table_name with the actual table name
$stmt = $connection->query($query);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if any checkboxes were selected
    if (isset($_POST['files'])) {
        // Get the selected checkbox values
        $selectedFiles = $_POST['files'];
        $_SESSION['selected_files'] = $selectedFiles;
    }
    $_SESSION['current_task_index']++;
}

$currentTaskIndex = $_SESSION['current_task_index'] ?? 0;

if ($currentTaskIndex < count($data)) {
    $row = $data[$currentTaskIndex];
    $latexFile = $row['latexFile'];
    $task = $row['task'];
    $image = $row['imageTask'];
    $question = $row['question'];

    if (in_array($latexFile, $_SESSION['selected_files'])) {
        if ($task !== null) {
            echo "Question: $question<br>";
            echo "Task: $task<br>";
        } else if ($image != null) {
            echo "Question: $question<br>";
            $fileName = basename($image);
            echo "<img src=\"$fileName\"><br>";
            ?>
            <form method="post">
                <label for="lname">Last name:</label><br>
                <input type="text" id="lname" name="lname"><br>
                <input type="submit" value="Submit">
            </form>
            <?php
        }
    }
} else {
    echo "No more tasks available.";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
</head>
<body>

</body>
</html>