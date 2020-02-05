<?php

$name = $_GET name
$pokeapi = file_get_contents("https://pokeapi.co/api/v2/pokemon/.$name.");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poke-dex</title>

    <link rel="stylesheet" href="assets/css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/img/pokedex-icon.png"> <!--icon that appears on tab-->
    <meta name="author" content="Imanachu and Neilax">
    <meta name="description" content="Poké-dex library to keep track of all the pokemons"><!--description that appears on google search-->
</head>

<body>s
<h1>The greatest Poké-dex</h1>

<section class="container">
    <section class="P1">
        <section class="pokemonIcon">
            <img src="" alt="Poke icon" class="pokeIcon">
            <p class="pokeName"></p>
        </section>

        <section class="getinput">
            <form method="get" action="" name = "name">
            <input id="input" type="text" placeholder="type a pokemon name!">
            </form>
            <button id="inputBtn" class="btn" class="search">search</button>
        </section>
    </section>

    <section class="P2">

        <section class="Descriptionbox">
            <p class="description"></p>
        </section>

        <section class="movesList">
            <ul id="movesList">

            </ul>
        </section>

        <section class="EvolutionIcon">
            <img class="evolutionIcon" src="" alt="evicon">
            <p class="evolutionName"></p>
        </section>

        <section class="buttons">
            <button id="previousbtn" class="btn" class="search"><==</button>
            <button id="nextbtn" class="btn" class="search">==></button>
        </section>

    </section>


</section>







<script src="assets/JS/script.js"></script>
</body>
</html>
