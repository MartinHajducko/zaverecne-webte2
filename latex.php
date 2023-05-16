
<?php
/*
try {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('config.php');

    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read and process the LaTeX file
    $latexContent = file_get_contents('odozva02pr.tex');

    // Process tasks and solutions
    $taskPattern = '/\\\\begin\{task\}(.*?)\\\\end\{task\}/s';
    $solutionPattern = '/\\\\begin\{solution\}(.*?)\\\\end\{solution\}/s';

    preg_match_all($taskPattern, $latexContent, $taskMatches, PREG_SET_ORDER);
    preg_match_all($solutionPattern, $latexContent, $solutionMatches, PREG_SET_ORDER);

    if (!empty($taskMatches) && !empty($solutionMatches) && count($taskMatches) === count($solutionMatches)) {
        for ($i = 0; $i < count($taskMatches); $i++) {
            $taskContent = $taskMatches[$i][1];
            $solutionContent = $solutionMatches[$i][1];

            // Extract the equation within the task content
            $equationPattern = '/\\\\begin\{equation\*\}(.*?)\\\\end\{equation\*\}/s';
            preg_match($equationPattern, $taskContent, $equationMatches);

            // Extract the equation within the solution content
            $solutionEquationPattern = '/\\\\begin\{equation\*\}(.*?)\\\\end\{equation\*\}/s';
            preg_match($solutionEquationPattern, $solutionContent, $solutionEquationMatches);

            if (isset($equationMatches[1]) && isset($solutionEquationMatches[1])) {
                $taskEquation = $equationMatches[1];
                $solutionEquation = $solutionEquationMatches[1];
                // Process the equations as needed

                // Insert the task and solution into the database
                $sql = "INSERT INTO equation (task, solution) VALUES (:task, :solution)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':task', $taskEquation);
                $stmt->bindParam(':solution', $solutionEquation);
                $stmt->execute();
            }
        }
    } else {
        echo "No task content found in the LaTeX file or unequal number of tasks and solutions.";
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
*/
?>
<?php

try {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once('config.php');

    $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read and process the LaTeX file

    $thePath = '/var/www/site112.webte.fei.stuba.sk/zaverecne-zadanie/blokovka01pr.tex';

    $latexContent = file_get_contents($thePath);
    $latexName = basename($thePath);

    $images = [];

    $fileExtension = pathinfo($thePath, PATHINFO_EXTENSION);
    if ($fileExtension === 'tex') {

        // Process tasks and solutions
        $taskPattern = '/\\\\begin\{task\}(.*?)\\\\end\{task\}/s';
        $solutionPattern = '/\\\\begin\{solution\}(.*?)\\\\end\{solution\}/s';

        preg_match_all($taskPattern, $latexContent, $taskMatches, PREG_SET_ORDER);
        preg_match_all($solutionPattern, $latexContent, $solutionMatches, PREG_SET_ORDER);

        if (!empty($taskMatches) && !empty($solutionMatches) && count($taskMatches) === count($solutionMatches)) {
            for ($i = 0; $i < count($taskMatches); $i++) {
                $taskContent = $taskMatches[$i][1];
                $solutionContent = $solutionMatches[$i][1];

                // Extract the equation within the task content
                $equationPattern = '/\\\\begin\{equation\*\}(.*?)\\\\end\{equation\*\}/s';
                preg_match($equationPattern, $taskContent, $equationMatches);

                // Extract the equation within the solution content
                $solutionEquationPattern = '/\\\\begin\{equation\*\}(.*?)\\\\end\{equation\*\}/s';
                preg_match($solutionEquationPattern, $solutionContent, $solutionEquationMatches);

                $regex = '/\\\\includegraphics{(.*?)}/';
                preg_match_all($regex, $taskContent, $matches);

                $imageLinks = $matches[1];

                foreach ($imageLinks as $link) {

                    $images[] = $link;
                }
                // Extract everything else except the equations from the task content
                $questionWithoutEquations = preg_replace($equationPattern, '', $taskContent);
                $questionWithoutEquations = preg_replace($regex, '', $taskContent);

                if (isset($equationMatches[1]) && isset($solutionEquationMatches[1])) {
                    $taskEquation = $equationMatches[1];
                    $solutionEquation = $solutionEquationMatches[1];
                    // Process the equations as needed

                    // Insert the task and solution into the database
                    $sql = "INSERT INTO equation (question, task, solution, latexFile) VALUES (:question, :task, :solution, :latexFile)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':question', $questionWithoutEquations);
                    $stmt->bindParam(':task', $taskEquation);
                    $stmt->bindParam(':solution', $solutionEquation);
                    $stmt->bindParam(':latexFile', $latexName);
                    $stmt->execute();
                } else {
                    // No equations found, add the image content as task
                    $sql = "INSERT INTO equation (question, task, solution, latexFile, imageTask) VALUES (:question, NULL, :solution, :latexFile, :imageTask)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':question', $questionWithoutEquations);
                    $stmt->bindParam(':solution', $solutionContent);
                    $stmt->bindParam(':latexFile', $latexName);
                    $stmt->bindParam(':imageTask', $images[$i]);
                    echo $images[$i];
                    $stmt->execute();
                }
            }
        } else {
            echo "No task content found in the LaTeX file or unequal number of tasks and solutions.";
        }
    } else {
        echo "Unsupported file type.";
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}




?>
