<?php

# checking for input then fetching api
if (isset($_GET["pokeId"])) {
    $input = $_GET["pokeId"];
    $jsonObj = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $input) or exit("<h1> 404 poke not found </h1>");
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

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pokedex</title>
    <link rel="stylesheet" type="text/css" href="style.css">
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
            <img class='bigImg' src='<?php echo showImg($json_data); ?>' width='200px' alt='previous evoluton pokemon frontal'/>

            <p class='evoName'>Evolves from: <?php echo showEvo($jsonSpecies); ?> </p>
            <img class='evoImg' src='<?php echo imgOfprev(showEvo($jsonSpecies) ); ?> ' width='100px' alt='pokemon frontal'/>
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
    </div>

</div>
</body>
</html>