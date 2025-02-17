<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Lepo je biti elektrotehnik - NADZOR</title>

<link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/cover/">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<?php
require 'server_data.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Povezava s strežnikom ni uspela: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$sql = "SELECT ID, name, time FROM contestants";
$result = $conn->query($sql);

$sql = "SELECT * FROM question ORDER BY ID DESC LIMIT 1";
$resultQ = $conn->query($sql);

$conn->close();

$idQ = "-1";
if($resultQ->num_rows > 0){
  $rowQ = $resultQ->fetch_assoc();
  $idQ = $rowQ['ID'];
  $steviloGlasov = (int)$rowQ['ACount'] + (int)$rowQ['BCount'] + (int)$rowQ['CCount'] + (int)$rowQ['DCount'];
  $procentA = 25;
  $procentB = 25;
  $procentC = 25;
  $procentD = 25;
  if($steviloGlasov > 0){
    $procentA = round((int)$rowQ['ACount'] / $steviloGlasov * 100);
    $procentB = round((int)$rowQ['BCount'] / $steviloGlasov * 100);
    $procentC = round((int)$rowQ['CCount'] / $steviloGlasov * 100);
    $procentD = round((int)$rowQ['DCount'] / $steviloGlasov * 100);
  }
}

$trenutniTekmovalec = file_get_contents("izbran_tekmovalec.txt");
if($trenutniTekmovalec == ""){
  $trenutniTekmovalec = "*Ni tekmovalca*";
}
$view = file_get_contents("pogled.txt");

?>
<script>
  var view = "<?php Print($view); ?>";
  const interval = setInterval(function() {
    if (view == 1 || view == 2) {
      window.location.reload();
    }
  }, 2000);

  const interval2 = setInterval(function() {
    if (view == 0) {
      window.location.reload();
    }
  }, 10000);

  function refreshFunction() {
    window.location.reload();
}
</script>

