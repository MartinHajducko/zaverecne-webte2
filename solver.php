<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';
include './client/partials/toast.php';
session_start();
$email;$id;$fullname;$name;$surname;
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {

    if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  
      $email = $_SESSION['email'];
      $id = $_SESSION['id'];
      $fullname = $_SESSION['fullname'];
      $name = $_SESSION['name'];
      $surname = $_SESSION['surname'];
    } else {
      // Ak pouzivatel prihlaseny nie je, presmerujem ho na hl. stranku.
      header('Location: index.php');
      exit;
    }
  }



//var_dump($_SESSION['user_first_name']);

// welcome message
$welcome = false;
if (isset($_SESSION['welcome'])) {
    $welcome = $_SESSION['welcome'];
    unset($_SESSION['welcome']);
}


$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

//var_dump($_SESSION);


?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include './client/partials/library.php'; ?>
    <title>Študent | Príklady</title>
    <link rel="stylesheet" href="./client/src/styles/dashboard.css">
    <style>
        table.table tr td:last-child {
		    width: 130px;
	    }
    </style>
</head>

<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Dashboard</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="form-control form-control-dark w-100 rounded-0 border-0 d-flex justify-content-end">
            <?php echo '<div style="font-size: 0.875rem;">Prihlásený ako <strong>' . $_SESSION['email'] . '</strong></div>' ; ?>
        </div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="logout.php">Odhlásiť sa</a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">
                                <span data-feather="users" class="align-text-bottom"></span>
                                Príklady
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                                Riešenie
                            </a>
                        </li>
                        <hr>
                    </ul>
                </div>
            </nav>

            <!-- Dashboard content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            
            <!-- Welcome message -->
            <?php 
            if ($welcome){
            echo '
            <div class="alert alert-primary alert-dismissible fade show mt-3" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <section class="py-1 text-center container">
                    <div class="row py-lg-5">
                        <div class="col-lg-6 col-md-8 mx-auto">
                            <h1 class="fw-light">Vitaj, <strong>' . $name . '</strong></h1>
                            <p class="lead text-muted">Tu vieš riešiť vybrané príklady.</p>

                        </div>
                    </div>
                </section>
            </div>'; 
            }
            ?>

                <!-- Title -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Nadpis</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <!-- <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                        </div> -->
                        <!-- Button na pridanie športovca (otvori modal) -->
                        <button class="btn btn-primary pull-right" type="button" data-bs-toggle="modal"
                                        data-bs-target="#addPerson"><i class="fa fa-plus"></i> Otvori modal</button>
                    </div>
                </div>


                <!-- Modal na pridanie športovca -->
                <div class="modal fade" id="addPerson" tabindex="-1" role="dialog" aria-labelledby="Pridanie Sportovca"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pridaj športovca</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="#" method="post">
                                    <div class="form-group">
                                        <label for="InputName" class="form-label">Meno:</label>
                                        <input type="text" name="name" class="form-control" id="InputName" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="InputSurname" class="form-label">Priezvisko:</label>
                                        <input type="text" name="surname" class="form-control" id="InputSurname"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="InputDate" class="form-label">Dátum narodenia:</label>
                                        <input type="date" name="birth_day" class="form-control" id="InputDate"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="InputbrPlace" class="form-label">Miesto narodenia:</label>
                                        <input type="text" name="birth_place" class="form-control" id="InputBrPlace"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="InputBrCountry" class="form-label">Krajina narodenia:</label>
                                        <input type="text" name="birth_country" class="form-control" id="InputBrCountry"
                                            required>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zrušiť</button>
                                <button type="submit" class="btn btn-primary">Uložiť</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row mx-2">
                    <div class="row"><?php
                    require_once('config.php');

                    $connection = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
                    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                    $currentDate = date('Y-m-d');

                    // Retrieve data from the database
                    $query = "SELECT DISTINCT latexFile, canGenerate FROM equation WHERE date = :currentDate";
                    $stmt = $connection->prepare($query);
                    $stmt->bindParam(':currentDate', $currentDate);
                    $stmt->execute();
                    $data = $stmt->fetchAll();
                    ?>
                    <form action="solver.php" method="post">
                    <?php
                    // Generate checkboxes based on the canGen column
                    foreach ($data as $row) {
                        $file = $row['latexFile'];
                        $canGen = $row['canGenerate'];
                        if ($canGen == 1) {
                            echo '<input type="checkbox" name="files[]" value="' . $file . '">' . $file . '<br>';
                        }
                    }
                    ?>
                    <button type="submit">Generuj</button>
                    </form>
                    </div>
                </div>
                <!-- Content -->
                <div class="row mx-2 mb-5">
                    <div class="row equation_assign">
                    <?php
                    $query = "SELECT question, latexFile, task, imageTask FROM equation"; // Replace your_table_name with the actual table name

                    $stmt = $connection->query($query);

                    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Check if any checkboxes were selected
                        if (isset($_POST['files'])) {
                            // Get the selected checkbox values
                            $selectedFiles = $_POST['files'];

                            // Iterate through the data and print rows where latexFile matches the selected checkbox values
                            foreach ($data as $row) {
                                $latexFile = $row['latexFile'];
                                $task = $row['task'];
                                $image = $row['imageTask'];
                                $question = $row['question'];

                                if (in_array($latexFile, $selectedFiles)) {
                                    if ($task !== null) {
                                        echo "Question: $question<br>";
                                        echo "Task: $task<br>";
                                    } else if($image != null){
                                        echo "Question: $question<br>";
                                        $fileName = basename($image);
                                        echo "<img src=\"$fileName \"><br>";
                                    }
                                }
                            }
                        }
                    } 
                    ?>
                    </div>
                    
                    <div class="row equation_answer">
                        <label>Mathfield</label>
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
                    </div>
                    <button id="check">Odoslať odpoveď</button>
                    
                </div>
                

                
            </main>
        </div>
    </div>
    <?php
        /* if ($person_saved) { toast('Športovec bol pridaný.','ok'); }
        elseif(!$person_saved && $person_add){ toast('Chyba! Športovec sa už v databáze nachádza', 'error');}

        if ($person_deleted) { toast('Športovec bol vymazaný.', 'ok'); } */
        //if ($placing_edit){ toast('Chyba! Rovnaké umiestnenie sa už v databáze nachádza.', 'error'); } 
    ?>
    
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        const mf = document.getElementById("formula");
        const latex = document.getElementById("latex");

        mf.addEventListener("input", (val) => {
            console.log(val.target.value);
        });

        document.getElementById('check').addEventListener('click', function() {
        const userAnswer = mf.value;

        fetch('check_answer.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'userAnswer=' + encodeURIComponent(userAnswer)
        })
        .then(response => response.text())
        .then(data => {
            if (data === 'correct') {
                console.log('Correct!');
            } else {
                console.log('Incorrect!');
            }
        })
        .catch((error) => {
        console.error('Error:', error);
        });
        });

    </script>
</body>

</html>
