<?php
// Arquivo: conexao.php
// Cria uma conexão com o banco de dados SQLITE
try {
    $conexao = new PDO("sqlite:album.sqlite");
} catch (PDOException $e) {
    throw new Exception("Erro ao conectar com o banco de dados: " . $e->getMessage());
}


    // Se a tabela não existir, cria a tabela
    $createTable = "
        CREATE TABLE IF NOT EXISTS album (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            artista TEXT NOT NULL,
            titulo TEXT NOT NULL,
            ano INTEGER NOT NULL,
            genero TEXT NOT NULL,
            capa TEXT NOT NULL
        )
    ";

    $conexao->exec($createTable);

    echo "Tabela 'album' criada com sucesso.";


?>