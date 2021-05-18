
<?php
/*** set the content type header ***/
/*** Without this header, it wont work ***/
header("Content-type: text/css");


$font_family = 'Arial, Helvetica, sans-serif';
$font_size = '0.7em';
$border = '1px solid';
?>
@font-face {
    font-family: "pokemon";
    src: url("resources/poke.ttf") format("truetype");
}
@font-face {
    font-family:"Pixeboy";
    src: url("resources/Pixeboy-z8XGD.ttf") format("truetype");
}
body{
    background-color: #b0e6f8;
    font-family: Pixeboy;
}
h1{
text-align: center;
}
.header{
    color: rgb( 246, 197, 3 );
    margin-left: auto;
    width: 200px;
    margin-right: auto;
    font-family: pokemon;
    letter-spacing: 5px;
    font-size: 70px;
    text-shadow: 0px 0px 5px   rgba(0, 0, 0, 0.75);
}
.nameID{

    border-radius: 5px ;

    border: #92232e solid 10px;
    background-color: #25d27c;
    height: 100px;
    width: 300px;
    font-size: 40px;
    text-align: center;
    margin-right: auto;
    margin-left: auto;
    word-spacing: 20px;

    box-shadow: inset -2px 5px 3px 5px rgba(0, 0, 0, 0.2),
    -3px 3px 0px 2px rgba(0, 0, 0, 0.2);
    text-shadow: 0px 0px 1px   rgba(0, 0, 0, 0.75);
}

.wrapper{

    border-radius: 10px;
    display: grid;
    grid-template-columns: 50% 50%;
    width: 900px;
    margin-left: auto;
    margin-right: auto;
    height: 600px;

}
.dexCont{
    padding-top: 50px;

    border-radius: 20px;
    width: 430px;
    background-image: linear-gradient(60deg, rgba(127, 30, 36, 0.81), #d0464e);
    background-color: #bb2d3b;
    border-bottom: #7f1e24 solid 20px;
    border-left: #7f1e24 solid 20px;
    box-shadow:  -5px 10px 3px 5px #888888;
    z-index: 3;

}
.control{

    border-radius: 20px;
    width: 450px;
    background-image: linear-gradient(60deg, rgba(127, 30, 36, 0.81), #d0464e);
    background-color: #bb2d3b;
    height: 500px;
    position: relative;
    top: 40px;
    bottom: 0px;
    display: grid;
    text-align: center;
    border-bottom: #7f1e24 solid 20px;
    box-shadow:  -5px 10px 3px 5px #888888;

    padding: 20px;

}


.showContent{

    background-color: rgb(177, 176, 172);
    width: 300px;
    height:300px;
    margin-left: auto;
    margin-right: auto;
    box-shadow: inset -2px 5px 3px 5px rgba(0, 0, 0, 0.2),
    -3px 3px 0px 2px rgba(0, 0, 0, 0.2);
    border: #92232e solid 10px;
    border-radius: 5px ;
}
.search{

    text-align: center;
    background-color: #0a53be;
    color: rgb(255, 252, 224);
    font-size: 30px;
    padding: 10px;
    font-family: Pixeboy;
    margin-top: 20%;
    box-shadow: -3px 3px 0px 2px #09397f;
}
 .input{
    background-color: #25d27c;!important;
    height: 100px;
    width: 300px;
    font-size: 40px;
    text-align: center;
    margin-right: auto;
    margin-left: auto;
    font-family: Pixeboy;
    border-radius: 5px ;
    border: #92232e solid 10px;
    grid-area: input;
}
ul {
columns: 2;
-webkit-columns: 2;
-moz-columns: 2;
font-size: 20px;
}
.bigImg{
display: block;
margin-left: auto;
margin-right: auto;
}
.evoImg{
float:right;
}
.evoName{
display:inline-block;
font-size: 20px;
margin-top:40px;
margin-left: 10px;
width: 190px;
}
form{
font-size: 20px;
}
h2{
margin-left: 10px;
}