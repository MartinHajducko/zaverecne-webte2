
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
    $latexPath = 'odozva02pr.tex';
    $latexContent = file_get_contents($latexPath);
    $latexName = basename($latexPath);

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

            // Extract the image filenames
            preg_match_all($imagePattern, $taskContent, $taskImageMatches);
            preg_match_all($imagePattern, $solutionContent, $solutionImageMatches);

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

                // Process the image files
            if (!empty($taskImageMatches[1])) {
                foreach ($taskImageMatches[1] as $filename) {
                    // Load and process the task image file
                    // Implement your logic here based on your preferences
                    // For example, you can save the image file to a specific directory and store the filename in the database
                }
            }

            if (!empty($solutionImageMatches[1])) {
                foreach ($solutionImageMatches[1] as $filename) {
                    // Load and process the solution image file
                    // Implement your logic here based on your preferences
                    // For example, you can save the image file to a specific directory and store the filename in the database
                }
            }
        }
    }
} else {
    echo "No task content found in the LaTeX file or unequal number of tasks and solutions.";
}

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    }
    


?>