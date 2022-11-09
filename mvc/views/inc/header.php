<?php
if (isset($_POST['lang'])) {
  $_SESSION['lang'] = $_POST['lang'];
} else {
  if (isset($_SESSION['lang'])) {
  } else {
    $_SESSION['lang'] = 'en';
  }
}
require_once './language/' . $_SESSION['lang'] . '.php';
require_once './mvc/untils/session.php';
require_once './mvc/untils/alert.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<?php
$check_msg = isset($_SESSION['error_msg']);
$alert_bg = $check_msg ? 'alert-danger' : 'alert-primary';
$alert_type = $check_msg ? $lang['ERR'] : $lang['NOTIFY'];
?>

<body onload="handleResetMsg('<?= $lang['WELCOME'] ?>', '<?= $lang['NOTIFY'] ?>')">
  <div class="container">
    <header>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
          <div class="collapse navbar-collapse col-8">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 d-flex align-items-center ">
              <li class="nav-item active">
                <a class="nav-link" aria-current="page" href="#">
                  <h3>Food order</h3>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><?= isset($_COOKIE['username']) ? $_COOKIE['username'] : 'Hello' ?></a>
              </li>
            </ul>
          </div>
          <!-- change languge -->
          <div class="d-flex align-items-center justify-content-around col-3">
            <form class="form-select" method="post" id="lang-form" action="" style=" line-height: 2;">
              <select class="form-control form-control-sm" name="lang" id="lang" onchange="handleLang()">
                <option value="en">choose languges</option>
                <option <?= $_SESSION['lang'] == 'en' ? 'selected' : null ?> value="en">en</option>
                <option <?= $_SESSION['lang'] == 'vn' ? 'selected' : null ?> value="vn">vn</option>
              </select>
            </form>
            <!-- end change languge -->
            <?php
            if (isset($_COOKIE['username'])) { ?>
              <a onclick="return confirm('Are you sure?')" href="<?= Domain::get() ?>/auth/logout" class="btn btn-primary btn-sm"><?= $lang['BTN_LOGOUT'] ?></a>
            <?php
            }
            ?>
          </div>
        </div>
      </nav>
    </header>
    <!-- message -->
    <div class="mb-4">
      <div id='alert-bg' class="alert <?= $alert_bg ?>" role="alert">
        <h5 id="alert-type"><?= $alert_type ?></h5>
        <div class="" id="txt"></div>
        <div id="msg-txt">
          <?php
          alert_msg($check_msg, $lang);
          d_session(['error_msg', 'notify_msg']);
          ?>
        </div>
      </div>
    </div>
    <!-- message -->

    <script>
      // function fadeOut() {
      //   document.getElementById("msg-txt").style.transition = "opacity 0.5s linear 0s";
      //   document.getElementById("msg-txt").style.opacity = 0;
      // }

      // function fadeIn() {
      //   document.getElementById("msg").style.transition = "opacity 0.5s linear 0s";
      //   document.getElementById("msg").style.opacity = 1;
  
      // }

      function handleResetMsg(msg, alert_type) {
        setTimeout(function() {
          document.querySelector("#msg-txt").innerText = msg
          document.querySelector("#alert-bg").classList.add('alert-primary')
          document.querySelector("#alert-bg").classList.remove('alert-danger')
          document.querySelector("#alert-type").innerText = alert_type
        }, 2000)
      }
    </script>