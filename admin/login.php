<?php
session_start();
require_once __DIR__ . '/conexao.php';

$error = '';

// Se já estiver logado, redireciona para o Dashboard ADM
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

// Processamento do Login via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios_admin WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['senha_hash'])) {
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_nome'] = $user['nome'];
                $_SESSION['admin_email'] = $user['email'];
                $_SESSION['admin_logged_in'] = true;

                header('Location: index.php');
                exit;
            } else {
                $error = 'E-mail ou senha inválidos! Verifique seus dados.';
            }
        } catch (PDOException $e) {
            $error = 'Erro no sistema de autenticação: ' . $e->getMessage();
        }
    } else {
        $error = 'Por favor, preencha todos os campos.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel ADM | Login Oficial - Prefeitura de Canindé de São Francisco</title>
    
    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        caninde: {
                            gold: '#eab308',
                            amber: '#d97706',
                            dark: '#0f172a'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans min-h-screen flex items-center justify-center p-4 selection:bg-amber-500 selection:text-slate-950">

    <div class="max-w-md w-full">
        
        <!-- Logo Oficial e Nome Uniformizado da Prefeitura -->
        <div class="text-center mb-8">
            <a href="../index.php" class="inline-flex flex-col items-center gap-3 group">
                <img src="../assets/images/brasao_oficial.png" alt="Brasão Oficial de Canindé de São Francisco" class="h-20 w-auto object-contain drop-shadow-xl group-hover:scale-105 transition-transform">
                <div class="flex flex-col items-center">
                    <span class="text-xs tracking-widest text-amber-400 font-bold uppercase">Prefeitura de</span>
                    <span class="text-xl font-extrabold tracking-tight text-white">CANINDÉ DE SÃO FRANCISCO</span>
                    <span class="text-xs text-slate-400 mt-1 font-semibold">Portal de Turismo • Painel ADM</span>
                </div>
            </a>
        </div>

        <!-- Card de Formulário Estilizado -->
        <div class="bg-slate-900 rounded-3xl p-8 border border-slate-800 shadow-2xl relative">
            
            <div class="mb-6">
                <h1 class="text-xl font-extrabold text-white">Acesso do Administrador</h1>
                <p class="text-xs text-slate-400 mt-1">Informe seu e-mail institucional e senha para acessar o painel de controle.</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs p-3.5 rounded-xl mb-6 flex items-center gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-base shrink-0"></i>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">E-mail do Administrador</label>
                    <div class="relative">
                        <input type="email" name="email" required value="admin@caninde.se.gov.br" placeholder="admin@caninde.se.gov.br" class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-800 border border-slate-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-sm text-white focus:outline-none transition">
                        <i class="fa-solid fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Senha de Acesso</label>
                    <div class="relative">
                        <input type="password" name="password" required value="admin123" placeholder="••••••••" class="w-full pl-10 pr-4 py-3 rounded-xl bg-slate-800 border border-slate-700 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 text-sm text-white focus:outline-none transition">
                        <i class="fa-solid fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold py-3.5 rounded-xl shadow-lg shadow-amber-500/20 transition text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Entrar no Painel ADM</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 border-t border-slate-800 pt-4 text-center">
                <p class="text-[11px] text-slate-500 mb-2">Credenciais padrão para testes: <strong>admin@caninde.se.gov.br</strong> / <strong>admin123</strong></p>
                <a href="../index.php" class="inline-flex items-center gap-1.5 text-xs text-amber-400 hover:text-amber-300 font-bold transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i> Voltar para a Página Inicial do Site
                </a>
            </div>

        </div>

    </div>

</body>
</html>
