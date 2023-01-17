<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <script src="<?= base_url() ?>assets/js/jquery-3.6.3.min.js"></script>
    <script src="<?= base_url() ?>assets/js/underscore-umd-min.js"></script>
    <script src="<?= base_url() ?>assets/js/backbone-min.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/heapunderflow.css" />
    <title>Heap Underflow</title>
</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?= base_url() ?>index.php">heap<b>underflow</b></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <form class="navbar-form navbar-left">
                    <input type="text" class="form-control" placeholder="Search">
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($isLoggedIn) && $isLoggedIn) { ?>
                        <li>
                            <a href="<?= base_url() ?>index.php/auth/logout">Sign Out</a>
                        </li>
                    <?php } else { ?>
                        <li>
                            <a href="<?= base_url() ?>index.php">Sign up</a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>index.php/auth/login">Sign In</a>
                        </li>
                    <?php } ?>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <div class="col-md-4">
            </div>
            <div class="btn-toolbar">
                <a href="<?= base_url() ?>index.php/QuestionController" class="btn btn-success btn-md"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Questions</a>
                <a href="<?= base_url() ?>index.php/QuestionController/categories" class="btn btn-success btn-md"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Categories</a>
                <a href="<?= base_url() ?>index.php/QuestionController/ask" class="btn btn-success btn-md" style="margin-left: 20%"><span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Ask Question</a>
            </div>
        </div>