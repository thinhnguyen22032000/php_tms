<?php 
 if(isset($_SESSION['user_info'])){
    if($_SESSION['user_info']['role_id'] == 1){
        header('location: http://localhost/mini_project_2/request');
    }else{
        header('location: http://localhost/mini_project_2/request/confirm_management');
    }
 }
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $GLOBALS['url'] ?>/public/vendor/bootstrap/css/bootstrap.min.css">
    <link href="<?= $GLOBALS['url'] ?>/public/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $GLOBALS['url'] ?>/public/libs/css/style.css">
    <link rel="stylesheet" href="<?= $GLOBALS['url'] ?>/public/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
        }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <?php
        if (isset($_SESSION['error_msg'])) { ?>
            <div class="card-body fixed-top">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php
                    if (!is_array($_SESSION['error_msg'])) { ?>
                        <strong>Error!</strong> <?=$_SESSION['error_msg']?>.
                        <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    <?php
                    }else{
                        foreach ($_SESSION['error_msg'] as $key => $value) { ?>
                        <strong>Err!</strong> <?=$value?>.
                        <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    <?php       
                        }
                    }
                    ?>
                </div>
            </div>
        <?php
            unset($_SESSION['error_msg']);
        }
        ?>
        <div class="card ">
            <div class="card-header text-center"><a><img class="logo-img" src="<?= $GLOBALS['url'] ?>/public/images/logo.png" alt="logo"></a><span class="splash-description">Please enter your user information.</span></div>
            <div class="card-body">
                <form method="post" action="<?= Domain::get() ?>/auth/authLogin">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="username" id="username" type="text" placeholder="Username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" id="password" type="password" placeholder="Password">
                    </div>
                   
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>
            </div>
            <!-- <div class="card-footer bg-white p-0  ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Create An Account</a>
                </div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Forgot Password</a>
                </div>
            </div> -->
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="<?= $GLOBALS['url'] ?>/public/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="<?= $GLOBALS['url'] ?>/public/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>

</html>