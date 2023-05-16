<?php
require_once('config.php');

$connection = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$userAnswer = $_POST['userAnswer'];

$query = "SELECT solution FROM equation WHERE latexFile = :latexFile";
$stmt = $connection->prepare($query);
$stmt->bindParam(':latexFile', $latexFile);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$correctAnswer = $row['solution'];

// Removing the \begin{equation*} and \end{equation*} from the correct answer
$correctAnswer = str_replace(['\begin{equation*}', '\end{equation*}'], '', $correctAnswer);
$correctAnswer = trim($correctAnswer); // remove leading and trailing spaces

if ($userAnswer === $correctAnswer) {
    echo 'correct';
} else {
    echo 'incorrect';
}
