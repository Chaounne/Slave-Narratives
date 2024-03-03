<!doctype html>
<html lang="fr"> 
<head>
  <meta charset="utf-8" />
  <title>Slave Narratives</title>
  <link rel="icon" type="image/svg" href="<?= base_url(); ?>/resources/favicon.svg">

  <!-- Import de la librairie Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

  <!-- Leaflet Marker Cluster -->
  <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">

  <!-- Leaflet fullscreen-->
  <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
  <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet'/>

  <!-- Leaflet reset view button-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@drustack/leaflet.resetview/dist/L.Control.ResetView.min.css">
  <script src="https://cdn.jsdelivr.net/npm/@drustack/leaflet.resetview/dist/L.Control.ResetView.min.js"></script>

  <!-- Style Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
  <!-- jQuery (ajax) -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

  <script src="https://unpkg.com/Leaflet.Deflate/dist/L.Deflate.js"></script>

  <!-- Librairie datatable -->   
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.13.2/datatables.min.css"/>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.13.2/datatables.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/resources/style.css" media="screen">
</head>

<body>
<?php
use Config\Services;

session_start();

$request = explode('?', $_SERVER['REQUEST_URI'], 2);
$current_url = "http://".$_SERVER['HTTP_HOST'].$request[0];
$path = str_replace(site_url(), '', $current_url);

if (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], config('App')->supportedLocales))
    Services::language()->setLocale($_COOKIE['lang']);
?>
    <header>
        <nav class="navbar navbar-expand-lg ">
            <?php
                if (Services::language()->getLocale() == 'fr')
                    echo '<a class="navbar-brand" href="' . site_url()."change_lang" . '"><u><strong>FR</strong></u>/EN</a>';
                else
                    echo '<a class="navbar-brand" href="' . site_url()."change_lang" . '">FR/<u><strong>EN</strong></u></a>';
            ?>
            <a class="navbar-brand <?= (empty($path)) ? 'active' : '' ?>" href="<?= site_url() ?>"  ><?= lang('HeaderFooter.home')?></a>
            <a class="navbar-brand <?= (str_contains($path, "narrative") || str_contains($path, "narrator") !== false) ? 'active' : '' ?>" href="<?= site_url()."narrative/list" ?>" ><?= lang('HeaderFooter.narratives')?></a>
            <?php
                if (isset($_SESSION['idAdmin'])) {
                    echo '<a class="navbar-brand navbar-admin ' . (str_contains($path, "admin") ? 'active' : '') . '" href="' . site_url() . 'admin">' . lang('HeaderFooter.administration') . '</a>';
                    echo('<a class="navbar-brand" href="' . site_url() . 'admin/logout" >' . lang('HeaderFooter.logout') . '</a>');
                } else {
                    if (isset($_COOKIE['token'])) {
                        header('location:' . base_url('/traitTokenCookie'));
                        exit;
                    }
                    echo '<a class="navbar-brand navbar-admin ' . (str_contains($path, "admin") ? 'active' : '') . '" href="' . site_url() . 'admin/login">' . lang('HeaderFooter.administration') . '</a>';
                }
            ?>
        </nav>

        <h1 class=tprinc>Slave narratives</h1>
        <h3>Every voice needs to be heard</h3>

    </header>

<?php
$url = $_SERVER['REQUEST_URI'];
if((!isset($_SESSION['visite'])) || str_contains($url, '/slave_narratives/narrative/')){
    $_SESSION['visite'] = 'oui';
    $servername = "localhost";
    $database = "slave_narratives";
    $username = "slave_narratives";
    $password = "nquQuNgjJGnUhwerMZRY";
    $date = date("Y-m-d");

    $conn = mysqli_connect($servername, $username, $password, $database);

//check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $currentUrl = $_SERVER['REQUEST_URI'];

    $sql = "SELECT * FROM visitor WHERE route = '$currentUrl' AND date='$date';";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Erreur dans la requête : " . mysqli_error($conn));
    }

    if ($row = mysqli_fetch_assoc($result)) {
        $updateSql = "UPDATE visitor SET visit_count = visit_count + 1 WHERE route = '$currentUrl' AND date='$date'";
        $updateResult = mysqli_query($conn, $updateSql);

        if (!$updateResult) {
            die("Erreur lors de la mise à jour : " . mysqli_error($conn));
        }
    } else {
        $insertSql = "INSERT INTO visitor VALUES ('$currentUrl', 1, '$date')";
        $insertResult = mysqli_query($conn, $insertSql);
    }

    mysqli_close($conn);
}
?>
</body>

