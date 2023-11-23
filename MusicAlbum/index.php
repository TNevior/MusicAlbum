<?php
// Arquivo: index.php
// Página inicial do website
?>
<html>
<head>
    <style>
        body{background-color: black;

        }
    </style>
    <title>MusicAlbum</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>
<body>
    <nav class="navbar is-dark" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="index.php">
                <img src="logo.png" alt="Logo do sistema">
            </a>
        </div>
        <div class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="index.php">Início</a>
                <a class="navbar-item" href="cadastro.php">Cadastro</a>
                <a class="navbar-item" href="exibicao.php">Exibição</a>
            </div>
        </div>
    </nav>
    <section class="section">
        <div class="container">
            <h1 class="title has-text-white">Sistema de Cadastro de Álbum Musical</h1>
            <p class="subtitle has-text-white">Este é um website que permite o cadastro e a exibição de informações sobre álbuns musicais.</p>
            <p class="content has-text-white">Para cadastrar um álbum, você deve informar o nome do artista, o título do álbum, o ano de lançamento, o gênero musical e a capa do álbum. Você pode fazer isso na página de cadastro, clicando no botão abaixo.</p>
            <a class="button is-white is-outlined" href="cadastro.php">Cadastrar um álbum</a>
            <br></br>
            <p class="content has-text-white">Para ver os álbuns cadastrados, você pode acessar a página de exibição, clicando no botão abaixo. Lá, você poderá ver uma lista de todos os álbuns, com seus respectivos dados e imagens. Você também poderá filtrar os álbuns por artista, título, ano ou gênero.</p>
            <a class="button is-dark is-small" href="exibicao.php">Ver os álbuns cadastrados</a>
        </div>
    </section>
</body>
</html>
