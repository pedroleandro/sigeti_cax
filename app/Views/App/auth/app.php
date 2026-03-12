<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?? "SIGETI - Sistemas de Chamados" ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= assets_sb_admin('/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= assets_sb_admin('/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= assets('/css/message.css') ?>" type="text/css">

</head>

<body class="bg-gradient-primary">

<?= $this->section('content') ?>

<!-- Bootstrap core JavaScript-->
<script src="<?= assets_sb_admin('/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= assets_sb_admin('/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Core plugin JavaScript-->
<script src="<?= assets_sb_admin('/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

<!-- Custom scripts for all pages-->
<script src="<?= assets_sb_admin('/js/sb-admin-2.min.js') ?>"></script>

</body>

</html>
