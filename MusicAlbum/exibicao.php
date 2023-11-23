<?php
// Arquivo: exibicao.php
// Página de exibição dos álbuns musicais cadastrados
include "conexao.php";

// Recebe os dados do filtro, se houver
if (isset($_GET["filtro"])) {
    $filtro = $_GET["filtro"];
    $valor = $_GET["valor"];
}

// Prepara a consulta SQL para selecionar os dados da tabela album
$sql = "SELECT * FROM album";
if (isset($filtro) && isset($valor)) {
    // Adiciona uma cláusula WHERE na consulta SQL, de acordo com o filtro escolhido
    switch ($filtro) {
        case "artista":
            $sql .= " WHERE artista LIKE :valor";
            break;
        case "titulo":
            $sql .= " WHERE titulo LIKE :valor";
            break;
        case "ano":
            $sql .= " WHERE ano = :valor";
            break;
        case "genero":
            $sql .= " WHERE genero LIKE :valor";
            break;
    }
}
$stmt = $conexao->prepare($sql);
if (isset($filtro) && isset($valor)) {
    // Vincula o valor do filtro ao parâmetro da consulta SQL
    if ($filtro == "ano") {
        $stmt->bindParam(":valor", $valor, PDO::PARAM_INT);
    } else {
        $valor = "%" . $valor . "%";
        $stmt->bindParam(":valor", $valor, PDO::PARAM_STR);
    }
}

// Executa a consulta SQL
try {
    $stmt->execute();
    $albuns = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao selecionar os álbuns: " . $e->getMessage();
}
?>
<html>
<head>
<style>
        body{background-color: whitesmoke;

        }
    </style>
    <title>Exibição de Álbum Musical</title>
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
            <h1 class="title">Exibição de Álbum Musical</h1>
            <p class="subtitle">Veja os álbuns musicais cadastrados no sistema.</p>
            <form action="exibicao.php" method="get">
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label">Filtrar por:</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <div class="select">
                                    <select name="filtro">
                                        <option value="artista" <?php echo isset($filtro) && $filtro == "artista" ? "selected" : ""; ?>>Artista</option>
                                        <option value="titulo" <?php echo isset($filtro) && $filtro == "titulo" ? "selected" : ""; ?>>Título</option>
                                        <option value="ano" <?php echo isset($filtro) && $filtro == "ano" ? "selected" : ""; ?>>Ano</option>
                                        <option value="genero" <?php echo isset($filtro) && $filtro == "genero" ? "selected" : ""; ?>>Gênero</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input class="input" type="text" name="valor" value="<?php echo isset($valor) ? $valor : ""; ?>">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <input class="button is-black is-rounded is-outlined" type="submit" value="Filtrar">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            // Verifica se há álbuns cadastrados
            if (isset($albuns) && !empty($albuns)) {
                // Exibe os álbuns em uma tabela
                echo "<table class='table is-striped is-hoverable is-fullwidth'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Artista</th>";
                echo "<th>Título</th>";
                echo "<th>Ano</th>";
                echo "<th>Gênero</th>";
                echo "<th>Capa</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($albuns as $album) {
                    echo "<tr>";
                    echo "<td>" . $album["artista"] . "</td>";
                    echo "<td>" . $album["titulo"] . "</td>";
                    echo "<td>" . $album["ano"] . "</td>";
                    echo "<td>" . $album["genero"] . "</td>";
                    echo "<td><img src='imagens/" . $album["capa"] . "' alt='Capa do álbum' width='100' height='100'></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                // Exibe uma mensagem de que não há álbuns cadastrados
                echo "<div class='notification is-warning'>";
                echo "Não há álbuns cadastrados no sistema.";
                echo "</div>";
            }
            ?>
        </div>
    </section>
</body>
</html>
