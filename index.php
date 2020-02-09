<?php
ini_set("display_errors","1");

//get input user and start pokeapi when input is submitted
if(isset($_GET ['name'])){
$nameInput = $_GET ["name"];

//convert to Uppercase to lowercase
$name = strtolower($nameInput);

//get api and decode the json  into array
$Object = file_get_contents("https://pokeapi.co/api/v2/pokemon/".$name);
$Species = file_get_contents("https://pokeapi.co/api/v2/pokemon-species/".$name);
$pObject=json_decode($Object);
$pSpecies = json_decode($Species);

//get evolution chain
$evChain = file_get_contents($pSpecies->evolution_chain->url);
$evChainData = json_decode($evChain);

//set some important variables, evolution chain has three parts: first evolution aka the baby, 2nd evolution array and 3rd evolution array
$firstEvolution =  array();
$evChainArr1 = array();
$evChainArr2 =array();

//push src of icons into these arrays
$imgSrc1 = array();
$imgSrc2 = array();
$imgSrc3 = array();

//if there is evolution, check if input name is baby or not
 if($evChainData->chain->evolves_to[0] !== null ) {

    if ($evChainData->chain->species->name == $name) {
        array_push($firstEvolution, $name);
        $nameBaby = implode('<br>',$firstEvolution );
    } else if($evChainData->chain->species->name !== null) {
        array_push($firstEvolution, $evChainData->chain->species->name);
        $nameBaby = implode('<br>',$firstEvolution );
    }else{
         $nameBaby =$name;
    }

    //get img for baby
    $pokeEvApi = file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $nameBaby);
    $pokeEv = json_decode($pokeEvApi);
    $pokeIconBaby = $pokeEv->sprites->front_default;
    array_push($imgSrc1, $pokeIconBaby);

    //for each evolution1 get name
    for ($i = 0; $i <= count($evChainData->chain->evolves_to)- 1; $i++) {
        array_push($evChainArr1, $evChainData->chain->evolves_to[$i]->species->name);
    }
    //get icon of each evolution name
     foreach ($evChainArr1 as $name) {
         $pokeEvApi = file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $name);
         $pokeEv = json_decode($pokeEvApi);
         $pokeIconBaby = $pokeEv->sprites->front_default;
         array_push($imgSrc2, $pokeIconBaby);
     }
}else{
   //  array_push($imgSrc1, 'no more evolutions');
     array_push($imgSrc2, 'no more evolutions');
 }

//check If there is evolution2, get name and get icon
if($evChainData->chain->evolves_to[0]->evolves_to[0] !== null){
        for($i=0;$i < count($evChainData->chain->evolves_to[0]->evolves_to);$i++) {
            array_push($evChainArr2, $evChainData->chain->evolves_to[0]->evolves_to[$i]->species->name);
        }
        foreach ($evChainArr2 as $name){
        $pokeEvApi = file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $name);
        $pokeEv = json_decode($pokeEvApi);
        $pokeIconBaby2 = $pokeEv->sprites->front_default;
        array_push($imgSrc3, $pokeIconBaby2);
        }
    }else{
        array_push($evChainArr2, 'no more evolutions');
        array_push($imgSrc3, 'no more evolutions');
    }
//var_dump($imgSrc1, $imgSrc2, $imgSrc3);
//turn to string to echo in html
$evBaby = implode('</br>', $firstEvolution);
$ev2 = implode('</br>', $evChainArr1);
$ev3 = implode('</br>', $evChainArr2);
$allIcons = array_merge($imgSrc1,$imgSrc2,$imgSrc3);
var_dump($allIcons);

//get id and input icon src
    $pokeIcon = $pObject->sprites->front_default;
  $id = $pObject->id;

//get moves into array, this works
    $allMoves= array();
    for($i=0; $i< count($pObject->moves);$i++){
        array_push($allMoves, $pObject->moves[$i]->move->name);
    }

//randomize moves, get the minimum or max 4 moves of the allMoves length, put exception for ditto
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
<!======HTML=======>
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
            <img src="<?php echo $pokeIcon?>" class="pokeIcon">
            <p class="pokeName"><?php echo $pObject->name; ?></p>
        </section>

        <section class="getinput">
            <form method="get" action="">
            <input id="input" type="text" name="name" placeholder="type a pokemon name!">
            <button type="submit" value="submit"  id="inputBtn" class="btn search">search</button>
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
            <?php  foreach ($allIcons as $src) {
                echo '<img src='.$src.'>';
            } ?>
            <p class="evolutionName"><?php  echo $evBaby.'<br>'. $ev2.'<br>'. $ev3; ?></p>
        </section>

        <section class="buttons">
            <button id="previousbtn" class="btn search"><==</button>
            <button id="nextbtn" class="btn search">==></button>
        </section>
     </section>
</section>
<script src="assets/JS/toggle.js"></script>
</body>
</html>