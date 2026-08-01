<?php
session_start();

// 1. Verificação Estrita de Sessão ADM
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/conexao.php';

$msg = '';
$msgType = 'success';

// 2. Processamento das Ações: "Aprovar" e "Recusar"
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int)$_GET['id'];

    try {
        if ($action === 'aprovar') {
            $stmt = $pdo->prepare("UPDATE restaurantes SET status = 'aprovado' WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $msg = 'Restaurante #' . $id . ' aprovado com sucesso! Agora está visível publicamente no portal.';
            $msgType = 'success';
        } elseif ($action === 'recusar') {
            $stmt = $pdo->prepare("DELETE FROM restaurantes WHERE id = :id AND status = 'pendente'");
            $stmt->execute(['id' => $id]);
            $msg = 'Solicitação de cadastro #' . $id . ' foi recusada e removida do banco de dados.';
            $msgType = 'warning';
        }
    } catch (PDOException $e) {
        $msg = 'Erro ao processar ação no banco MySQL: ' . $e->getMessage();
        $msgType = 'error';
    }
}

// 3. Consulta de Métricas e Dados no MySQL
try {
    $totalCount = $pdo->query("SELECT COUNT(*) FROM restaurantes")->fetchColumn();
    $pendingCount = $pdo->query("SELECT COUNT(*) FROM restaurantes WHERE status = 'pendente'")->fetchColumn();
    $approvedCount = $pdo->query("SELECT COUNT(*) FROM restaurantes WHERE status = 'aprovado'")->fetchColumn();

    // Consulta de Restaurantes Pendentes
    $stmtPending = $pdo->query("SELECT * FROM restaurantes WHERE status = 'pendente' ORDER BY id DESC");
    $pendingList = $stmtPending->fetchAll();

    // Consulta de Restaurantes Aprovados
    $stmtApproved = $pdo->query("SELECT * FROM restaurantes WHERE status = 'aprovado' ORDER BY id DESC");
    $approvedList = $stmtApproved->fetchAll();
} catch (PDOException $e) {
    die("Erro ao consultar o banco de dados MySQL: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Restrito | CONEXÃO CÂNIONS - Painel ADM</title>
    
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
                            sertao: '#15803d',
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
<body class="bg-slate-950 text-slate-100 font-sans min-h-screen flex flex-col">

    <!-- CABEÇALHO / NAV SUPERIOR DO PAINEL ADM -->
    <header class="bg-slate-900 border-b border-slate-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo e Nome CONEXÃO CÂNIONS -->
                <div class="flex items-center gap-3">
                    <img src="../assets/images/logo_icon.png" alt="Conexão Cânions" class="w-10 h-10 sm:w-12 sm:h-12 object-contain shrink-0 drop-shadow-md">
                    <div class="flex flex-col">
                        <span class="text-base sm:text-xl font-black tracking-tight text-white">
                            CONEXÃO <span class="text-amber-500">CÂNIONS</span>
                        </span>
                        <span class="text-[10px] text-amber-400 font-bold tracking-wider uppercase">
                            Painel de Administração • Velho Chico
                        </span>
                    </div>
                </div>

                <!-- Botões e Perfil -->
                <div class="flex items-center gap-4">
                    <a href="../index.php" target="_blank" class="hidden sm:inline-flex items-center gap-2 text-xs font-bold text-slate-300 hover:text-amber-400 bg-slate-800 hover:bg-slate-700/80 px-4 py-2 rounded-xl border border-slate-700 transition">
                        <i class="fa-solid fa-globe text-amber-400"></i> Ver Portal Público
                    </a>

                    <div class="flex items-center gap-3 pl-4 border-l border-slate-800">
                        <div class="w-9 h-9 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center font-extrabold text-sm">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <div class="hidden md:flex flex-col">
                            <span class="text-xs font-bold text-white"><?php echo htmlspecialchars($_SESSION['admin_nome'] ?? 'Administrador'); ?></span>
                            <span class="text-[10px] text-slate-400"><?php echo htmlspecialchars($_SESSION['admin_email'] ?? 'admin@caninde.se.gov.br'); ?></span>
                        </div>
                        <a href="logout.php" class="p-2 text-slate-400 hover:text-rose-400 transition" title="Sair da Conta">
                            <i class="fa-solid fa-power-off text-lg"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- CONTEÚDO DO DASHBOARD -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Alerta de Notificação -->
        <?php if ($msg): ?>
            <div class="<?php echo $msgType === 'warning' ? 'bg-amber-500/10 border-amber-500/30 text-amber-400' : ($msgType === 'error' ? 'bg-rose-500/10 border-rose-500/30 text-rose-400' : 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400'); ?> border text-sm p-4 rounded-2xl mb-8 flex items-center justify-between shadow-lg">
                <div class="flex items-center gap-3">
                    <i class="fa-solid <?php echo $msgType === 'warning' ? 'fa-triangle-exclamation' : ($msgType === 'error' ? 'fa-xmark-circle' : 'fa-circle-check'); ?> text-lg"></i>
                    <span class="font-medium"><?php echo htmlspecialchars($msg); ?></span>
                </div>
                <a href="index.php" class="text-xs font-bold underline hover:opacity-80">OK</a>
            </div>
        <?php endif; ?>

        <!-- Título do Dashboard -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Painel de Controle de Turismo</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">Conectado ao banco MySQL do Laragon (<code class="text-amber-400">turismo_caninde</code>).</p>
            </div>
            
            <a href="../restaurantes.php" target="_blank" class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold px-4 py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 border border-slate-700 transition">
                <i class="fa-solid fa-utensils text-amber-400"></i>
                <span>Ver Guia Gastronômico Público</span>
            </a>
        </div>

        <!-- CARDS DE MÉTRICAS -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            
            <div class="bg-slate-900 rounded-2xl p-6 border border-slate-800 flex items-center justify-between shadow-lg">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total de Restaurantes</span>
                    <span class="block text-3xl font-black text-white mt-1"><?php echo $totalCount; ?></span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-800 text-amber-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-store"></i>
                </div>
            </div>

            <div class="bg-slate-900 rounded-2xl p-6 border border-amber-500/30 flex items-center justify-between shadow-lg">
                <div>
                    <span class="text-xs font-bold text-amber-400 uppercase tracking-wider">Pendentes de Aprovação</span>
                    <span class="block text-3xl font-black text-amber-400 mt-1"><?php echo $pendingCount; ?></span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-clock font-bold"></i>
                </div>
            </div>

            <div class="bg-slate-900 rounded-2xl p-6 border border-emerald-500/30 flex items-center justify-between shadow-lg">
                <div>
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Aprovados no Site</span>
                    <span class="block text-3xl font-black text-emerald-400 mt-1"><?php echo $approvedCount; ?></span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>

        </div>

        <!-- 1. TABELA DE RESTAURANTES PENDENTES (REQUISITO PRINCIPAL DA FASE 1) -->
        <div class="bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden shadow-xl mb-12">
            
            <div class="p-6 border-b border-slate-800 flex items-center justify-between bg-slate-900/90">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Solicitações de Restaurantes Pendentes</h2>
                        <p class="text-xs text-slate-400">Analise os cadastros enviados e utilize os botões para Aprovar ou Recusar.</p>
                    </div>
                </div>
                
                <span class="bg-amber-500/20 text-amber-400 text-xs font-extrabold px-3 py-1 rounded-full border border-amber-500/40 uppercase">
                    <?php echo count($pendingList); ?> Pendentes
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-800/90 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Nome do Restaurante</th>
                            <th class="px-6 py-4">Cidade</th>
                            <th class="px-6 py-4">Categoria</th>
                            <th class="px-6 py-4">Prato Destaque</th>
                            <th class="px-6 py-4">Telefone / Endereço</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Ações de Análise</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php if (empty($pendingList)): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-slate-500 italic">
                                    <i class="fa-solid fa-circle-check text-3xl text-emerald-500/50 block mb-3"></i>
                                    Nenhum cadastro pendente de aprovação no momento.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pendingList as $item): ?>
                                <tr class="hover:bg-slate-800/40 transition">
                                    <td class="px-6 py-4 text-slate-500 font-mono">#<?php echo $item['id']; ?></td>
                                    <td class="px-6 py-4 font-extrabold text-white text-sm">
                                        <?php echo htmlspecialchars($item['nome']); ?>
                                        <span class="block text-[10px] text-slate-400 font-normal">Cadastrado em: <?php echo date('d/m/Y H:i', strtotime($item['criado_em'])); ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-amber-500/10 text-amber-300 border border-amber-500/20 px-2 py-0.5 rounded text-[10px] font-bold">
                                            <?php echo htmlspecialchars($item['cidade'] ?? 'Canindé de São Francisco'); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-slate-800 text-amber-400 border border-slate-700 px-2.5 py-1 rounded-md text-[10px] font-bold">
                                            <?php echo htmlspecialchars($item['categoria']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-200">
                                        <?php echo htmlspecialchars($item['prato_destaque']); ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="block font-bold text-emerald-400"><?php echo htmlspecialchars($item['telefone']); ?></span>
                                        <span class="text-slate-400 text-[11px]"><?php echo htmlspecialchars($item['endereco']); ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-amber-500/20 text-amber-400 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase border border-amber-500/30 inline-flex items-center gap-1">
                                            <i class="fa-solid fa-clock text-[9px]"></i> Pendente
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Botão Aprovar -->
                                            <a href="index.php?action=aprovar&id=<?php echo $item['id']; ?>" class="bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold px-3.5 py-2 rounded-xl text-xs flex items-center gap-1.5 transition shadow-md shadow-emerald-900/20" title="Aprovar e publicar no site">
                                                <i class="fa-solid fa-check"></i> Aprovar
                                            </a>

                                            <!-- Botão Recusar -->
                                            <a href="index.php?action=recusar&id=<?php echo $item['id']; ?>" onclick="return confirm('Tem certeza que deseja recusar este cadastro?')" class="bg-rose-600/80 hover:bg-rose-600 text-white font-extrabold px-3.5 py-2 rounded-xl text-xs flex items-center gap-1.5 transition shadow-md" title="Recusar cadastro">
                                                <i class="fa-solid fa-xmark"></i> Recusar
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- 2. TABELA DE RESTAURANTES APROVADOS E ATIVOS NO SITE -->
        <div class="bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden shadow-xl">
            
            <div class="p-6 border-b border-slate-800 flex items-center justify-between bg-slate-900/90">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-white">Restaurantes Aprovados & Ativos no Portal</h2>
                        <p class="text-xs text-slate-400">Estabelecimentos visíveis para os turistas no site principal.</p>
                    </div>
                </div>
                
                <span class="bg-emerald-500/20 text-emerald-400 text-xs font-extrabold px-3 py-1 rounded-full border border-emerald-500/40 uppercase">
                    <?php echo count($approvedList); ?> Aprovados
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-800/90 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Nome do Restaurante</th>
                            <th class="px-6 py-4">Cidade</th>
                            <th class="px-6 py-4">Categoria</th>
                            <th class="px-6 py-4">Prato Destaque</th>
                            <th class="px-6 py-4">Telefone</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php foreach ($approvedList as $item): ?>
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="px-6 py-4 text-slate-500 font-mono">#<?php echo $item['id']; ?></td>
                                <td class="px-6 py-4 font-extrabold text-white">
                                    <?php echo htmlspecialchars($item['nome']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-amber-500/10 text-amber-300 border border-amber-500/20 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <?php echo htmlspecialchars($item['cidade'] ?? 'Canindé de São Francisco'); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-slate-800 text-slate-300 border border-slate-700 px-2 py-0.5 rounded text-[10px] font-bold">
                                        <?php echo htmlspecialchars($item['categoria']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-300">
                                    <?php echo htmlspecialchars($item['prato_destaque']); ?>
                                </td>
                                <td class="px-6 py-4 font-semibold text-emerald-400">
                                    <?php echo htmlspecialchars($item['telefone']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-emerald-500/20 text-emerald-400 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border border-emerald-500/30">
                                        Aprovado
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </main>

    <!-- RODAPÉ ADM -->
    <footer class="bg-slate-900 border-t border-slate-800 py-6 text-center text-xs text-slate-500 mt-12">
        <p>© <?php echo date('Y'); ?> Prefeitura Municipal de Canindé de São Francisco - Sergipe. Sistema de Administração do Portal de Turismo.</p>
    </footer>

</body>
</html>