<body class="py-4">
  <main>
    <div class="container">
      <h1>Upravljanje občinstva</h1>
      <div class="row">
        <div class="col-10">
          <p class="lead">Nadzor nad prijavami v kviz in glasovanjem. Sistem krmili matični program za kviz.</p>
        </div>
        <div class="col-2">
          <button type="button" onclick="refreshFunction()" class="btn btn-warning">Osveži</button>
        </div>
      </div>
      <hr class="my-4">
      <h2 class="mt-4">Sistem</h2>
      <p>Status prikaza. Ročno spreminjaj samo po potrebi.</p>
      <div class="row">
        <div class="col">
          <div class="btn-group" role="group" aria-label="Upravljanje prikaza na mobilnih napravah">
            <a href="spremeni_pogled.php?view=0" type="button" <?php if($view == "0") {?>class="btn btn-secondary"<?php } else{?>class="btn btn-outline-secondary"<?php }?>>Ni aktivnosti</a>
            <a href="spremeni_pogled.php?view=1" type="button" <?php if($view == "1") {?>class="btn btn-success"<?php } else{?>class="btn btn-outline-success"<?php }?>>Prijava v kviz</a>
            <a href="spremeni_pogled.php?view=2" type="button" <?php if($view == "2") {?>class="btn btn-info"<?php } else{?>class="btn btn-outline-info"<?php }?>>Glas ljudstva</a>
          </div>
        </div>
        <div class="col">
          <div class="btn-group" role="group" aria-label="Izbran tekmovalec">
            <button type="button" class="btn btn-primary" disabled>Izbrani tekmovalec</button>
            <button type="button" class="btn btn-light" disabled><?php echo $trenutniTekmovalec?></button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#clearContestant">Odstrani</button>
          </div>
        </div>
        <div class="col">
          <div class="btn-group" role="group" aria-label="Trenutno vprašanje">
            <button type="button" class="btn btn-primary" disabled>Glas ljudstva ID</button>
            <button type="button" class="btn btn-light" disabled><?php echo $idQ?></button>
            <!--<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#clearVoting">Odstrani</button>-->
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="clearContestant" tabindex="-1" aria-labelledby="clearContestantLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="clearContestantLabel">Potrdi odločitev</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Res želiš izbrisati tekmovalca?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Prekliči</button>
                <a href="odstrani_tekmovalca.php" type="button" class="btn btn-danger" role="button">Odstrani</a>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="clearVoting" tabindex="-1" aria-labelledby="clearVotingLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="clearVotingLabel">Potrdi odločitev</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Res želiš izbrisati trenutno vnos za glas ljudstva?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Prekliči</button>
                <a href="odstrani_vprasanje.php" type="button" class="btn btn-danger" role="button">Odstrani</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <hr class="my-4">
      <h2 class="mt-4">Prijave v kviz</h2>
      <p>Najnovejše prijave na vrhu. Vnos pobriši samo po koncu kviza. Tekmovalca izberi s klikom na njegovo ime.</p>

      <div class="row row-cols-2 row-cols-lg-6 g-2 g-lg-3">
          <?php
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<div class=\"col\"><a href=\"izberi_tekmovalca.php?name=" . $row["name"] . "&id=" . $row["ID"] . "\" type=\"button\" class=\"btn btn-outline-primary\" role=\"button\">" . $row["name"] . "</a></div>";
            }
            ?>
            <div class="col"><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#clearList">Počisti seznam</button></div>
            <!-- Modal -->
            <div class="modal fade" id="clearList" tabindex="-1" aria-labelledby="clearListLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="clearListLabel">Potrdi odločitev</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Res želiš izbrisati vse vnose prijav na tekmovanje?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Prekliči</button>
                    <a href="pocisti_prijave.php" type="button" class="btn btn-danger" role="button">Izbriši</a>
                  </div>
                </div>
              </div>
            </div>
            <?php
          }
          else{
            ?>
              <div class="col"><button type="button" class="btn btn-outline-secondary" disabled>Ni prijavljenih</button></div>
            <?php
          }
          ?>
      </div>

      <hr class="my-4">
      <h2 class="mt-4">Glas ljudstva</h2>
      <p>Nadzor nad delovanjem sistema in statistiko.</p>
      <?php
      if($resultQ->num_rows > 0){
        ?>
        <p><div class="btn-group" role="group" aria-label="Vprašanje">
          <button type="button" class="btn btn-primary" disabled>Vprašanje</button>
          <button type="button" class="btn btn-light" disabled><?php echo $rowQ['questionText']; ?></button>
        </div></p>
        <div class="row">
          <div class="col-md-auto">
            <div class="btn-group" role="group" aria-label="Število glasov">
              <button type="button" class="btn btn-success" disabled>Število glasov</button>
              <button type="button" class="btn btn-light" disabled><?php echo $steviloGlasov; ?></button>
            </div>
          </div>
          <div class="col-md-auto">
            <div class="btn-group" role="group" aria-label="Odgovor A">
              <button type="button" class="btn btn-primary" disabled>A</button>
              <button type="button" class="btn btn-light" disabled><?php echo $rowQ['AText']; ?></button>
              <button type="button" class="btn btn-primary" disabled><?php echo $procentA; ?>%</button>
            </div>
          </div>
          <div class="col-md-auto">
            <div class="btn-group" role="group" aria-label="Odgovor B">
              <button type="button" class="btn btn-primary" disabled>B</button>
              <button type="button" class="btn btn-light" disabled><?php echo $rowQ['BText']; ?></button>
              <button type="button" class="btn btn-primary" disabled><?php echo $procentB; ?>%</button>
            </div>
          </div>
          <div class="col-md-auto">
            <div class="btn-group" role="group" aria-label="Odgovor C">
              <button type="button" class="btn btn-primary" disabled>C</button>
              <button type="button" class="btn btn-light" disabled><?php echo $rowQ['CText']; ?></button>
              <button type="button" class="btn btn-primary" disabled><?php echo $procentC; ?>%</button>
            </div>
          </div>
          <div class="col-md-auto">
            <div class="btn-group" role="group" aria-label="Odgovor D">
              <button type="button" class="btn btn-primary" disabled>D</button>
              <button type="button" class="btn btn-light" disabled><?php echo $rowQ['DText']; ?></button>
              <button type="button" class="btn btn-primary" disabled><?php echo $procentD; ?>%</button>
            </div>
          </div>
        </div>
        <?php
      }else{
        ?>
          <button type="button" class="btn btn-outline-secondary" disabled>Ni vprašanj</button>
        <?php
      }
      ?>
    </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
