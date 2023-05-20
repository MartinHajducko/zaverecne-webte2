<?php

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
<?php
require_once('config.php');
try {
  $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $query = "SELECT id, fullname, email, login FROM users WHERE user_type = 'student';  ";
  
  $stmt = $db->query($query); 
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  echo $e->getMessage();
}

// Export do CSV
if (isset($_POST['export_csv'])) {
    $filename = 'export.csv';
    
    // Zabezpečenie, aby bol súbor vygenerovaný a stiahnutý
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Pragma: no-cache');
    header('Expires: 0');
    
    $output = fopen('php://output', 'w');
    
    // Hlavička CSV súboru
    fputcsv($output, array('ID', 'First Name', 'Last Name', 'Email', 'Login'));
    
    // Dáta z tabuľky
    foreach ($results as $row) {
        // Rozdelenie hodnoty v stĺpci "fullname" na meno a priezvisko
        $fullName = $row['fullname'];
        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];
        
        fputcsv($output, array($row['id'], $firstName, $lastName, $row['email'], $row['login']));
    }
    
    fclose($output);
    exit; // Ukončenie skriptu po exporte do CSV
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
  <link rel="stylesheet" href="styl.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
              <a class="nav-link" href="./logout-en.php">Home</a>
            </li>
            <li class="nav-item mr-5">
              <a class="nav-link" href="./game-en.php">Introduction</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./login-en.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./logout.php">Log out</a>
            </li>
          </ul>
          <ul class="navbar-nav language-switcher">
            <li class="nav-item mr-5">
              <a href="./restricted.php" class="language-flag"><img src="https://flagcdn.com/48x36/sk.png" alt="Slovak"></a>
              <a href="./restricted-en.php" class="language-flag"><img src="https://flagcdn.com/48x36/gb.png" alt="English"></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
</head>

<body>


<main class=page-wrapper>
    <div class="card card-wrapper">
    
      <div class="card-description-container card-body">
      <div class="container">

      <div class="row">
        <div class="col">

        </div>
        <div class="col-6">
          <section class="karty">
            <div class="column card-style">

              <div class="card-text">

                <p class="ellipsis">
                <h1 class="nazov">Welcome teacher <?php echo $_SESSION['fullname']; ?></h1>
                <br>
                <p class="text">
                </p>
                </p>
                
              </div>
            </div>

          </section>

          <div class="container">



            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">


                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Uživateľ <?php echo $_SESSION['login']; ?></h4>
                  </div>
                  <div class="modal-body">

                    <p class="text1"><strong>Si prihlaseny pod emailom:</strong> <?php echo $_SESSION['email']; ?></p>
                    <p class="text1"><strong>Tvoje prihlasovacie meno je:</strong> <?php echo $_SESSION['login']; ?></p>
                    <p class="text1"><strong>Dátum registracie konta:</strong> <?php echo $_SESSION['created_at'] ?></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
        <div class="col">

        </div>
      </div>

      <br><br>
      
     
      <?php
// Assuming you have already established a database connection
require_once('config.php');

$connection = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT DISTINCT latexFile FROM equation";
$result = $connection->query($query);

// Check if the query was successful
if ($result) {
    // Create an array to store the variants
    $variants = array();

    // Fetch each row from the result and store the variants in the array
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $variants[] = $row['latexFile'];
    }
} else {
    // Handle any errors that occurred during the query
    echo "Error: " . $connection->errorInfo()[2];
}
?>

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




<div class="center">
    <!-- Display the variants in a form -->
    <form method="POST" action="restricted.php">
        <?php foreach ($variants as $variant): ?>
            <label>
                <input type="checkbox" name="variant[]" value="<?php echo $variant; ?>">
                <?php echo $variant; ?>
            </label>
            <br>
        <?php endforeach; ?>

     
        <input type="date" id="date" name="date" required class="custom-date-input">
        <br>
        <input type="submit" value="Submit" class="custom-button">
    </form>

    <button id="latexButton" class="custom-button">Download Tasks</button>
</div>

<?php
// Assuming you have already established a PDO database connection
require_once('config.php');

// Retrieve the date from the form submission
$date = $_POST['date'];

// Retrieve the selected checkboxes
$selectedVariants = isset($_POST['variant']) ? $_POST['variant'] : array();

// Prepare the SQL statement
$query = "UPDATE equation SET date = :date, canGenerate = true WHERE latexFile = :latexFile";
$stmt = $connection->prepare($query);

// Update the rows in the database
foreach ($selectedVariants as $variant) {
    $stmt->bindParam(':latexFile', $variant);
    $stmt->bindParam(':date', $date);
    $result = $stmt->execute();

    // Check if the update was successful
    if (!$result) {
        echo "Error updating variant: " . $stmt->errorInfo()[2];
        break; // Exit the loop if an error occurred
    }
}

// Check if all updates were successful
if ($result) {
    //echo "Variants updated successfully!";
} else {
    echo "Error updating variants: " . $stmt->errorInfo()[2];
}
?>




<script>
  // Function to handle button click
  function handleButtonClick() {
    // Send a GET request to latex.php
    fetch('latex.php')
      .then(function(response) {
        // Handle the response if needed
        // For example, you can display a success message
        if (response.ok) {
          console.log('Tasks downloaded successfully!');
          location.reload(); // Reload the page
        } else {
          console.log('Failed to download tasks.');
        }
      })
      .catch(function(error) {
        // Handle any errors that occur during the request
        console.log('Error:', error);
      });
  }

  // Attach the click event listener to the button
  var button = document.getElementById('latexButton');
  button.addEventListener('click', handleButtonClick);
</script>

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
<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  // Nastavenie smery zoradenia na vzostupne
  dir = "asc"; 
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>

<?php
echo '<table id="myTable">';
echo '<tr><th onclick="sortTable(0)">ID</th><th onclick="sortTable(1)">Name</th><th onclick="sortTable(2)">Last name</th><th onclick="sortTable(3)">Email</th><th onclick="sortTable(4)">Login</th></tr>';

foreach ($results as $row) {
    $fullName = $row['fullname'];
    $nameParts = explode(' ', $fullName);
    $firstName = $nameParts[0];
    $lastName = $nameParts[1];

    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $firstName . '</td>';
    echo '<td>' . $lastName . '</td>';
    echo '<td>' . $row['email'] . '</td>';
    echo '<td>' . $row['login'] . '</td>';
    echo '</tr>';
}

echo '</table>';
?>

<form method="post" action="" class="center">
    <input type="submit" name="export_csv" value="Export to CSV" class="custom-button">
</form>


  </main>
 
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
  <main>




    

 


</html>