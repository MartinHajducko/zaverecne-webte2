<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

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


?>
<!doctype html>
<html lang="sk">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <title>Zabezpečená stránka</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="icon" type="image/x-icon" href="./client/media/logos/favicon.jpg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <link rel="stylesheet" href="./client/src/styles/styles.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>

  <nav class="navbar navbar-expand-md navbar-light justify-content-center page-navbar">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="page-logo-container">
          <img class="page-logo" src="./client/media/logos/logo.png" alt="logo">
        </div>
        <div class="collapse navbar-collapse justify-content-center flex-grow-unset" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item mr-5">
              <a class="nav-link" href="./logout.php">Domov</a>
            </li>
            <li class="nav-item mr-5">
              <a class="nav-link" href="./game.php">Návod</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./login.php">Prihlásenie</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./logout.php">Odhlásiť</a>
            </li>
          </ul>
          <ul class="navbar-nav language-switcher">
            <li class="nav-item mr-5">
              <a href="./restricted-student.php" class="language-flag"><img src="https://flagcdn.com/48x36/sk.png" alt="Slovak"></a>
              <a href="./restricted-student-en.php" class="language-flag"><img src="https://flagcdn.com/48x36/gb.png" alt="English"></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

</head>

<body>
<style>
 
    .custom-button {
        display: block;
        margin-top: 10px;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        background-color: #4CAF50;
        color: #FFFFFF;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .custom-button:hover {
        background-color: #45a049;
    }
</style>
<style>
    /* Skryť vstavané šípky v poli typu date */
    input[type="date"]::-webkit-inner-spin-button,
    input[type="date"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Vlastné štýly pre vstup typu date */
    .custom-date-input {
        display: inline-block;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: none;
        transition: border-color 0.3s;
    }

    .custom-date-input:focus {
        border-color: #4CAF50;
        outline: none;
    }
</style>


<style>
    /* Skryť predvolený vzhľad checkboxu */
    input[type="checkbox"] {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        outline: none;
        border: none;
        cursor: pointer;
        position: relative;
        display: inline-block;
        width: 18px;
        height: 18px;
        vertical-align: middle;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s, border-color 0.3s, box-shadow 0.3s;
    }

    /* Vlastné štýly pre checkbox */
    input[type="checkbox"]:checked {
        background-color: #4CAF50;
    }

    input[type="checkbox"]:checked:before {
        content: "\2713";
        display: block;
        color: #fff;
        text-align: center;
        font-size: 14px;
        line-height: 18px;
    }
</style>

<style>
table {
  width: 80%; 
  margin: 0 auto; 
  border-collapse: collapse; 
  margin-top: 50px;
}

table th, table td {
  padding: 8px; 
  border: 1px solid #ccc; 
}

table th {
  background-color: #f2f2f2; 
}

table tr:nth-child(even) {
  background-color: #f9f9f9; 
}

table tr:hover {
  background-color: #e3e3e3;
}

.center {
  text-align: center; 
  margin-top: 20px;
}


.custom-button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        background-color: #ccc;
        color: #222;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .custom-button:hover {
        background-color: #f9f9f9;
    }
</style>

  <main>




   
      <main class=page-wrapper>
    <div class="card card-wrapper">
   
      <div class="card-description-container card-body">
      <div class="container">



          <p class="ellipsis">
          <h1 class="nazov">Vitaj student <?php echo $_SESSION['fullname']; ?></h1>
          <br>
          <p class="text">
          </p>
          </p>
          
        </div>
      </div>

   
      <?php

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
<form action="student-equation-test.php" method="post">
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
  <button type="submit" class="custom-button">Go to Page</button>
</form>

      </div>
    </div>
  </main>

  <footer id="footer-section">
    <div id="max-width-footer">
      <div class="footer-info">
        <p>Samuel Michalčík</p>
        <p>Jakub Taňkoš</p>
        <p>Tomáš Jenčík</p>
        <p>Martin Hajdučko</p>
      </div>
      <div id="icon-container">
        <img id="footer-icon" src="./client/media/logos/favicon.jpg" alt="Logo"></img>
      </div>
      <div class="footer-info">
        <address>
          <ul>
            <li class="footer-contact-item"><a class="footer-contact-link" href="mailto:xmichalciks@stuba.sk">xmichalciks@stuba.sk</a></li>
            <li class="footer-contact-item"><a class="footer-contact-link" href="mailto:xtankos@stuba.sk">xtankos@stuba.sk</a></li>
            <li class="footer-contact-item"><a class="footer-contact-link" href="mailto:xjencikt@stuba.sk">xjencik@stuba.sk</a></li>
            <li class="footer-contact-item"><a class="footer-contact-link" href="mailto:xhajducko@stuba.sk">xhajducko@stuba.sk</a></li>
          </ul>
        </address>
      </div>
    </div>
  </footer>
  <footer id="footer-bar">
    <p>&copy; 2023 MATHEX </p>
  </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script src="./client/src/js/script.js"></script>
      <br><br>
     
     



  </main>
 

</body>



</html>