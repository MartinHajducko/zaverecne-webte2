<?php
// specify the directory
$dir = 'client/media/latex/';

// open specified directory and walk through the filenames
$files = glob($dir . "*.tex");

$tasksAndSolutions = [];

foreach ($files as $file) {
    $content = file_get_contents($file);

    // Split the content into sections
    $sections = explode("\section*", $content);

    foreach ($sections as $section) {
        // Skip if section does not contain task or solution
        if (!strpos($section, 'task') || !strpos($section, 'solution')) {
            continue;
        }

        // Extract task and solution
        $taskStart = strpos($section, '\begin{task}');
        $solutionStart = strpos($section, '\begin{solution}');

        $taskEnd = strpos($section, '\end{task}', $taskStart) + 10;
        $solutionEnd = strpos($section, '\end{solution}', $solutionStart) + 14;

        $task = trim(substr($section, $taskStart, $taskEnd - $taskStart));
        $solution = trim(substr($section, $solutionStart, $solutionEnd - $solutionStart));

        // Skip if task or solution is empty
        if (empty($task) || empty($solution)) {
            continue;
        }

        // Extract equation from task and solution
        preg_match('/\$([^$]*)\$/', $task, $taskMatches);
        preg_match('/\$([^$]*)\$/', $solution, $solutionMatches);

        $taskEquation = $taskMatches[1] ?? '';
        $solutionEquation = $solutionMatches[1] ?? '';

        $tasksAndSolutions[] = [
            'task' => $task,
            'taskEquation' => $taskEquation,
            'solution' => $solution,
            'solutionEquation' => $solutionEquation,
        ];
    }
}echo '<script>console.log(' . json_encode($tasksAndSolutions) . ')</script>';
?>