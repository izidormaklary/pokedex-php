<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pokedex</title>
    <link rel="stylesheet" type="text/css" href="style.php">
</head>
<body>
<h1 class="header">
    Pokédex
</h1>


<?php
if (isset($_GET["pokeId"])) {
    $input = $_GET["pokeId"];
    $jsonObj = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $input) or exit("<h1> 404 poke not found </h1>");

    $json_data = json_decode($jsonObj, true);

}else{
    $jsonObj = file_get_contents('https://pokeapi.co/api/v2/pokemon/1');
    $json_data = json_decode($jsonObj, true);
}
    function showImg($obj) {
        $imgpath = $obj['sprites']['front_default'];
        echo "<img src='$imgpath' width='200px' alt='pokemon frontal'/>";
    }
    function showNameId($obj){
        echo  "<h1 class='nameID'>"   . $obj['name'] ." ". $obj['id'] . "</h1>" ;

    }
    function showMoves($obj){

    for ($i=0; $i < 10; $i++){
        echo "<li>"  . $obj['moves'][$i]['move']['name'] . "</li>" ;
    }
    }

?>


<div class="wrapper">

    <div class="dexCont" >

        <div class="showContent" id="dispImage">
            <?php
            showImg($json_data);
            ?>

        </div>
        <ul>
        <?php
        showMoves($json_data);
        ?>
        </ul>
    </div>
    <div class="control" >
        <div>
            <?php
            showNameId($json_data);
            ?>
        </div>
        <form  method="get">
            id or name of a pokemon  <input type="text" name="pokeId" required />
            <input class="search" type="submit" name="submit" value="Look for it" />
        </form>
    </div>

</div>
</body>
</html>