<?php
// Arquivo: cadastro.php
// Página de cadastro de álbum musical
include "conexao.php";

// Verifica se o formulário foi enviado
if (isset($_POST["enviar"])) {
    // Recebe os dados do formulário
    $artista = $_POST["artista"];
    $titulo = $_POST["titulo"];
    $ano = $_POST["ano"];
    $genero = $_POST["genero"];
    $capa = $_FILES["capa"];

    // Valida os dados do formulário
    $erros = array();
    if (empty($artista)) {
        $erros[] = "O nome do artista é obrigatório.";
    }
    if (empty($titulo)) {
        $erros[] = "O título do álbum é obrigatório.";
    }
    if (empty($ano)) {
        $erros[] = "O ano de lançamento é obrigatório.";
    } elseif (!is_numeric($ano) || $ano < 1900 || $ano > date("Y")) {
        $erros[] = "O ano de lançamento deve ser um número entre 1900 e o ano atual.";
    }
    if (empty($genero)) {
        $erros[] = "O gênero musical é obrigatório.";
    }
    if (empty($capa["name"])) {
        $erros[] = "A capa do álbum é obrigatória.";
    } elseif ($capa["error"] != 0) {
        $erros[] = "Ocorreu um erro ao enviar a capa do álbum.";
    } elseif ($capa["size"] > 2 * 1024 * 1024) {
        $erros[] = "A capa do álbum deve ter no máximo 2 MB.";
    } elseif (!in_array($capa["type"], array("image/jpeg", "image/png"))) {
        $erros[] = "A capa do álbum deve ser uma imagem JPG ou PNG.";
    }

    // Se não houver erros, salva os dados no banco de dados
    if (empty($erros)) {
        // Move a capa do álbum para a pasta de imagens
        $extensao = pathinfo($capa["name"], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid() . "." . $extensao;
        $caminho_arquivo = "imagens/" . $nome_arquivo;
        move_uploaded_file($capa["tmp_name"], $caminho_arquivo);

        // Prepara a consulta SQL para inserir os dados na tabela album
        $sql = "INSERT INTO album (artista, titulo, ano, genero, capa) VALUES (:artista, :titulo, :ano, :genero, :capa)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(":artista", $artista);
        $stmt->bindParam(":titulo", $titulo);
        $stmt->bindParam(":ano", $ano);
        $stmt->bindParam(":genero", $genero);
        $stmt->bindParam(":capa", $nome_arquivo);

        // Executa a consulta SQL
        try {
            $stmt->execute();
            $sucesso = "Álbum cadastrado com sucesso.";
        } catch (PDOException $e) {
            $erros[] = "Erro ao cadastrar o álbum: " . $e->getMessage();
        }
    }
}
?>
<html>
<head>
<style>
        body{background-color: black;

        }
    </style>
    <title>Cadastro de Álbum Musical</title>
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
            <h1 class="title has-text-white">Cadastro de Álbum Musical</h1>
            <p class="subtitle has-text-white">Preencha o formulário abaixo para cadastrar um álbum musical.</p>
            <?php
            // Exibe as mensagens de erro ou sucesso, se houver
            if (isset($erros) && !empty($erros)) {
                echo "<div class='notification is-danger'>";
                echo "<ul>";
                foreach ($erros as $erro) {
                    echo "<li>$erro</li>";
                }
                echo "</ul>";
                echo "</div>";
            }
            if (isset($sucesso) && !empty($sucesso)) {
                echo "<div class='notification is-success'>";
                echo $sucesso;
                echo "</div>";
            }
            ?>
            <form action="cadastro.php" method="post" enctype="multipart/form-data">
                <div class="field">
                    <label class="label has-text-white">Artista</label>
                    <div class="control">
                        <input class="input" type="text" name="artista" value="<?php echo isset($artista) ? $artista : ''; ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label has-text-white">Título</label>
                    <div class="control">
                        <input class="input" type="text" name="titulo" value="<?php echo isset($titulo) ? $titulo : ''; ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label has-text-white">Ano</label>
                    <div class="control">
                        <input class="input" type="number" name="ano" value="<?php echo isset($ano) ? $ano : ''; ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label has-text-white">Gênero</label>
                    <div class="control">
                        <input class="input" type="text" name="genero" value="<?php echo isset($genero) ? $genero : ''; ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label has-text-white">Capa</label>
                    <div class="control">
                        <input class="input" type="file" name="capa" accept="image/jpeg, image/png">
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <input class="button is-white is-rounded is-outlined" type="submit" name="enviar" value="Enviar">
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
