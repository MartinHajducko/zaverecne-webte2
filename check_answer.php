<?php
require_once('config.php');

$connection = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userAnswer = $_POST['userAnswer'];
$taskId = $_POST['taskId'];

$query = "SELECT solution FROM equation WHERE id = :taskId";
$stmt = $connection->prepare($query);
$stmt->bindParam(':taskId', $taskId);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$correctAnswer = $row['solution'];

// Removing the \begin{equation*} and \end{equation*} from the correct answer
$correctAnswer = str_replace(['\begin{equation*}', '\end{equation*}'], '', $correctAnswer);
$correctAnswer = trim($correctAnswer); // remove leading and trailing spaces

$response = array(
    "task" => $task,
    "userAnswer" => $userAnswer,
    "correctAnswer" => $correctAnswer
);

if ($userAnswer === $correctAnswer) {
    $response["result"] = "correct";
} else {
    $response["result"] = "incorrect";
}

echo json_encode($response);
?>
