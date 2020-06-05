<?php
//ini_set("display_errors","1");

if(isset($_GET ['name'])){
$nameInput = $_GET ["name"];
$name = strtolower($nameInput);

//get api and decode the json  into array, we need the pokemon and species(for evolution chain) API link
$Object = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$name);
$Species = file_get_contents("https://pokeapi.co/api/v2/pokemon-species/".$name);
$pObject=json_decode($Object);
$pSpecies = json_decode($Species);

//get evolution chain
$evChain = file_get_contents($pSpecies->evolution_chain->url);
$evChainData = json_decode($evChain);

$evolutionNames = array();
$allIcons = array();
$allMoves= array();

//if there is evolution, check if input name is baby or not, then get names of evolution pokemon
 if($evChainData->chain->evolves_to[0] !== null ) {
     //check if $name is baby
     if ($evChainData->chain->species->name == $name) {
         array_push($evolutionNames, $name);
         $nameBaby = implode('', $evolutionNames);
     }
     // if not baby, get baby name
     else if ($evChainData->chain->species->name !== null) {
         array_push($evolutionNames, $evChainData->chain->species->name);
         $nameBaby = implode('', $evolutionNames);
     } else {
         $nameBaby = $name;
     }
     //check If there is evolution1, get names
     if($evChainData->chain->evolves_to[0] !== null) {
         for ($i = 0; $i <= count($evChainData->chain->evolves_to) - 1; $i++) {
             array_push($evolutionNames, $evChainData->chain->evolves_to[$i]->species->name);
         }
     }
 }else{
     array_push($evolutionNames, 'no evolutions');
 }

//check If there is evolution2, get names
    if($evChainData->chain->evolves_to[0]->evolves_to[0] !== null) {
    for ($i = 0; $i < count($evChainData->chain->evolves_to[0]->evolves_to); $i++) {
        array_push($evolutionNames, $evChainData->chain->evolves_to[0]->evolves_to[$i]->species->name);
    }
}

//get sprites
foreach ($evolutionNames as $name) {
    $pokeEvApi = file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $name);
    $pokeEv = json_decode($pokeEvApi);
    $pokeIconBaby2 = $pokeEv->sprites->front_default;
    array_push($allIcons, $pokeIconBaby2);
}

//get id and input icon src
  $pokeIcon = $pObject->sprites->front_default;
  $id = $pObject->id;

//get all moves
for($i=0; $i< count($pObject->moves);$i++){
    array_push($allMoves, $pObject->moves[$i]->move->name);
}

//randomize moves, get the minimum or max 4 moves of the allMoves, put exception for ditto
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

//getting poke description in english
for ($x = 0; $x < count($pSpecies->flavor_text_entries); $x++) {
    if ($pSpecies->flavor_text_entries[$x]->language->name === "en") {
            $pokeDescription = $pSpecies->flavor_text_entries[$x]->flavor_text;
        }
    }
}
?>
<!====== HTML =======>
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
        <section  class="decoFrame">
        <section class="pokemonIcon">
            <img src="<?php echo $pokeIcon?>" class="pokeIcon">
            <p class="pokeName"><?php echo $pObject->name; ?></p>
        </section>
        </section>
        <section class="getInput">
            <form method="get" action="">
            <input id="input" type="text" name="name" placeholder="type a pokemon name!">
            <button type="submit" value="submit"  id="inputBtn" class="btn search">search</button>
            </form>
        </section>
    </section>

    <section class="P2">
        <section class=" box Descriptionbox">
            <p class="description"><?php  echo  $pokeDescription ?> </p>
        </section>
        <section class=" box movesList">
            <ul id="movesList">
               <?php echo implode('</br>',$movesArr); ?>
            </ul>
        </section>
        <section class=" box carouselEvolutions">
        <div class="arrows prev"> <i class="fas fa-arrow-left"></i></div>
            <?php for ($i=0;$i<= count($evolutionNames)-1;$i++){
                if(empty($evolutionNames)){
                    $evolutionNames = array('no evolutions');
                }
                echo '<div class="imgSlide">'.'<img src="'.$allIcons[$i].'">'.'<p>'.$evolutionNames[$i].'</p>'.'</div>';
            }
            ?>
        <div class="arrows next"> <i class="fas fa-arrow-right"></i> </div>
        </section>
        <section class="buttons">
            <button id="previousbtn" class="btn search"><i class="fas fa-arrow-left"></i></button>
            <button id="nextbtn" class="btn search"><i class="fas fa-arrow-right"></i></button>
        </section>
     </section>
</section>
<script src="assets/JS/toggle.js"></script>
<script src="https://kit.fontawesome.com/805c4ec2ae.js" crossorigin="anonymous"></script>
</body>
</html>
