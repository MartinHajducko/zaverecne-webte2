<?php

require_once('config.php');

$connection = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


session_start();

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if files are selected
    if (isset($_POST['files']) && is_array($_POST['files'])) {
        // Check if task index is set in session
        if (!isset($_SESSION['task_index'])) {
            // Initialize task index to 0
            $_SESSION['task_index'] = 0;
        } else {
            // Increment the task index
            $_SESSION['task_index']++;
        }
        
        // Retrieve the selected files
        $selectedFiles = $_POST['files'];
        
        // Check if task index is within the range of selected files
        if ($_SESSION['task_index'] < count($selectedFiles)) {
            // Get the file at the current task index
            $currentFile = $selectedFiles[$_SESSION['task_index']];
            
            // Prepare the query to retrieve the task for the current file
            $query = "SELECT task FROM equation WHERE latexFile = :file";
            
            // Execute the query
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':file', $currentFile);
            $stmt->execute();
            
            // Fetch the result
            $task = $stmt->fetch(PDO::FETCH_COLUMN);

            // Print the task
            if ($task) {
                echo "Task #" . ($_SESSION['task_index'] + 1) . ": " . $task . "<br>";
                // Display the answer form
                echo '<form method="post" action="">';
                echo 'Answer: <input type="text" name="answer" required>';
                echo '<input type="submit" value="Submit">';
                echo '</form>';
            } else {
                echo "No matching task found for file: " . $currentFile;
            }
        } else {
            echo "No more tasks.";
        }
    } else {
        echo "No files selected.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Reset task index on a new session or when navigating back to the initial page
    if (!isset($_SESSION['task_index']) || empty($_GET['reset'])) {
        $_SESSION['task_index'] = 0;
    }
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