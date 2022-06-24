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
         <?php
        if (isset($this->csslibrary)) {
            echo "\n";
            foreach ($this->csslibrary as $css) {
                echo "\t" . '<link rel="stylesheet" href="' . URL . 'public/assets/' . $css . '.css" type="text/css" />' . "\n";
            }
        }
        ?>
         <script>window.siteurl = '<?php echo URL; ?>';</script>
    </head>
     <body>
        