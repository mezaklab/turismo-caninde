<?php
// Arquivo de Conexão PDO com o Banco MySQL do Laragon
$host = '127.0.0.1';
$dbname = 'turismo_caninde';
$username = 'root';
$password = '';

try {
    // Tenta conectar ao banco turismo_caninde
    $pdo = new PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Migration automática: garante existência da coluna 'cidade' na tabela restaurantes
    try {
        $pdo->exec("ALTER TABLE `restaurantes` ADD COLUMN `cidade` VARCHAR(100) NOT NULL DEFAULT 'Canindé de São Francisco'");
    } catch (PDOException $ex) {
        // Coluna já existente
    }
} catch (PDOException $e) {
    // Se o banco ainda não existir, tenta criar e rodar o script SQL de inicialização
    try {
        $pdo = new PDO("mysql:host={$host};charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $sqlPath = file_exists(__DIR__ . '/setup_database.sql') ? __DIR__ . '/setup_database.sql' : __DIR__ . '/../setup_database.sql';
        if (file_exists($sqlPath)) {
            $sql = file_get_contents($sqlPath);
            $pdo->exec($sql);
            $pdo->exec("USE `{$dbname}`");
        } else {
            die("Erro de conexão com o MySQL: " . $e->getMessage());
        }
    } catch (PDOException $ex) {
        die("Erro crítico de conexão com o banco MySQL do Laragon: " . $ex->getMessage());
    }
}
?>
