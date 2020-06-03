<?php
namespace Anax\View;

?>

<article class="article">
<navbar class="navbar">
    <a href="<?= url("movie/index") ?>">Show all movies</a> |
    <a href="<?= url("movie/searchTitle") ?>">Search title</a> |
    <a href="<?= url("movie/searchYear") ?>">Search year</a> |
    <a href="<?= url("movie/movieSelect") ?>">Select</a> |
</navbar>
<h1> <?= $title ?> </h1>
