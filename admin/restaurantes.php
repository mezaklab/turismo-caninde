<?php
require_once __DIR__ . '/auth.php';
checkAuth();

$dataFile = __DIR__ . '/../data/restaurants.json';
$restaurants = [];

if (file_exists($dataFile)) {
    $restaurants = json_decode(file_get_contents($dataFile), true) ?? [];
}

$msg = '';

// Adição Direta de Restaurante pelo Admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_restaurant'])) {
    $newId = empty($restaurants) ? 1 : max(array_column($restaurants, 'id')) + 1;
    $newRestaurant = [
        'id' => $newId,
        'name' => trim($_POST['name'] ?? ''),
        'category' => trim($_POST['category'] ?? ''),
        'category_slug' => trim($_POST['category_slug'] ?? 'variada'),
        'specialty' => trim($_POST['specialty'] ?? ''),
        'description' => trim($_POST['description'] ?? ''),
        'location' => trim($_POST['location'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'hours' => trim($_POST['hours'] ?? 'Seg a Dom'),
        'tag' => trim($_POST['tag'] ?? 'Recomendado'),
        'image' => 'assets/images/canions_xingo.jpg',
        'status' => 'aprovado',
        'created_at' => date('Y-m-d')
    ];

    $restaurants[] = $newRestaurant;
    file_put_contents($dataFile, json_encode($restaurants, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $msg = 'Novo restaurante cadastrado e publicado com sucesso!';
}

// Alteração de Status ou Exclusão
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $targetId = (int)$_GET['id'];

    if ($action === 'delete') {
        $restaurants = array_filter($restaurants, fn($r) => $r['id'] !== $targetId);
        $msg = 'Restaurante removido.';
    } else {
        foreach ($restaurants as &$item) {
            if ($item['id'] === $targetId) {
                if ($action === 'approve') $item['status'] = 'aprovado';
                if ($action === 'reject') $item['status'] = 'rejeitado';
            }
        }
    }
    file_put_contents($dataFile, json_encode(array_values($restaurants), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Restaurantes | Painel ADM Canindé</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans min-h-screen flex flex-col">

    <!-- HEADER -->
    <header class="bg-slate-900 border-b border-slate-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="index.php" class="flex items-center gap-3">
                    <img src="../assets/images/brasao_oficial.png" alt="Brasão Canindé" class="h-12 w-auto object-contain">
                    <div class="flex flex-col">
                        <span class="text-[10px] tracking-widest text-amber-400 font-bold uppercase">Painel de Administração</span>
                        <span class="text-base font-extrabold text-white">CANINDÉ DE SÃO FRANCISCO</span>
                    </div>
                </a>

                <div class="flex items-center gap-4">
                    <a href="index.php" class="text-xs font-bold text-slate-300 hover:text-amber-400 flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left"></i> Voltar ao Dashboard
                    </a>
                    <a href="logout.php" class="p-2 text-slate-400 hover:text-rose-400 transition">
                        <i class="fa-solid fa-power-off text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTEÚDO PRINCIPAL -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <?php if ($msg): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm p-4 rounded-2xl mb-8 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span><?php echo $msg; ?></span>
                </div>
                <a href="restaurantes.php" class="text-xs underline hover:text-white">Fechar</a>
            </div>
        <?php endif; ?>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white">Gerenciamento de Restaurantes</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">Aprove, edite ou adicione estabelecimentos gastronômicos no portal.</p>
            </div>

            <button onclick="toggleModal('add-modal')" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold px-5 py-3 rounded-xl text-xs flex items-center justify-center gap-2 shadow-lg transition">
                <i class="fa-solid fa-plus-circle text-sm"></i>
                <span>Novo Restaurante</span>
            </button>
        </div>

        <!-- LISTA DE RESTAURANTES -->
        <div class="bg-slate-900 rounded-3xl border border-slate-800 overflow-hidden shadow-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-300">
                    <thead class="bg-slate-800/80 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Nome do Restaurante</th>
                            <th class="px-6 py-4">Categoria</th>
                            <th class="px-6 py-4">Telefone</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php foreach ($restaurants as $item): ?>
                            <tr class="hover:bg-slate-800/50 transition">
                                <td class="px-6 py-4 text-slate-500 font-mono">#<?php echo $item['id']; ?></td>
                                <td class="px-6 py-4 font-bold text-white">
                                    <?php echo htmlspecialchars($item['name']); ?>
                                    <span class="block font-normal text-[11px] text-slate-400"><?php echo htmlspecialchars($item['specialty']); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="bg-slate-800 text-slate-300 px-2.5 py-1 rounded-md text-[10px] font-bold">
                                        <?php echo htmlspecialchars($item['category']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-emerald-400">
                                    <?php echo htmlspecialchars($item['phone']); ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if (($item['status'] ?? '') === 'aprovado'): ?>
                                        <span class="bg-emerald-500/20 text-emerald-400 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border border-emerald-500/30">Aprovado</span>
                                    <?php elseif (($item['status'] ?? '') === 'pendente'): ?>
                                        <span class="bg-amber-500/20 text-amber-400 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border border-amber-500/30">Pendente</span>
                                    <?php else: ?>
                                        <span class="bg-rose-500/20 text-rose-400 px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase border border-rose-500/30">Rejeitado</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <?php if (($item['status'] ?? '') !== 'aprovado'): ?>
                                            <a href="restaurantes.php?action=approve&id=<?php echo $item['id']; ?>" class="p-2 bg-emerald-600/80 hover:bg-emerald-600 text-white rounded-lg text-xs" title="Aprovar">
                                                <i class="fa-solid fa-check"></i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (($item['status'] ?? '') !== 'rejeitado'): ?>
                                            <a href="restaurantes.php?action=reject&id=<?php echo $item['id']; ?>" class="p-2 bg-amber-600/80 hover:bg-amber-600 text-white rounded-lg text-xs" title="Rejeitar">
                                                <i class="fa-solid fa-ban"></i>
                                            </a>
                                        <?php endif; ?>

                                        <a href="restaurantes.php?action=delete&id=<?php echo $item['id']; ?>" onclick="return confirm('Excluir este restaurante definitivamente?')" class="p-2 bg-rose-600/80 hover:bg-rose-600 text-white rounded-lg text-xs" title="Excluir">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- MODAL ADICIONAR RESTAURANTE -->
    <div id="add-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-slate-900 rounded-3xl max-w-xl w-full p-6 sm:p-8 border border-slate-800 relative">
            <button onclick="toggleModal('add-modal')" class="absolute top-4 right-4 text-slate-400 hover:text-white text-xl">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 class="text-xl font-bold text-white mb-4">Adicionar Novo Restaurante</h3>

            <form method="POST" action="restaurantes.php" class="space-y-4">
                <input type="hidden" name="add_restaurant" value="1">
                
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Nome do Estabelecimento *</label>
                    <input type="text" name="name" required placeholder="Ex: Restaurante Sabores do São Francisco" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Categoria *</label>
                        <input type="text" name="category" required placeholder="Ex: Peixes & Frutos do Rio" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-1">Telefone / WhatsApp *</label>
                        <input type="text" name="phone" required placeholder="(79) 99999-9999" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Prato Principal / Especialidade *</label>
                    <input type="text" name="specialty" required placeholder="Ex: Tucunaré Assado na Folha de Bananeira" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Endereço / Localização *</label>
                    <input type="text" name="location" required placeholder="Ex: Orla Fluvial, Centro" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1">Descrição</label>
                    <textarea name="description" rows="3" placeholder="Descrição do estabelecimento..." class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:ring-2 focus:ring-amber-500 focus:outline-none resize-none"></textarea>
                </div>

                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold py-3 rounded-xl shadow-lg transition text-xs flex items-center justify-center gap-2">
                    <i class="fa-solid fa-save"></i> Salvar e Publicar
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>
</body>
</html>
