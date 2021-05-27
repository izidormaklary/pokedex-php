<?php
error_reporting(0);
ini_set('display_errors', 0);
# checking for input then fetching api

# functions called at the right place

class Poke {
    protected $json;
    protected string $name;
    protected int $id;
    protected string $imgUrl;
    protected array $moves;
    protected $evo;
    protected string $type;
    protected string $imgofPrev = "./resources/pokeball.png";
    protected string $disable ="";

    public function __construct( $ind=1)
    {
        $this->json = $this->fetchAPI($ind);
        $this->name = $this->json['name'];
        $this->id = $this->json['id'];
        $this->imgUrl = $this->json['sprites']['front_default'];
        $this->moves = $this->json['moves'];
        $this->type = $this->json ['types'][0]['type']['name'];
        $species = file_get_contents($this->json['species']['url']);
        $jsonSpecies = json_decode($species, true);
        $this->evo = $jsonSpecies['evolves_from_species'];
        if (is_null($this->evo)) {
            $this->evo= "no evo";
            $this->disable= "disabled";
        } else {
            $this->evo= $this->evo['name'];
            $prevJson = $this->fetchAPI($this->evo);
            $this->imgofPrev = $prevJson['sprites']['front_default'];
        }
    }
    function fetchAPI($index){
        $jsonObj = file_get_contents('https://pokeapi.co/api/v2/pokemon/' . $index);
        return json_decode($jsonObj, true);
    }

    public function getName() : string
    {
        return $this->name;
    }
    function prevPoke(){
        #skip the gaps
        if( $this->id === 1 ) {
            return 10220;
        }elseif ($this->id === 10001){
            return 898;
        }else {
            return $this->id - 1;
        }
    }
    function showMoves()
    {
        for ($i = 0; $i < 10 && $i < count($this->moves); $i++) {
            echo "<li>" . $this->moves[$i]['move']['name'] . "</li>";
        }

    }
    function nextPoke(){
        #skip the gaps
        if($this->id === 10220){
            return 1;
        }elseif ($this->id === 898){
            return 10001;
        }else {
            return $this->id + 1;
        }
    }

    public function getEvo()
    {
        return $this->evo;
    }

    public function getImgofPrev()
    {
        return $this->imgofPrev;
    }

    public function getDisable(): string
    {
        return $this->disable;
    }

    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    function showNameId()
    {
        return $this->name . " " . $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

}
if (isset($_GET['pokeId'])) {
    $poke = new Poke($_GET['pokeId']);
}else{
    $poke= new Poke();
}
# display image

# display name and id

# display 10 moves (or less)


# disables previous evolution button

# all types with rgb colour codes
function type()
{
global $poke;
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
    # matching the objects type with the right element from the array
    $colour = $type[$poke->getType()];
# returning the css compatible gradient with transparency edit
    return "rgba(".$colour." 1), rgba(".$colour." 0.3), rgba(".$colour." 1)";
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
            background-image:linear-gradient( <?php echo type() ?>) ;
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
            <img class='bigImg' src='<?php echo $poke->getImgUrl() ?>' width='200px' height="200px" alt='previous evoluton pokemon frontal'/>

            <p class='evoName'>Evolves from: <?php echo $poke->getEvo() ?> </p>
            <form  method="get">
                <input type="hidden" name="pokeId" value="<?php echo $poke->getEvo();?>" required />
                <button class="prevEvo" <?php echo $poke->getDisable(); ?> >
                <input type="hidden"  name="submit" value="Look for it" />
                <img class='evoImg' name="pokeId" src='<?php echo $poke->getImgofPrev() ; ?> ' width='100px' height="100px" alt='pokemon frontal'/>
                </button>
            </form>
        </div>
        <!--showing moves underneath-->
        <h2>Moves</h2>
        <ul>
        <?php $poke->showMoves(); ?>
        </ul>
    </div>
    <!-- right side of the display-->
    <div class="control" >
        <div>
            <!--calling name and id function -->
            <h1 class='nameID'> <?php echo $poke->showNameId(); ?> </h1>
        </div>
        <!-- form that sends the input-->
        <form  method="get">
            id or name of a pokemon  <input type="text" name="pokeId" required />
            <input class="search" type="submit" name="submit" value="Look for it" />
        </form>
        <!-- two forms with values according to the actual pokemons id (+-1), the submission sends the number and it considers as "pokeId"-->
        <form  method="get" class="prevnext prev">
            <input type="hidden" name="pokeId" value="<?php echo $poke->prevPoke();?>" required />
            <input class="search steps" type="submit" name="submit" value="<" />
        </form>
        <form  method="get" class="prevnext next">
            <input type="hidden" name="pokeId" value="<?php echo $poke->nextPoke();?>" required />
            <input class="search steps" type="submit" name="submit" value=">" />
        </form>

    </div>


</div>
</body>
</html>