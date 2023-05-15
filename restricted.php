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
  <link rel="stylesheet" href="styl.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Učiteľ</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="logout.php"><span class="glyphicon glyphicon-home"></span> Domov</a></li>
          <li class="dropdown">


          </li>

        </ul>
        <ul class="nav navbar-nav navbar-right">

          <li class="active"><a href="logout.php"><span class="glyphicon glyphicon-user"></span> Odhlásenie</a></li>

        </ul>
      </div>
    </div>
  </nav>

</head>

<body>


  <main>




    <div class="container">

      <div class="row">
        <div class="col">

        </div>
        <div class="col-6">
          <section class="karty">
            <div class="column card-style">

              <div class="card-text">

                <p class="ellipsis">
                <h2 class="nazov">Vitaj učiteľ<?php echo $_SESSION['fullname']; ?></h2>
                <br>
                <p class="text">
                </p>
                </p>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Údaje o prihlásenom použivateľovi</button>
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
      <style>
        .text1 {
          color: black;
        }

        .text {
          font-size: large;
          margin-left: 30px;

          margin-top: 20px;
          margin-bottom: 20px;
          color: #e5e4e2;
        }

        .nazov {
          margin-left: 30px;

          color: #e5e4e2;
        }

        body {
          background-color: #0C4A60;
          ;
          color: #566787;

          font-family: 'Roboto', sans-serif;
        }

        section {
          display: flex;
          flex-flow: row wrap;



        }

        P {
          overflow: hidden;
          text-overflow: ellipsis;
          font-size: 16px;
        }

        H3 {
          font-family: "IBM Plex Sans", sans-serif;
          font-weight: 100;
          text-transform: uppercase;
          font-size: 28px;
        }

        figure {
          background-color: #934A5F;
          margin: 0px;
        }

        figure img {
          width: 100%;
          border-top-left-radius: 5px;
          border-top-right-radius: 5px;
        }

        figure img:hover {
          opacity: 0.6;
          transition: all .3s linear;
        }

        .column {
          box-sizing: border-box;
          flex: 1 100%;
          justify-content: space-evenly;
          margin: 20px;
        }

        .card-style {
          border-radius: 12px;
          border-image-slice: 1;
          box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.4);
          transition: all 0.25s linear;
        }

        .card-style:hover {
          box-shadow: -1px 10px 29px 0px rgba(0, 0, 0, 0.8);
        }

        .card-text {
          padding: 20px;
        }

        .karty {
          color: #e5e4e2;
        }

        .footer {
          position: fixed;
          left: 0;
          bottom: 0;
          width: 100%;
          background-color: #222;
          color: white;
          text-align: center;
        }
      </style>
     



  </main>
  <div class="footer">
    <p>Prihlásený učiteľ: <?php echo $_SESSION['fullname']; ?></p>
  </div>

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

<!-- Display the variants in a form -->
<form method="POST" action="restricted.php">
    <?php foreach ($variants as $variant): ?>
        <label>
            <input type="checkbox" name="variant[]" value="<?php echo $variant; ?>">
            <?php echo $variant; ?>
        </label>
        <br>
    <?php endforeach; ?>

    <label for="date">Date:</label>
    <input type="date" id="date" name="date" required>
    <br>
    <input type="submit" value="Submit">
</form>

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
    echo "Variants updated successfully!";
} else {
    echo "Error updating variants: " . $stmt->errorInfo()[2];
}
?>


<button id="latexButton">Download Tasks</button>

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


</html>