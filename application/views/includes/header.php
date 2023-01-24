<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="<?= base_url() ?>assets/js/jquery-3.6.3.min.js"></script>
    <script src="<?= base_url() ?>assets/js/underscore-umd-min.js"></script>
    <script src="<?= base_url() ?>assets/js/backbone-min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
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
                <form class="navbar-form navbar-left" action="<?= base_url() ?>index.php/question/search">
                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search">
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($isLoggedIn) && $isLoggedIn) { ?>
                        <li>
                            <a href="<?= base_url() ?>index.php/auth/account">Account</a>
                        </li>
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
            <?php if (isset($isLoggedIn) && $isLoggedIn) { ?>
                <div class="btn-toolbar" style="justify-content: center; display: flex">
                    <div class="col-md-2">
                        <a href="<?= base_url() ?>index.php/question/question" class="btn btn-success btn-md"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Questions</a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url() ?>index.php/question/categories" class="btn btn-success btn-md"><span class="glyphicon glyphicon-comment" aria-hidden="true"></span> Categories</a>
                    </div>
                    <div class="col-md-2">
                        <a href="<?= base_url() ?>index.php/question/ask" class="btn btn-success btn-md" style="margin-left: 20%"><span class="glyphicon glyphicon-hand-up" aria-hidden="true"></span> Ask Question</a>
                    </div>
                </div>
            <?php } ?>
        </div>