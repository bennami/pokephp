<?php
ini_set("display_errors", "1");
//get input user and pokeapi
$name = $_GET ["name"];
$Object = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$name);
$Species = file_get_contents("https://pokeapi.co/api/v2/pokemon-species/".$name);

$pObject=json_decode($Object);
$pSpecies = json_decode($Species);
//var_dump($pObject);

echo $pObject->name;
$pokeEvName = $pSpecies->evolves_from_species->name;

$pokeEvApi = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$pokeEvName);
$pokeEv = json_decode($pokeEvApi);
$pokeEvIcon = $pokeEv->sprites->front_default;
$pokeIcon = $pObject->sprites->front_default;
$id = $pObject->id;
$allMoves= array();

for($i=0; $i< count($pObject->moves);$i++){
    array_push($allMoves, $pObject->moves[$i]->move->name);
}

//randomize, get the minimum or max 4 moves of the allMoves length
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




//if(isset($_GET["name"])){
  //  echo $name;
//}
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
            <img src="<?php echo $pokeIcon ?>" alt="Poke icon" class="pokeIcon">
            <p class="pokeName"></p>
        </section>

        <section class="getinput">
            <form method="get" action="">
            <input id="input" type="text" name="name" placeholder="type a pokemon name!">
            <button type="submit" value="submit" value="submit" id="inputBtn" class="btn" class="search">search</button>
            </form>
        </section>
    </section>

    <section class="P2">
    <p><?php echo $pokeEvName ?></p>
        <section class="Descriptionbox">
            <p class="description"><?php  echo  $pokeDescription ?> </p>
        </section>

        <section class="movesList">
            <ul id="movesList">
               <?php echo implode('</br>',$movesArr); ?>
            </ul>
        </section>

        <section class="EvolutionIcon">
            <img class="evolutionIcon" src="<?php echo $pokeEvIcon ?>" alt="evicon">
            <p class="evolutionName"></p>
        </section>

        <section class="buttons">
            <button id="previousbtn" class="btn" class="search"><==</button>
            <button id="nextbtn" class="btn" class="search">==></button>
        </section>

     </section>


    </section>

</body>
</html>