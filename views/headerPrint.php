<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <link rel="icon" href="<?php echo URL . "public/assets/images/logo" ?>/favicon.png" type="image/x-icon">
        <link rel="shortcut icon" href="<?php echo URL . "public/assets/images/logo" ?>/favicon.png" type="image/x-icon">
        <link rel="apple-touch-icon" href="<?php echo URL . "public/assets/images/logo" ?>/favicon.png">

        <title><?php echo ESTABLISHMENT; ?><?php echo isset($this->title) ? " - " . $this->title : ""; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!--        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">-->
        <link rel="stylesheet" href="<?php echo URL . "public" ?>/assets/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo URL . "public" ?>/assets/vendors/iconly/bold.css">
        <link rel="stylesheet" href="<?php echo URL . "public" ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
        <link rel="stylesheet" href="<?php echo URL . "public" ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
        <link rel="stylesheet" href="<?php echo URL . "public" ?>/assets/vendors/simple-datatables/style.css">
        <link rel="stylesheet" href="<?php echo URL . "public" ?>/assets/vendors/sweetalert2/sweetalert2.min.css">
        <link rel="stylesheet" href="<?php echo URL . "public" ?>/assets/css/app.css">
        <style>
            @media print
            {
                @page {	
                    size: <?php echo $this->orientation; ?>;
                }

                html
                {
                    zoom: <?php echo $this->printZoom; ?>%;
                }
            }
            table { page-break-inside:auto !important; }
            tr    { page-break-inside:auto !important; page-break-after:auto !important; }
            table tr td { page-break-inside:auto !important; page-break-after:auto !important; }
            table tr td table { page-break-inside:auto !important; page-break-after:auto !important; }
            table tr td table tr { page-break-inside:auto !important; page-break-after:auto !important; }
            table tr td table tr td { page-break-inside:auto !important; page-break-after:auto !important; }
            table tr td table tr td table { page-break-inside:auto !important; page-break-after:auto !important; }
            h1,h2,h3,h4,h5,h6{
                color: #999 !important;
            }
            body{
                color: #000!important;
            }
        </style>
    </head>
    <body class="bg-white">
        <div id="app">