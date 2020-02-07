<?php
ini_set("display_errors","1");
//get input user and pokeapi

if(isset($_GET ['name'])){
    $name = $_GET ["name"];
//get api and decode the json  in array
$Object = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$name);
$Species = file_get_contents("https://pokeapi.co/api/v2/pokemon-species/".$name);

$pObject=json_decode($Object);
$pSpecies = json_decode($Species);
//get evolution chain
$evChain = file_get_contents($pSpecies->evolution_chain->url);
$evChainData = json_decode($evChain);
/*for($i=0;$i< count($evChain->chain->evolves_to);$i++){
    //path to get evolutions, exceptions: eeve(7 first evolves to) and gloom(2 second evolves to)!
    echo $evChain->chain->evolves_to[$i]->species->name;
}*/
$evChainArr = array();
for($i=0;$i < count($evChainData->chain->evolves_to);$i++){
    array_push($evChainArr, $evChainData->chain->evolves_to[$i]->species->name);
}
//echo $evChainArr;
implode('</br>', $evChainArr);
//path to get the baby pokemon in the chain
 $evChainData->chain->species->name;
//get data from api
    $pokeIcon = $pObject->sprites->front_default;
    $id = $pObject->id;

//get moves into array
    $allMoves= array();
    for($i=0; $i< count($pObject->moves);$i++){
        array_push($allMoves, $pObject->moves[$i]->move->name);
    }

//randomize, get the minimum or max 4 moves of the allMoves length, put exception for ditto
    $fourMoves = [];
    $fourMoves = array_rand($allMoves, min(4, count($allMoves)));

    $movesArr = [];
    if($fourMoves === 0){
        array_push($movesArr, $pObject->moves[0]->move->name) ;
    }else{
        foreach ($fourMoves  as $value) {
            array_push(  $movesArr, $pObject->moves[$value]->move->name);
        }
    }

//getting pokedescription
    for ($x = 0; $x < count($pSpecies->flavor_text_entries); $x++) {
        if ($pSpecies->flavor_text_entries[$x]->language->name === "en") {
            $pokeDescription = $pSpecies->flavor_text_entries[$x]->flavor_text;
        }
    }


//get evolution name pokemon api to get sprite
    if (isset($pSpecies->evolves_from_species->name)){
        $pokeEvName = $pSpecies->evolves_from_species->name;
        $pokeEvApi = file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $pokeEvName);
        $pokeEv = json_decode($pokeEvApi);
        $pokeEvIcon = $pokeEv->sprites->front_default;
        $display =" ";
    }else{
        $pokeEvIcon ='';
        $pokeEvName ='no pre evolution';
        $display = 'display:none';
    }
}

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

<body>
<h1>The greatest Poké-dex</h1>

<section class="container">
    <section class="P1">
        <section class="pokemonIcon">
            <img src="<?php echo $pokeIcon ?>" alt="<?php echo $name ?>" class="pokeIcon">

        </section>

        <section class="getinput">
            <form method="get" action="">
            <input id="input" type="text" name="name" placeholder="type a pokemon name!">
            <button type="submit" value="submit"  id="inputBtn" class="btn" class="search">search</button>
            </form>
        </section>
    </section>

    <section class="P2">

        <section class="Descriptionbox">
            <p class="description"><?php  echo  $pokeDescription ?> </p>
        </section>

        <section class="movesList">
            <ul id="movesList">
               <?php echo implode('</br>',$movesArr); ?>
            </ul>
        </section>

        <section class="EvolutionIcon">
            <img class="evolutionIcon" src="<?php echo $pokeEvIcon ?>" alt="evicon" style="<?php echo $display?>">
            <p class="evolutionName"><?php echo $pokeEvName ?></p>
        </section>

        <section class="buttons">
            <p class="pokeName"><?php echo $pObject->name; ?></p>
            <button id="previousbtn" class="btn" class="search"><==</button>
            <button id="nextbtn" class="btn" class="search">==></button>
        </section>

     </section>


    </section>
<script src="assets/JS/toggle.js"></script>
</body>
</html>