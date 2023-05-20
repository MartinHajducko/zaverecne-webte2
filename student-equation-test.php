<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');

$connection = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT id as taskId, question, latexFile, task, imageTask FROM equation"; // Replace your_table_name with the actual table name

$stmt = $connection->query($query);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include './client/partials/library.php' ?>
    
</head>
<body>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if any checkboxes were selected
    if (isset($_POST['files'])) {
        // Get the selected checkbox values
        $selectedFiles = $_POST['files'];

        // Create an array to keep track of selected latexFiles
        $selectedLatexFiles = array();

        // Iterate through the data and print rows where latexFile matches the selected checkbox values
        foreach ($data as $row) {
            $latexFile = $row['latexFile'];
            $task = $row['task'];
            $taskId = $row['taskId'];
            $image = $row['imageTask'];
            $question = $row['question'];

            if (in_array($latexFile, $selectedFiles)) {
                // Check if the latexFile has already been selected
                if (!in_array($latexFile, $selectedLatexFiles)) {
                    $selectedLatexFiles[] = $latexFile; // Add the latexFile to the selected list

                    // Collect all the tasks for the current latexFile
                    $tasks = array();
                    foreach ($data as $taskRow) {
                        if ($taskRow['latexFile'] === $latexFile && $taskRow['task'] !== null) {
                            $tasks[] = $taskRow['task'];
                        }
                    }

                    if (!empty($tasks)) {
                        // Select a random task from the available tasks
                        $randomTask = $tasks[array_rand($tasks)];

                        echo "Question: $question<br>";
                        echo "Task: $randomTask<br>"; ?>
                        <div class="row">
                            <label>Odpoveď</label>
                            <math-field style="
                                font-size: 32px;
                                
                                padding: 8px;
                                border-radius: 8px;
                                border: 1px solid rgba(0, 0, 0, .3);
                                box-shadow: 0 0 8px rgba(0, 0, 0, .2);
                                --caret-color: blue;
                                --selection-background-color: lightgoldenrodyellow;
                                --selection-color: darkblue;
                                " id="formula"></math-field>
                            <button id="check" data-task-id="<?php echo $taskId; ?>">Odoslať odpoveď</button>
                            <!-- <label>v Latexe</label>
                            <textarea name="latex" id="latex" cols="30" rows="2"></textarea> -->
                        </div>
                        
                <?php
                    } else if ($image != null) {
                        echo "Question: $question<br>";
                        $fileName = basename($image);
                        echo "<img src='./client/media/images/$fileName'><br>";
                        ?>
                        <div class="row">
                            <label>Odpoveď</label>
                            <math-field style="
                                font-size: 32px;
                                
                                padding: 8px;
                                border-radius: 8px;
                                border: 1px solid rgba(0, 0, 0, .3);
                                box-shadow: 0 0 8px rgba(0, 0, 0, .2);
                                --caret-color: blue;
                                --selection-background-color: lightgoldenrodyellow;
                                --selection-color: darkblue;
                                " id="formula"></math-field>
                            <button id="check" data-task-id="<?php echo $taskId; ?>">Odoslať odpoveď</button>
                            <!-- <label>v Latexe</label>
                            <textarea name="latex" id="latex" cols="30" rows="2"></textarea> -->
                        </div>
                        
                        <?php
                    }

                    echo "<hr>"; // Add a horizontal line separator between tasks
                }
            }
        }
    }
}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>
        // Select all math-fields
        var mathFields = document.querySelectorAll('math-field');

        // Select all buttons with id "check"
        var checkButtons = document.querySelectorAll('#check');

        // Loop through math-fields and buttons to add event listeners
        for (var i = 0; i < mathFields.length; i++) {
            var mathField = mathFields[i];
            var button = checkButtons[i];

            // Get the taskId for the current task
            var taskId = button.dataset.taskId;
            //console.log(taskId);

            // Add an event listener to each button
            button.addEventListener('click', function(event) {
                var mf = event.target.parentNode.querySelector('math-field');
                var latex = event.target.parentNode.querySelector('textarea[name="latex"]');

                // Get the value of the corresponding math-field
                var userAnswer = mf.getValue();

                var alertDivs = document.querySelectorAll('.alert');
                alertDivs.forEach(function(alertDiv) {
                    alertDiv.remove();
                });

                fetch('check_answer.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'userAnswer=' + encodeURIComponent(userAnswer) + '&taskId=' + encodeURIComponent(taskId) // Use the taskId variable
                })
                .then(response => response.text()) // first get the raw response text
                .then(text => {
                    console.log('Raw response:', text); // log the raw response
                    return JSON.parse(text); // then try to parse it as JSON
                })
                .then(data => {
                    var alertDiv = document.createElement('div');
                    alertDiv.classList.add('alert');
                    if (data.result === 'correct') {
                        console.log('Correct!');
                        console.log(data); // Log the entire response object
                        alertDiv.classList.add('alert-success');
                        alertDiv.textContent = 'Správna odpoveď!';
                        // Hide the submit button for a correct answer
                        event.target.style.display = 'none';
                    } else {
                        console.log('Incorrect!');
                        console.log(data); // Log the entire response object
                        alertDiv.classList.add('alert-danger');
                        alertDiv.textContent = 'Neprávna odpoveď!';
                    }
                    // Append the alert div after the button
                    event.target.parentNode.appendChild(alertDiv);
                })
                .catch((error) => {
                console.error('Error:', error);
                });
            });

           
        }



    </script>
</body>
</html>