<?php
error_reporting(0);
ini_set('display_errors', 0);
# checking for input then fetching api
if (isset($_GET["pokeId"])) {
    $input = $_GET["pokeId"];



    $jsonObj = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $input);
    if(false === $jsonObj){ $jsonObj = file_get_contents('https://pokeapi.co/api/v2/pokemon/1');}
    #or exit(register_shutdown_function('shutdown'));
    $json_data = json_decode($jsonObj, true);

    $species = file_get_contents($json_data['species']['url']);
    $jsonSpecies = json_decode($species, true);
} else {
    # default link that leads to the first pokemon
    $jsonObj = file_get_contents('https://pokeapi.co/api/v2/pokemon/1');
    $json_data = json_decode($jsonObj, true);

    $species = file_get_contents('https://pokeapi.co/api/v2/pokemon-species/1');
    $jsonSpecies = json_decode($species, true);
}
function increase($obj){
    global $input;
    $input = $obj['id'] + 1;
}
# functions called at the right place

# display image
function showImg($obj)
{
    $imgpath = $obj['sprites']['front_default'];
    return $imgpath;
}
# display name and id
function showNameId($obj)
{
   return $obj['name'] . " " . $obj['id'];
}
# display 10 moves (or less)
function showMoves($obj)
{
    for ($i = 0; $i < 10 && $i < count($obj['moves']); $i++) {
        echo "<li>" . $obj['moves'][$i]['move']['name'] . "</li>";
    }

}
# previous evolution
function showEvo($obj)
{
    # firstly checking if there is previous evo
    $evo = $obj['evolves_from_species'];
    if (is_null($evo)) {
        return "no evo";
    } else {
        return $evo['name'];
    }
}
# display image of previous evo
function imgOfprev($input)
{
    if ($input === "no evo"){
        return "./resources/pokeball.png";
    }else{
    $prevPoke = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $input);
    $prevJson = json_decode($prevPoke, true);
    $imgpath = $prevJson['sprites']['front_default'];
    return $imgpath;
    }
}
function nextPoke($obj){
    return $obj['id'] + 1;
}
function prevPoke($obj){
    if( $obj['id'] === 1 ) {
        return 1;
    }else{
        return $obj['id'] - 1;
    }
}
function disableButton($input)
{
    if ($input === "no evo") {
        return "disabled";
    }
}
function type($obj)
{

    $type = array(
        "normal" => "144,	153,	161,",
        "fighting" => "206,	64,	105,",
        "flying" => "143,	167,	221,",
        "poison" => "170,	106,	200,",
        "ground" => "216,	119,	70,",
        "rock" => "198,	184,	139,",
        "bug" => "143,	193,	45,",
        "ghost" => "126,	184,	35,",
        "steel" => "90,	142,	161,",
        "fire" => "90,	142,	161,",
        "water" => "76,	144,	212,",
        "grass" => "99,	188,	91,",
        "electric" => "244,	209,	60,",
        "psychic" => "249,	113,	118,",
        "ice" => "116,	206,	192,",
        "dragon" => "12,	109,	196,",
        "dark" => "91,	83,	102,",
        "fairy" => "236,	143,	230,",
        "unknown" => "236,	143,	230,",
        "shadow" => "236,	143,	230,",
    );
    $typeObject = $obj['types'][0]['type']['name'];
    $colour = $type["$typeObject"];

    return "rgba(".$colour." 1), rgba(".$colour." 0.3), rgba(".$colour." 1)";
}


function shutdown()
{
    // This is our shutdown function, in
    // here we can do any last operations
    // before the script is complete.

    echo 'Script executed with success', PHP_EOL;
}


?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pokedex</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body{
            background-image:linear-gradient( <?php echo type($json_data) ?>) ;
        }
    </style>
</head>
<body>
<h1 class="header">
    Pokédex
</h1>
<!-- wrapper for contents-->
<div class="wrapper">

    <!-- left side of the pokedex-->
    <div class="dexCont" >

        <div class="showContent" id="dispImage">
            <!-- calling functions inside of the display-->
            <img class='bigImg' src='<?php echo showImg($json_data); ?>' width='200px' height="200px" alt='previous evoluton pokemon frontal'/>

            <p class='evoName'>Evolves from: <?php echo showEvo($jsonSpecies); ?> </p>
            <form  method="get">
                <input type="hidden" name="pokeId" value="<?php echo showEvo($jsonSpecies);?>" required />
                <button class="prevEvo" <?php echo disableButton(showEvo($jsonSpecies)); ?> >
                <input type="hidden"  name="submit" value="Look for it" />
                <img class='evoImg' name="pokeId" src='<?php echo imgOfprev(showEvo($jsonSpecies) ); ?> ' width='100px' height="100px" alt='pokemon frontal'/>
                </button>
            </form>
        </div>
        <!--showing moves underneath-->
        <h2>Moves</h2>
        <ul>
        <?php showMoves($json_data); ?>
        </ul>
    </div>
    <!-- right side of the display-->
    <div class="control" >
        <div>
            <!--calling name and id function -->
            <h1 class='nameID'> <?php echo showNameId($json_data); ?> </h1>
        </div>
        <!-- form that sends the input-->
        <form  method="get">
            id or name of a pokemon  <input type="text" name="pokeId" required />
            <input class="search" type="submit" name="submit" value="Look for it" />
        </form>

        <form  method="get" class="prevnext prev">
            <input type="hidden" name="pokeId" value="<?php echo prevPoke($json_data);?>" required />
            <input class="search steps" type="submit" name="submit" value="<" />
        </form>
        <form  method="get" class="prevnext next">
            <input type="hidden" name="pokeId" value="<?php echo nextPoke($json_data);?>" required />
            <input class="search steps" type="submit" name="submit" value=">" />
        </form>

    </div>


</div>
</body>
</html>