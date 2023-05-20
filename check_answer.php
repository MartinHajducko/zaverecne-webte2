<?php
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

function removeFormatting($latex) {
    // Remove whitespace and line breaks
    $latex = str_replace([' ', "\n", "\r"], '', $latex);
    
    // Remove formatting commands
    $latex = preg_replace('/\\\(.*?\\\)/', '', $latex);
    
    // Normalize fraction commands
    $latex = str_replace(['\dfrac', '\frac'], '\frac', $latex);
    
    return $latex;
}

try {
    $connection = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!isset($_POST['userAnswer'], $_POST['taskId'])) {
        throw new Exception('POST data is missing');
    }

    $userAnswer = $_POST['userAnswer'];
    $userAnswer = removeFormatting($userAnswer);
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
    $correctAnswer = removeFormatting($correctAnswer);

    // Execute the Python script to compare expressions
    $command = escapeshellcmd('python3 /var/www/site100.webte.fei.stuba.sk/zaverecne/compare.py ' . escapeshellarg($userAnswer) . ' ' . escapeshellarg($correctAnswer));
    $result = shell_exec($command);

    // Execute the Python script to simplify expressions
    $command = 'python3 /var/www/site100.webte.fei.stuba.sk/zaverecne/simplify.py ' . escapeshellarg($userAnswer) . ' ' . escapeshellarg($correctAnswer);
    $output = [];
    exec($command, $output);

    // Extract the simplified expressions from the output
    $simplifiedUserAnswer = $output[0] ?? null;
    $simplifiedCorrectAnswer = $output[1] ?? null;


    $response = array(
        "userAnswer" => $userAnswer,
        "correctAnswer" => $correctAnswer,
        "conversion" => $result,
        "simplifiedUserAnswer" => $simplifiedUserAnswer,
        "simplifiedCorrectAnswer" => $simplifiedCorrectAnswer,
    );

    if ($correctAnswer === $userAnswer) {
        $response["result"] = "correct";
    } else {
        $response["result"] = "incorrect";
    }

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
}
ob_end_clean();
echo json_encode($response);
?>




