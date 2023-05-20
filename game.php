<!DOCTYPE html>
<html lang="sk">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <link rel="stylesheet" href="./client/src/styles/styles.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js"></script>
  <title>Mathex</title>
</head>

<body>
  <header class="page-header">
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
              <a class="nav-link" href="./index.php">Domov</a>
            </li>
            <li class="nav-item mr-5">
              <a class="nav-link" href="#">Inštrukcie</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./login.php">Prihlásenie</a>
            </li>
          </ul>
          <ul class="navbar-nav language-switcher">
            <li class="nav-item mr-5">
              <a href="./game.php" class="language-flag"><img src="https://flagcdn.com/48x36/sk.png" alt="Slovak"></a>
              <a href="./game-en.php" class="language-flag"><img src="https://flagcdn.com/48x36/gb.png" alt="English"></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class=page-wrapper>
    <div class="card card-wrapper">
      <h1 class="card-title card-header">Ako pužiť aplikáciu Mathex?</h1>
      <h2 class="card-subtitle card-header">Inštrukcie pre učiteľa</h2>
      <div class="card-description-container card-body">
        <p class="card-description mb-3">Učiteľ sa musí najprv do našej webovej aplikácie zaregistrovať a následne prihlásiť. Po prihlásení má k dispozícii zabezpečenú stránku, na ktorej nájde
          všetky potrebné informácie prihlásenom uživateľovi. Učiteľ vie zadávať úlohy pre študentov. Po priradení úloh študentom, učiteľ môže
          sledovať ich pokrok a výsledky. Taktiež je k dispozícii prehľadná tabuľka, v ktorej sú mená študentov, ktorí aplikáciu využívajú. Nakoniec je taktiež možné stiahnuť si danú tabuľku vo formáte .csv</p>
        </p>
        <p class="card-description mb-3"></p>
        <p class="card-description mb-3"></p>
      </div>
      <h2 class="card-subtitle card-header">Inštrukcie pre študenta</h2>
      <div class="card-description-container card-body">
        <p class="card-description mb-3">Študent sa taktiež ako učiteľ musí do aplikácie zaregistrovať a následne prihlásiť na svoju zabezpečenú stránku. Následne má študent k dispozícii
          pre neho priradené úlohy, ktoré mu učiteľ zadával. Po vypracovaní úloh študent úlohy odovzdá a učiteľ ich následne vyhodnotí.
        </p>
        <p class="card-description mb-3"></p>
        <p class="card-description mb-3"></p>
      </div>
      <button id="download-pdf-btn" >Stiahnúť PDF</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.js"></script>
<script src="./client/src/js/script.js"></script>
<script>
  // html to pdf
  const downloadBtn = document.getElementById('download-pdf-btn');
  downloadBtn.addEventListener('click', () => {
    const content = document.querySelector('.page-wrapper');
    const options = {
      margin: 0,
      padding: 20,
      fontSize: 12,
      textalign: 'center',
      filename: 'mathex_instructions.pdf',
      image: {
        type: 'jpeg',
        quality: 1
      },
      html2canvas: {
        scale: 2
      },
      jsPDF: {
        unit: 'mm',
        format: 'a4',
        orientation: 'portrait'
      }
    };
    html2pdf().set(options).from(content).save();
  });
</script>

</html>