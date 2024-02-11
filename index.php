<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dwes09</title>
    <style>
        body {
            background-color: lightgreen;
            font-family: 'Comic Sans MS';
            margin: 0;
        }
        header {
            background-image: url('bg.jpg');
            background-repeat: no-repeat;
            height: 125px;
            color: white;
            padding-top: 25px;
        }
        h1 {
            margin-left: 200px;
            text-shadow: 2px 2px 2px black;
        }
        .list select {
            margin-left: 50px;
            padding: 5px;
            font-size: large;
        }
        #info {
            margin-left: 50px;
            font-size: large;
            font-weight: bold;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function () {
    $("#select").on("change", function () {
        var selectedPokemon = $(this).val();
        if (selectedPokemon.trim() !== '') {
            getPokemonData(selectedPokemon);
        }
    });
    function getPokemonData(pokemonName) {
        $.ajax({
            url: "get_pokemon.php",
            type: "GET",
            data: {
                pokemonName: pokemonName
            },
            dataType: "json",
            success: function (data) {
                displayPokemonInfo(data);
            },
        });
    }
    function displayPokemonInfo(pokemonData) {
        $("#info").html(`
            <p><strong>nombre:</strong> ${pokemonData.name}</p>
            <p><strong>altura:</strong> ${pokemonData.height}</p>
            <p><strong>peso:</strong> ${pokemonData.weight}</p>
            <p><strong>experiencia base:</strong> ${pokemonData.base_experience}</p>
            <p><strong>habilidades:</strong> ${pokemonData.abilities.map(ability => 
                ability.ability.name).join(', ')}</p>
            <img src="${pokemonData.sprites.front_default}" alt="img">
        `);
    }
    });
    </script>
</head>
<body>
    <header>
    <h1>selecciona pokemon</h1>
    </header>
    <div class="list">
        <select id="select">
            <option value=""></option>
            <?php
            $pokemonNames = file_get_contents('https://pokeapi.co/api/v2/pokemon?limit=151');
            $pokemonNames = json_decode($pokemonNames, true);
            foreach ($pokemonNames['results'] as $pokemon) {
                echo "<option value='" . $pokemon['name'] 
                . "'>" . ucfirst($pokemon['name']) . "</option>";
            }
            ?>
        </select>
    </div>
    <div id="info"></div>
</body>
</html>