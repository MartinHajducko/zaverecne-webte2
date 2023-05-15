
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
    $thePath = '/var/www/site112.webte.fei.stuba.sk/zaverecne-zadanie/odozva02pr.tex';
    $latexContent = file_get_contents($thePath);
    $latexName = basename($thePath);

    $fileExtension = pathinfo($thePath, PATHINFO_EXTENSION);
    if ($fileExtension === 'tex') {

    // Process tasks and solutions
    $taskPattern = '/\\\\begin\{task\}(.*?)\\\\end\{task\}/s';
    $solutionPattern = '/\\\\begin\{solution\}(.*?)\\\\end\{solution\}/s';
    $imagePattern = '/\\\\includegraphics\{(.*?)\}/';

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
                $sql = "INSERT INTO equation (task, solution, latexFile) VALUES (:task, :solution, :latexFile)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':task', $taskEquation);
                $stmt->bindParam(':solution', $solutionEquation);
                $stmt->bindParam(':latexFile', $latexName);
                $stmt->execute();
        }
    }
} else {
    echo "No task content found in the LaTeX file or unequal number of tasks and solutions.";
}
    }
    elseif ($fileExtension === 'jpg') {
        // Process JPG file
        $fileName = basename($thePath);

        // Perform OCR on the image to extract text, including equations
        $command = "tesseract $thePath stdout";
        $output = shell_exec($command);

        echo "OCR Output: " . var_export($output, true) . PHP_EOL; // Debug statement


        // Extract equations from the OCR output
        $equationPattern = '/\\\\begin\{equation\*\}(.*?)\\\\end\{equation\*\}/s';
        preg_match_all($equationPattern, $output, $equationMatches, PREG_SET_ORDER);

        if (!empty($equationMatches)) {
            foreach ($equationMatches as $match) {
                $equationContent = $match[1];

                // Process the equation as needed

                // Insert the equation into the database
                $sql = "INSERT INTO equation (equation, latexFile) VALUES (:equation, :latexFile)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':equation', $equationContent);
                $stmt->bindParam(':fileName', $fileName);
                $stmt->execute();
            }
        } else {
            echo "No equation content found in the image.";
        }
    } else {
        echo "Unsupported file type.";
    }

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    }
    


?>
