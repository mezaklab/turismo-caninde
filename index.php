<?php
header('Content-Type: text/html; charset=utf-8');
// CONEXÃO CÂNIONS - Portal Privado Regional
// Canindé de São Francisco (SE) & Piranhas (AL)
$currentYear = date('Y');

// Dados dos Atrativos Turísticos
$attractions = [
    [
        'id' => 'canions-xingo',
        'title' => 'Cânions do Xingó',
        'subtitle' => 'O majestoso Velho Chico entre paredões alaranjados',
        'tag' => 'NATUREZA',
        'badge_type' => 'blue',
        'image' => 'assets/images/canions_xingo.jpg',
        'description' => 'Navegue pelas águas verde-esmeralda do Rio São Francisco ladeadas por suntuosos paredões rochosos avermelhados de mais de 50 metros de altura.',
        'highlights' => ['Passeios de Catamarã e Escuna', 'Banho no Porto de Alagadiço', 'Gruta do Talhado', 'Passeio de Canoa em Cânions Estreitos']
    ],
    [
        'id' => 'rota-cangaco',
        'title' => 'Rota do Cangaço & Grota do Angico',
        'subtitle' => 'Trilha histórica da emboscada de Lampião e Maria Bonita',
        'tag' => 'CORDEL & HISTÓRIA',
        'badge_type' => 'cordel',
        'image' => 'assets/images/rota_cangaco.jpg',
        'description' => 'Uma imersão na caatinga sergipana percorrendo as trilhas históricas até o local exato onde o bando de Lampião travou sua última batalha em 1938.',
        'highlights' => ['Trilha Ecológica da Grota do Angico', 'Atores Caracterizados de Cangaceiros', 'Cultura de Cordel e Culinária Sertaneja', 'Monumento Histórico no Sertão']
    ],
    [
        'id' => 'usina-xingo',
        'title' => 'Usina Hidrelétrica do Xingó',
        'subtitle' => 'Gigante da engenharia nacional no coração do Nordeste',
        'tag' => 'ENGENHARIA',
        'badge_type' => 'gray',
        'image' => 'assets/images/usina_xingo.jpg',
        'description' => 'Visita técnica e turística a uma das maiores usinas hidrelétricas do Brasil, responsável por transformar a paisagem e a energia da região.',
        'highlights' => ['Centro de Visitantes da CHESF', 'Mirante da Barragem de Xingó', 'Museu de Arqueologia de Xingó (MAX)', 'Maquete Gigante do Complexo']
    ],
    [
        'id' => 'mirante-seabra',
        'title' => 'Mirante da Seabra & Piranhas',
        'subtitle' => 'Vista panorâmica inesquecível do rio e das duas cidades',
        'tag' => 'CONTEMPLAÇÃO',
        'badge_type' => 'green',
        'image' => 'assets/images/mirante_seabra.jpg',
        'description' => 'Ponto mais alto e privilegiado para contemplar o pôr do sol dourado refletindo no Rio São Francisco, contornando as duas cidades que dividem esse patrimônio natural.',
        'highlights' => ['Pôr do Sol Fotogênico', 'Vista 360° da Região do Semiárido', 'Centro Histórico de Piranhas (AL)', 'Espaço para Relaxar e Fotografar']
    ]
];

// Dados dos Eventos
$events = [
    [
        'day' => '15',
        'month' => 'AGO',
        'title' => 'Festa de Nossa Senhora da Conceição',
        'location' => 'Praça Matriz - Canindé de São Francisco',
        'category' => 'Religioso & Cultural',
        'image' => 'assets/images/cordel_art.jpg',
        'excerpt' => 'Celebração tradicional da padroeira com missas, procissão fluvial no Rio São Francisco, feira de artesanato regional e shows de forró.'
    ],
    [
        'day' => '28',
        'month' => 'SET',
        'title' => 'Festival Cordel & Cangaço da Região',
        'location' => 'Centro Cultural Xingó / Piranhas (AL)',
        'category' => 'Arte & Literatura',
        'image' => 'assets/images/rota_cangaco.jpg',
        'excerpt' => 'Encontro de violeiros, repentistas, declamadores de cordel e encenações teatrais da Rota do Cangaço com gastronomia típica do sertão nas duas cidades.'
    ],
    [
        'day' => '12',
        'month' => 'OUT',
        'title' => 'Desafio Cânions Run & EcoTrilha',
        'location' => 'Trilha do Talhado / Rio São Francisco',
        'category' => 'Esporte & Aventura',
        'image' => 'assets/images/canions_xingo.jpg',
        'excerpt' => 'Corrida de aventura e corrida aquática em caiaque entre as formações rochosas espetaculares dos Cânions do Xingó, unindo SE e AL.'
    ]
];

// Estatísticas Regionais
$stats = [
    ['number' => 'Cânions do Xingó', 'label' => '5º Maior Cânion Navegável', 'sub' => 'do Mundo em extensão de água doce, unindo SE e AL'],
    ['number' => '+500k', 'label' => 'Visitas por Ano', 'sub' => 'Público estimado na região de Canindé e Piranhas'],
    ['number' => 'Patrimônio', 'label' => 'Histórico & Cultural', 'sub' => 'Riqueza cultural e do Cangaço nas duas cidades'],
    ['number' => 'Infraestrutura', 'label' => 'Completa & Regional', 'sub' => 'Rede Hoteleira e Gastronômica de Excelência']
];

// Conexão MySQL e Processamento de Restaurantes
require_once __DIR__ . '/conexao.php';

$restaurants = [];
$userMsg = '';

// Inserção de Novo Cadastro do Usuário no MySQL com Status 'pendente'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_register_restaurant'])) {
    $nome = trim($_POST['name'] ?? '');
    $categoria = trim($_POST['category'] ?? 'Peixes & Frutos do Rio');
    $descricao = trim($_POST['description'] ?? '');
    $telefone = trim($_POST['phone'] ?? '');
    $endereco = trim($_POST['location'] ?? '');
    $cidade = trim($_POST['cidade'] ?? 'Canindé de São Francisco');

    if (!empty($nome) && !empty($telefone)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO restaurantes (nome, categoria, prato_destaque, endereco, telefone, cidade, status) VALUES (:nome, :categoria, :prato_destaque, :endereco, :telefone, :cidade, 'pendente')");
            $stmt->execute([
                'nome' => $nome,
                'categoria' => $categoria,
                'prato_destaque' => $descricao,
                'endereco' => $endereco,
                'telefone' => $telefone,
                'cidade' => $cidade
            ]);
            $userMsg = 'success';
        } catch (PDOException $e) {
            $userMsg = 'error';
        }
    }
}

// Leitura dos Restaurantes Aprovados no MySQL
try {
    $stmt = $pdo->query("SELECT *, nome AS name, prato_destaque AS specialty, endereco AS location, telefone AS phone, categoria AS category FROM restaurantes WHERE status = 'aprovado' ORDER BY id DESC");
    $restaurants = $stmt->fetchAll();
    foreach ($restaurants as &$r) {
        if (empty($r['image'])) {
            $r['image'] = 'assets/images/canions_xingo.jpg';
        }
        if (empty($r['tag'])) {
            $r['tag'] = 'Recomendado';
        }
    }
} catch (PDOException $e) {
    $restaurants = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexão Cânions | Guia de Turismo - Canindé de São Francisco (SE) & Piranhas (AL)</title>
    <meta name="description" content="Descubra os Cânions do Xingó, Rota do Cangaço, gastronomia e hospedagem em Canindé de São Francisco (SE) e Piranhas (AL). Conectando você ao melhor do Velho Chico.">

    <!-- Favicons Conexão Cânions -->
    <link rel="icon" type="image/x-icon" href="/turismo-caninde/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/turismo-caninde/assets/images/favicon-16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/turismo-caninde/assets/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/turismo-caninde/assets/images/favicon-192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/turismo-caninde/assets/images/favicon-512.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/turismo-caninde/assets/images/apple-touch-icon.png">
    <meta name="theme-color" content="#EA580C">

    <!-- Google Fonts (Cinzel, Eczar & Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Eczar:wght@500;700;800&family=Playfair+Display:ital,wght@0,600;0,800;1,600;1,800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sertao: {
                            bg: '#0F172A',
                            card: '#18181B',
                            border: '#27272a',
                            terracota: '#EA580C',
                            amber: '#D97706',
                            gold: '#F59E0B',
                            rio: '#0284C7',
                            sand: '#fef3c7',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        cinzel: ['Cinzel', 'serif'],
                        cordel: ['Eczar', 'serif'],
                        display: ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>

    <style>
        /* ====== DESIGN SYSTEM SERTÃO PREMIUM ====== */
        :root {
            --bg-primary: #0F172A;
            --bg-secondary: #18181B;
            --border: #27272a;
            --terracota: #EA580C;
            --amber: #D97706;
            --gold: #F59E0B;
            --rio: #0284C7;
        }
        body { background-color: var(--bg-primary); }

        /* Glassmorphism Nav */
        .glass-nav {
            background: rgba(15, 23, 42, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Hero */
        .hero-overlay {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.65) 0%, rgba(15, 23, 42, 0.45) 45%, rgba(15, 23, 42, 0.96) 100%);
        }

        /* Texto com glow dourado */
        .text-glow-gold {
            text-shadow: 0 0 30px rgba(245, 158, 11, 0.5);
        }

        /* Cards hover lift */
        .card-lift {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(234, 88, 12, 0.2);
        }

        /* Cordel borda dashed terracota */
        .cordel-border {
            border: 2px dashed rgba(234, 88, 12, 0.4);
        }

        /* Textura de xilogravura para o bloco cordel */
        .cordel-dark-box {
            background-color: #1a0f05;
            background-image:
                radial-gradient(rgba(215, 119, 6, 0.12) 0.6px, transparent 0.6px),
                radial-gradient(rgba(215, 119, 6, 0.08) 0.6px, #1a0f05 0.6px);
            background-size: 24px 24px;
            background-position: 0 0, 12px 12px;
            border: 2px solid rgba(120, 53, 15, 0.4);
        }

        /* Carimbo cordel */
        .cordel-stamp {
            background-color: #78350f;
            color: #fef3c7;
            clip-path: polygon(0% 0%, 100% 0%, 95% 50%, 100% 100%, 0% 100%, 5% 50%);
        }

        /* Gradiente de fundo para seções */
        .bg-gradient-sertao {
            background: linear-gradient(180deg, #0F172A 0%, #18181B 100%);
        }

        /* Linha decorativa terracota */
        .accent-line::before {
            content: '';
            display: block;
            width: 48px;
            height: 4px;
            background: linear-gradient(90deg, #EA580C, #F59E0B);
            border-radius: 2px;
            margin-bottom: 16px;
        }

        /* Número animado */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up { animation: slideUp 0.6s ease-out forwards; }

        /* Scrollbar oculta */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* Animação de fade in para modais */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.97); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-enter { animation: fadeIn 0.2s ease-out; }

        /* Tag de cidade */
        .badge-caninde {
            background: linear-gradient(135deg, #1e3a5f, #0284C7);
        }
        .badge-piranhas {
            background: linear-gradient(135deg, #4a1942, #7c3aed);
        }

        /* Anúncio CTA button shine effect */
        .btn-anunciar::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 30%;
            height: 200%;
            background: rgba(255,255,255,0.12);
            transform: skewX(-20deg);
            transition: left 0.4s ease;
        }
        .btn-anunciar:hover::after {
            left: 120%;
        }
    </style>
</head>
<body class="text-slate-200 font-sans antialiased selection:bg-amber-500 selection:text-slate-950">
    <?php include_once __DIR__ . '/includes/loader.php'; ?>

    <!-- TOP BAR REGIONAL -->
    <div class="bg-sertao-card text-slate-400 text-xs py-2 px-4 border-b border-sertao-border">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-location-dot text-amber-500"></i>
                    <span>Canindé de São Francisco <strong class="text-slate-300">SE</strong></span>
                    <span class="text-slate-600 mx-1">•</span>
                    <span>Piranhas <strong class="text-slate-300">AL</strong></span>
                </span>
                <span class="hidden md:flex items-center gap-1.5">
                    <i class="fa-solid fa-water text-sky-400"></i>
                    <span>Região do Baixo São Francisco</span>
                </span>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://wa.me/5579998443311" target="_blank" class="hover:text-amber-400 transition flex items-center gap-1">
                    <i class="fa-brands fa-whatsapp text-emerald-400"></i> (79) 99844-3311
                </a>
                <span class="text-slate-700">|</span>
                <div class="flex items-center gap-3 text-sm">
                    <a href="#" class="hover:text-amber-400 transition" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-amber-400 transition" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-amber-400 transition" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- NAVBAR -->
    <header class="sticky top-0 z-50 glass-nav border-b border-slate-700/40 shadow-xl" id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <a href="index.php" class="flex items-center gap-3 group shrink-0" aria-label="Conexão Cânions - Início">
                    <img src="assets/images/logo_icon.png" alt="Conexão Cânions" class="w-10 h-10 sm:w-11 sm:h-11 object-contain group-hover:scale-105 transition-transform shrink-0 drop-shadow-md">
                    <div class="flex flex-col">
                        <span class="text-base sm:text-lg font-black tracking-tight text-white group-hover:text-amber-400 transition-colors leading-none">
                            CONEXÃO <span class="text-amber-500">CÂNIONS</span>
                        </span>
                        <span class="text-[10px] sm:text-[11px] text-amber-400/90 font-medium tracking-normal mt-1 whitespace-nowrap">
                            Conectando você ao melhor do Velho Chico
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center gap-4 xl:gap-6 whitespace-nowrap" aria-label="Menu Principal">
                    <a href="#inicio" class="text-sm font-semibold text-amber-400 transition-colors whitespace-nowrap">Início</a>
                    <a href="restaurantes.php" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Onde Comer</a>
                    <a href="#hospedagem" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Onde Ficar</a>
                    <a href="#turismo" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Passeios &amp; Cânions</a>
                    <a href="#cordel-cangaco" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Rota do Cangaço</a>
                    <a href="#contato" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Contato</a>
                </nav>

                <!-- CTA Buttons -->
                <div class="hidden sm:flex items-center gap-3 shrink-0">
                    <button onclick="toggleModal('search-modal')" class="p-2.5 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-slate-800/80 transition" title="Buscar" aria-label="Abrir busca">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>

                    <!-- CTA Anunciar -->
                    <a href="https://wa.me/5579998443311?text=Olá!%20Quero%20anunciar%20meu%20negócio%20no%20portal%20Conexão%20Cânions." target="_blank"
                       class="btn-anunciar relative overflow-hidden bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 text-white font-bold px-4 py-2.5 rounded-xl shadow-lg shadow-orange-600/25 hover:shadow-orange-500/40 transition-all transform hover:-translate-y-0.5 flex items-center gap-2 text-xs sm:text-sm whitespace-nowrap">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Anunciar Estabelecimento</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition" aria-label="Menu Principal">
                    <i class="fa-solid fa-bars-staggered text-2xl" id="menu-icon"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div id="mobile-menu" class="hidden lg:hidden bg-slate-950 border-b border-slate-800 px-4 pt-3 pb-6 space-y-2">
            <a href="#inicio" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-semibold text-amber-400 bg-slate-800/60">Início</a>
            <a href="restaurantes.php" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Onde Comer</a>
            <a href="#hospedagem" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Onde Ficar</a>
            <a href="#turismo" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Passeios & Cânions</a>
            <a href="#cordel-cangaco" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Rota do Cangaço</a>
            <a href="#contato" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Contato</a>
            <div class="pt-2 flex flex-col gap-2">
                <button onclick="toggleMobileMenu(); toggleModal('search-modal')" class="w-full text-left py-2.5 px-3 rounded-lg font-medium text-slate-300 bg-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-amber-400"></i> Buscar no Portal
                </button>
                <a href="https://wa.me/5579998443311?text=Olá!%20Quero%20anunciar%20meu%20negócio%20no%20portal%20Conexão%20Cânions." target="_blank"
                   class="w-full bg-gradient-to-r from-orange-600 to-amber-500 text-white font-bold py-3 rounded-xl text-center flex items-center justify-center gap-2 shadow-md">
                    <i class="fa-solid fa-bullhorn"></i> Anunciar Estabelecimento
                </a>
            </div>
        </div>
    </header>

    <!-- ====== HERO SECTION ====== -->
    <section id="inicio" class="relative min-h-[88vh] lg:min-h-[92vh] flex items-center justify-center bg-slate-950 overflow-hidden">
        <!-- Imagem de Fundo -->
        <div class="absolute inset-0 z-0">
            <img src="assets/images/hero_canyons.jpg" alt="Cânions do Xingó - Rio São Francisco" class="w-full h-full object-cover object-center scale-105 transition-transform duration-1000">
            <div class="absolute inset-0 hero-overlay"></div>
        </div>

        <!-- Blobs decorativos -->
        <div class="absolute top-16 left-10 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-16 right-10 w-96 h-96 bg-orange-600/8 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 text-center text-white pt-16 pb-40">

            <!-- Tag Regional -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900/80 backdrop-blur-md border border-amber-500/40 text-amber-400 text-xs sm:text-sm font-bold tracking-wider uppercase mb-8 shadow-xl">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                <i class="fa-solid fa-compass text-amber-400"></i>
                SE & AL — REGIÃO DOS CÂNIONS DO XINGÓ
            </div>

            <!-- Título Principal -->
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-black tracking-tight text-white leading-[1.05] mb-6">
                Descubra a Magia dos<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-orange-400 to-amber-500 font-display italic font-semibold text-glow-gold">Cânions do Xingó</span>
            </h1>

            <!-- Subtítulo -->
            <p class="text-lg sm:text-xl md:text-2xl text-slate-200/90 font-light max-w-3xl mx-auto leading-relaxed mb-10">
                O seu guia completo de gastronomia, hospedagem e passeios em <strong class="text-white font-semibold">Canindé de São Francisco (SE)</strong> e <strong class="text-white font-semibold">Piranhas (AL)</strong>.
            </p>

            <!-- Botões de Ação -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="restaurantes.php" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-base px-8 py-4 rounded-xl shadow-xl shadow-amber-500/30 hover:shadow-amber-500/50 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                    <i class="fa-solid fa-utensils"></i>
                    <span>Explorar Guia Gastronômico</span>
                </a>

                <a href="#turismo" class="w-full sm:w-auto bg-slate-900/70 hover:bg-slate-900/90 text-white font-semibold text-base px-8 py-4 rounded-xl border border-slate-600/80 hover:border-amber-400/60 backdrop-blur-md transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 group">
                    <span class="w-8 h-8 rounded-full bg-orange-600/80 text-white flex items-center justify-center text-sm group-hover:bg-orange-500 transition">
                        <i class="fa-solid fa-water"></i>
                    </span>
                    <span>Ver Passeios & Roteiros</span>
                </a>
            </div>

            <!-- Stats rápidos abaixo dos botões -->
            <div class="flex flex-wrap items-center justify-center gap-6 mt-12 text-sm text-slate-300/80">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                    <span>Guia Gratuito</span>
                </div>
                <div class="text-slate-600">•</div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-amber-400 text-base"></i>
                    <span>2 Cidades Cobertas</span>
                </div>
                <div class="text-slate-600">•</div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-utensils text-orange-400 text-base"></i>
                    <span>Gastronomia & Hospedagem</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ====== CARDS DE ACESSO RÁPIDO (flutuando sobre a hero) ====== -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 -mt-20">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 sm:gap-4">

            <a href="restaurantes.php" class="bg-sertao-card rounded-2xl p-5 shadow-xl border border-sertao-border hover:border-amber-500/50 transition-all card-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-amber-500/15 text-amber-400 flex items-center justify-center text-xl mb-3 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-white group-hover:text-amber-400 transition-colors">Onde Comer</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Guia gastronômico</p>
            </a>

            <button onclick="showQuickInfo('hospedagem')" class="bg-sertao-card rounded-2xl p-5 shadow-xl border border-sertao-border hover:border-amber-500/50 transition-all card-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-sky-500/15 text-sky-400 flex items-center justify-center text-xl mb-3 group-hover:bg-sky-500 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-white group-hover:text-sky-400 transition-colors">Onde Ficar</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Hotéis e pousadas</p>
            </button>

            <a href="#turismo" class="bg-sertao-card rounded-2xl p-5 shadow-xl border border-sertao-border hover:border-amber-500/50 transition-all card-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-blue-500/15 text-blue-400 flex items-center justify-center text-xl mb-3 group-hover:bg-blue-500 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-ship"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-white group-hover:text-blue-400 transition-colors">Passeios</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Catamarã & Cânions</p>
            </a>

            <a href="#cordel-cangaco" class="bg-sertao-card rounded-2xl p-5 shadow-xl border border-sertao-border hover:border-amber-500/50 transition-all card-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-orange-500/15 text-orange-400 flex items-center justify-center text-xl mb-3 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-scroll"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-white group-hover:text-orange-400 transition-colors">Rota do Cangaço</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Cordel & Grota</p>
            </a>

            <button onclick="showQuickInfo('comochegar')" class="col-span-2 md:col-span-1 bg-sertao-card rounded-2xl p-5 shadow-xl border border-sertao-border hover:border-amber-500/50 transition-all card-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center text-xl mb-3 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-route"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-white group-hover:text-emerald-400 transition-colors">Como Chegar</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Rotas e acessos</p>
            </button>

        </div>
    </div>

    <!-- ====== SEÇÃO "DOIS ESTADOS, UM SÓ DESTINO" ====== -->
    <section id="nossa-cidade" class="py-24 bg-gradient-sertao">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-14 items-center">

                <!-- Texto Principal -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-orange-500/15 text-orange-400 border border-orange-500/25 text-xs font-bold tracking-wider uppercase">
                        <i class="fa-solid fa-map-location-dot"></i> DESTINO REGIONAL
                    </div>

                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight accent-line">
                        Dois Estados, Um Só Destino Inesquecível
                    </h2>

                    <p class="text-slate-300 text-base sm:text-lg leading-relaxed">
                        Na fronteira entre <strong class="text-amber-400">Sergipe</strong> e <strong class="text-purple-400">Alagoas</strong>, o Rio São Francisco cria um dos cenários mais impressionantes do Brasil. Canindé de São Francisco e Piranhas compartilham as mesmas águas cristalinas, os mesmos paredões rochosos e a mesma alma sertaneja que encanta todos os visitantes.
                    </p>

                    <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                        O <strong class="text-white">Conexão Cânions</strong> é o guia que une as duas margens: gastronomia típica do Velho Chico, hospedagem de qualidade, passeios de catamarã pelos cânions, a Rota do Cangaço e o rico patrimônio histórico e cultural dessas duas cidades irmãs.
                    </p>

                    <!-- Badges das cidades -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-sertao-card border border-sertao-border">
                            <div class="w-10 h-10 rounded-xl badge-caninde flex items-center justify-center text-sm font-black text-white shrink-0">SE</div>
                            <div>
                                <h4 class="font-bold text-white text-sm">Canindé de São Francisco</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Portal dos Cânions • Embarcadouros • Usina do Xingó</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-sertao-card border border-sertao-border">
                            <div class="w-10 h-10 rounded-xl badge-piranhas flex items-center justify-center text-sm font-black text-white shrink-0">AL</div>
                            <div>
                                <h4 class="font-bold text-white text-sm">Piranhas</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Centro Histórico • Patrimônio do Cangaço • Arte & Cultura</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-sertao-card border border-sertao-border">
                            <div class="w-10 h-10 rounded-xl bg-blue-600/30 text-sky-400 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-water"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-sm">Rio São Francisco</h4>
                                <p class="text-xs text-slate-400 mt-0.5">O Velho Chico — coração da região e berço da cultura</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-sertao-card border border-sertao-border">
                            <div class="w-10 h-10 rounded-xl bg-amber-500/25 text-amber-400 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-hat-cowboy"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-sm">Herança do Cangaço</h4>
                                <p class="text-xs text-slate-400 mt-0.5">Grota do Angico — última morada de Lampião (1938)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bloco Cordel Premium (Dark Mode) -->
                <div class="lg:col-span-5">
                    <div class="cordel-dark-box p-8 rounded-2xl relative overflow-hidden shadow-2xl">

                        <div class="flex items-center justify-between border-b border-amber-900/30 pb-4 mb-6">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-feather-pointed text-2xl text-amber-600"></i>
                                <span class="font-cordel font-bold text-amber-400 text-xl tracking-wide uppercase">Velho Chico</span>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 bg-amber-900/60 text-amber-200 rounded-md border border-amber-700/40">Cordel Regional</span>
                        </div>

                        <blockquote class="font-cordel text-xl sm:text-2xl text-amber-200 leading-relaxed italic font-medium text-center py-2">
                            "Nas duas margens do Chico,<br>
                            Canindé e Piranhas florescem,<br>
                            Nos cânions cor de terracota,<br>
                            As histórias não perecem.<br>
                            Do Cangaço à Usina grande,<br>
                            Dois estados se conhecem!"
                        </blockquote>

                        <div class="mt-6 text-right border-t border-amber-900/20 pt-4">
                            <span class="text-xs font-bold text-amber-700 uppercase tracking-widest">— Tradição Oral do Velho Chico</span>
                        </div>

                        <!-- Detalhe decorativo -->
                        <div class="absolute -bottom-8 -right-8 text-amber-900 pointer-events-none select-none" style="opacity: 0.06; z-index: -1;">
                            <i class="fa-solid fa-sun text-9xl"></i>
                        </div>
                    </div>

                    <!-- Mini CTA abaixo do cordel -->
                    <div class="mt-6 p-4 rounded-2xl bg-sertao-card border border-sertao-border flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center shrink-0">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-white">Precisa de ajuda para planejar?</p>
                            <p class="text-xs text-slate-400">Fale diretamente com nossa equipe</p>
                        </div>
                        <a href="https://wa.me/5579998443311?text=Olá!%20Quero%20informações%20sobre%20passeios%20na%20região%20dos%20Cânions." target="_blank"
                           class="shrink-0 bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                            Chamar
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ====== SEÇÃO ATRATIVOS TURÍSTICOS ====== -->
    <section id="turismo" class="py-24 bg-sertao-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Cabeçalho -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-500/15 text-amber-400 border border-amber-500/20 text-xs font-bold tracking-wider uppercase mb-3">
                        <i class="fa-solid fa-star"></i> PASSEIOS & ATRATIVOS
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                        Encantos que você precisa conhecer
                    </h2>
                    <p class="text-slate-400 mt-2 text-base max-w-2xl">
                        Maravilhas naturais, históricas e culturais que fazem da Região dos Cânions um destino único no Brasil.
                    </p>
                </div>

                <a href="#cordel-cangaco" class="inline-flex items-center gap-2 text-amber-400 hover:text-amber-300 font-bold text-sm group shrink-0">
                    <span>Ver Rota Cultural Completa</span>
                    <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <!-- Grid Cards de Atrativos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($attractions as $item): ?>
                    <div class="bg-sertao-card rounded-2xl overflow-hidden border border-sertao-border card-lift group flex flex-col">

                        <div class="relative h-56 overflow-hidden">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 to-transparent"></div>

                            <div class="absolute top-4 left-4">
                                <?php if ($item['badge_type'] === 'blue'): ?>
                                    <span class="bg-sky-600 text-white font-extrabold text-[11px] px-3 py-1.5 rounded-lg shadow-md tracking-wider uppercase flex items-center gap-1.5">
                                        <i class="fa-solid fa-water"></i> <?php echo $item['tag']; ?>
                                    </span>
                                <?php elseif ($item['badge_type'] === 'cordel'): ?>
                                    <span class="bg-amber-500 text-slate-950 font-cordel font-extrabold text-xs px-3 py-1.5 rounded-lg shadow-md uppercase tracking-wider flex items-center gap-1.5">
                                        <i class="fa-solid fa-scroll"></i> <?php echo $item['tag']; ?>
                                    </span>
                                <?php elseif ($item['badge_type'] === 'gray'): ?>
                                    <span class="bg-slate-700 text-slate-100 font-extrabold text-[11px] px-3 py-1.5 rounded-lg shadow-md tracking-wider uppercase flex items-center gap-1.5">
                                        <i class="fa-solid fa-bolt"></i> <?php echo $item['tag']; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="bg-emerald-700 text-white font-extrabold text-[11px] px-3 py-1.5 rounded-lg shadow-md tracking-wider uppercase flex items-center gap-1.5">
                                        <i class="fa-solid fa-mountain-sun"></i> <?php echo $item['tag']; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-white group-hover:text-amber-400 transition-colors mb-1">
                                    <?php echo $item['title']; ?>
                                </h3>
                                <p class="text-xs font-semibold text-amber-500/80 mb-3">
                                    <?php echo $item['subtitle']; ?>
                                </p>
                                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                                    <?php echo $item['description']; ?>
                                </p>
                            </div>

                            <div class="border-t border-sertao-border pt-4 mt-2">
                                <h4 class="text-xs font-bold uppercase text-slate-500 tracking-wider mb-2">Destaques:</h4>
                                <ul class="text-xs text-slate-400 space-y-1.5 mb-4">
                                    <?php foreach (array_slice($item['highlights'], 0, 2) as $hl): ?>
                                        <li class="flex items-center gap-2">
                                            <i class="fa-solid fa-check text-amber-500 text-xs"></i>
                                            <span><?php echo $hl; ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <button onclick="openAttractionModal('<?php echo $item['id']; ?>')" class="w-full bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-white font-bold py-2.5 rounded-xl text-xs transition-all flex items-center justify-center gap-2 border border-sertao-border hover:border-amber-500">
                                    <span>Ver Detalhes do Roteiro</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- ====== SEÇÃO ROTA DO CANGAÇO (dark premium) ====== -->
    <section id="cordel-cangaco" class="py-24 bg-sertao-card relative overflow-hidden border-y border-sertao-border">

        <!-- Glow de fundo -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-amber-600/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-orange-600/5 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-slate-950/70 rounded-3xl p-8 sm:p-12 border border-sertao-border shadow-2xl relative overflow-hidden">


                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

                    <!-- Imagem -->
                    <div class="lg:col-span-5 relative">
                        <div class="rounded-2xl overflow-hidden shadow-2xl border-2 border-amber-900/30 group">
                            <img src="assets/images/cordel_art.jpg" alt="Arte Cordel e Rota do Cangaço" class="w-full h-80 lg:h-96 object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/50 to-transparent"></div>
                        </div>
                        <div class="cordel-stamp absolute -top-4 -left-4 font-cordel text-sm font-extrabold px-5 py-2 uppercase tracking-widest shadow-xl">
                            Patrimônio Vivo
                        </div>
                    </div>

                    <!-- Texto -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-500/15 text-amber-400 border border-amber-500/25 font-cordel text-xs font-extrabold tracking-wider uppercase">
                            <i class="fa-solid fa-scroll"></i> HISTÓRIA & TRADIÇÃO SERTANEJA
                        </div>

                        <h2 class="text-3xl sm:text-4xl font-cordel font-extrabold text-white leading-tight">
                            Rota do Cangaço & A Tradição do Cordel da Região
                        </h2>

                        <p class="text-slate-300 text-base leading-relaxed">
                            A Região dos Cânions guarda um dos capítulos mais marcantes da história do Brasil. Foi no coração do bioma Caatinga, na célebre <strong class="text-amber-400">Grota do Angico</strong> — próxima a Canindé de São Francisco —, que o lendário Lampião, Maria Bonita e seu bando viveram seus últimos momentos em 1938. Um patrimônio histórico que pertence aos dois estados.
                        </p>

                        <p class="text-slate-400 text-base leading-relaxed">
                            Em Piranhas (AL), o <strong class="text-white">Museu do Cangaço</strong> preserva a memória desta época com acervos, indumentárias e documentos históricos únicos. Poetas de cordel, rabequeiros e contadores de história mantêm viva a memória cultural sertaneja nas duas cidades.
                        </p>

                        <!-- Citação Cordel Premium -->
                        <div class="cordel-border p-5 rounded-2xl bg-amber-950/30">
                            <p class="font-cordel text-amber-300 text-lg font-bold italic">
                                "Entre pedras e cactos do sertão nordestino,<br>
                                A poesia do cordel canta a história do Cangaço<br>
                                e a força de dois estados com o mesmo destino."
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button onclick="openAttractionModal('rota-cangaco')" class="bg-amber-600 hover:bg-amber-500 text-slate-950 font-extrabold px-6 py-3.5 rounded-xl shadow-lg shadow-amber-600/25 transition-all transform hover:-translate-y-0.5 inline-flex items-center justify-center gap-2 text-sm">
                                <i class="fa-solid fa-book-open"></i>
                                <span>Ver Roteiro Completo</span>
                            </button>
                            <a href="https://wa.me/5579998443311?text=Olá!%20Quero%20informações%20sobre%20a%20Rota%20do%20Cangaço." target="_blank"
                               class="bg-slate-800 hover:bg-slate-700 text-white font-bold px-6 py-3.5 rounded-xl border border-sertao-border transition-all inline-flex items-center justify-center gap-2 text-sm">
                                <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                                <span>Agendar Guia</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ====== SEÇÃO GASTRONOMIA ====== -->
    <section id="onde-comer" class="py-24 bg-sertao-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Cabeçalho -->
            <div class="mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-orange-500/15 text-orange-400 border border-orange-500/20 text-xs font-bold tracking-wider uppercase mb-3">
                    <i class="fa-solid fa-utensils"></i> GUIA GASTRONÔMICO
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    Sabores do Sertão & Onde Comer
                </h2>
                <p class="text-slate-400 mt-2 text-base max-w-2xl">
                    Peixes frescos do Velho Chico, carne de sol sertaneja, doces típicos e o tempero autêntico das margens do São Francisco — em Canindé e Piranhas.
                </p>
            </div>

            <?php if (!empty($restaurants)): ?>
            <!-- Carrossel de Restaurantes -->
            <div class="relative group/onde-comer px-2 sm:px-0">
                <button onclick="scrollRestaurants('left')" class="absolute -left-3 sm:-left-6 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-2xl bg-slate-900/80 hover:bg-amber-500 text-white hover:text-slate-950 backdrop-blur-md opacity-50 group-hover/onde-comer:opacity-90 hover:!opacity-100 transition-all shadow-xl flex items-center justify-center border border-sertao-border" aria-label="Anterior">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button onclick="scrollRestaurants('right')" class="absolute -right-3 sm:-right-6 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-2xl bg-slate-900/80 hover:bg-amber-500 text-white hover:text-slate-950 backdrop-blur-md opacity-50 group-hover/onde-comer:opacity-90 hover:!opacity-100 transition-all shadow-xl flex items-center justify-center border border-sertao-border" aria-label="Próximo">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <div id="restaurant-carousel" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 pt-2 no-scrollbar">
                    <?php foreach ($restaurants as $restaurant): ?>
                        <div onclick="window.location.href='restaurante.php?id=<?php echo $restaurant['id']; ?>'"
                             class="snap-start shrink-0 w-full sm:w-[calc((100%-1.5rem)/2)] lg:w-[calc((100%-3rem)/3)] bg-sertao-card rounded-2xl overflow-hidden border border-sertao-border card-lift flex flex-col group cursor-pointer hover:border-amber-500/40 transition-colors">

                            <div class="relative h-48 overflow-hidden">
                                <img src="<?php echo htmlspecialchars($restaurant['image'] ?? 'assets/images/canions_xingo.jpg'); ?>"
                                     alt="<?php echo htmlspecialchars($restaurant['name'] ?? $restaurant['nome'] ?? ''); ?>"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 to-transparent"></div>

                                <div class="absolute top-4 left-4 bg-amber-500 text-slate-950 font-extrabold text-xs px-3 py-1 rounded-lg shadow-md uppercase tracking-wider">
                                    <?php echo htmlspecialchars($restaurant['category'] ?? $restaurant['categoria'] ?? 'Geral'); ?>
                                </div>
                                <?php
                                $cidade_r = $restaurant['cidade'] ?? 'Canindé de São Francisco';
                                $badgeCidadeClass = (strpos($cidade_r, 'Piranhas') !== false) ? 'badge-piranhas' : 'badge-caninde';
                                $cidadeAbrev = (strpos($cidade_r, 'Piranhas') !== false) ? 'Piranhas AL' : 'Canindé SE';
                                ?>
                                <div class="absolute top-4 right-4 <?php echo $badgeCidadeClass; ?> text-white font-bold text-[10px] px-2.5 py-1 rounded-lg border border-white/10">
                                    <i class="fa-solid fa-location-dot mr-1"></i><?php echo $cidadeAbrev; ?>
                                </div>
                            </div>

                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-white group-hover:text-amber-400 transition-colors mb-1.5">
                                        <?php echo htmlspecialchars($restaurant['name'] ?? $restaurant['nome'] ?? ''); ?>
                                    </h3>
                                    <p class="text-xs font-semibold text-amber-500/80 mb-2 flex items-center gap-1.5">
                                        <i class="fa-solid fa-utensils"></i>
                                        <?php echo htmlspecialchars($restaurant['specialty'] ?? $restaurant['prato_destaque'] ?? ''); ?>
                                    </p>
                                    <p class="text-xs text-slate-500 mb-4 flex items-start gap-1.5">
                                        <i class="fa-solid fa-location-dot text-amber-500 mt-0.5"></i>
                                        <span><?php echo htmlspecialchars($restaurant['location'] ?? $restaurant['endereco'] ?? ''); ?></span>
                                    </p>
                                </div>
                                <div class="border-t border-sertao-border pt-3 flex items-center justify-between text-xs">
                                    <a href="https://wa.me/55<?php echo preg_replace('/\D/', '', $restaurant['phone'] ?? $restaurant['telefone'] ?? ''); ?>"
                                       target="_blank" onclick="event.stopPropagation()"
                                       class="font-bold text-slate-400 hover:text-emerald-400 flex items-center gap-1.5 transition">
                                        <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i>
                                        <?php echo htmlspecialchars($restaurant['phone'] ?? $restaurant['telefone'] ?? ''); ?>
                                    </a>
                                    <span class="bg-slate-800 text-amber-400 px-2.5 py-1 rounded-md text-[10px] font-bold border border-sertao-border">
                                        <?php echo htmlspecialchars($restaurant['tag'] ?? 'Recomendado'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <!-- Estado vazio -->
            <div class="text-center py-16 bg-sertao-card rounded-2xl border border-sertao-border">
                <i class="fa-solid fa-utensils text-4xl text-slate-600 mb-4"></i>
                <p class="text-slate-400 font-medium">Os restaurantes em destaque aparecerão aqui em breve.</p>
            </div>
            <?php endif; ?>

            <!-- Botão Ver Todos -->
            <div class="text-center mt-8">
                <a href="restaurantes.php" class="inline-flex items-center gap-2.5 text-amber-400 hover:text-amber-300 font-bold text-sm bg-sertao-card hover:bg-slate-800 px-7 py-3.5 rounded-full transition-all group border border-sertao-border hover:border-amber-500/40 shadow-lg">
                    <span>Ver todos os restaurantes do guia</span>
                    <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <!-- Chamada para Anunciantes -->
            <div class="cordel-border mt-10 p-6 sm:p-8 rounded-2xl bg-sertao-card flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-600 to-amber-500 text-white flex items-center justify-center text-xl shrink-0 shadow-lg">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-white text-lg">Possui um estabelecimento na Região dos Cânions?</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Anuncie no Conexão Cânions — Canindé (SE) & Piranhas (AL) — e alcance mais turistas.</p>
                    </div>
                </div>
                <a href="https://wa.me/5579998443311?text=Olá!%20Quero%20anunciar%20meu%20restaurante/negócio%20no%20portal%20Conexão%20Cânions."
                   target="_blank"
                   class="w-full sm:w-auto bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 text-white font-bold px-6 py-3 rounded-xl text-sm transition-all shrink-0 flex items-center justify-center gap-2 shadow-lg">
                    <i class="fa-brands fa-whatsapp"></i> Anunciar Agora via WhatsApp
                </a>
            </div>

        </div>
    </section>

    <!-- ====== SEÇÃO ONDE FICAR (Hospedagem) ====== -->
    <section id="hospedagem" class="py-24 bg-sertao-card border-y border-sertao-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-sky-500/15 text-sky-400 border border-sky-500/20 text-xs font-bold tracking-wider uppercase mb-3">
                    <i class="fa-solid fa-hotel"></i> REDE HOTELEIRA REGIONAL
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    Onde Ficar na Região dos Cânions
                </h2>
                <p class="text-slate-400 mt-2 text-base">
                    Hotéis e pousadas nas duas cidades, com acomodações para todos os perfis de viajante.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card Pousada 1 -->
                <div class="bg-sertao-bg rounded-2xl p-6 border border-sertao-border card-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center">
                            <i class="fa-solid fa-hotel"></i>
                        </div>
                        <span class="badge-caninde text-white text-[10px] font-bold px-2.5 py-1 rounded-lg">Canindé SE</span>
                    </div>
                    <h3 class="font-bold text-white text-lg mb-1">Xingó Parque Hotel</h3>
                    <p class="text-slate-400 text-xs leading-relaxed mb-4">Estrutura completa de lazer com vista panorâmica para o Rio São Francisco e os cânions.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex text-amber-400 text-xs gap-0.5">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                        </div>
                        <a href="https://wa.me/5579998443311?text=Quero%20informações%20sobre%20hospedagem%20em%20Canindé." target="_blank" class="text-xs font-bold text-emerald-400 hover:text-emerald-300 transition flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp"></i> Consultar
                        </a>
                    </div>
                </div>

                <!-- Card Pousada 2 -->
                <div class="bg-sertao-bg rounded-2xl p-6 border border-sertao-border card-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center">
                            <i class="fa-solid fa-bed"></i>
                        </div>
                        <span class="badge-caninde text-white text-[10px] font-bold px-2.5 py-1 rounded-lg">Canindé SE</span>
                    </div>
                    <h3 class="font-bold text-white text-lg mb-1">Pousada do Velho Chico</h3>
                    <p class="text-slate-400 text-xs leading-relaxed mb-4">Conforto e localização central, próxima ao embarcadouro e aos principais atrativos.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex text-amber-400 text-xs gap-0.5">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>
                        </div>
                        <a href="https://wa.me/5579998443311?text=Quero%20informações%20sobre%20hospedagem%20em%20Canindé." target="_blank" class="text-xs font-bold text-emerald-400 hover:text-emerald-300 transition flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp"></i> Consultar
                        </a>
                    </div>
                </div>

                <!-- Card Pousada 3 Piranhas -->
                <div class="bg-sertao-bg rounded-2xl p-6 border border-sertao-border card-lift">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <span class="badge-piranhas text-white text-[10px] font-bold px-2.5 py-1 rounded-lg">Piranhas AL</span>
                    </div>
                    <h3 class="font-bold text-white text-lg mb-1">Hotel das Piranhas</h3>
                    <p class="text-slate-400 text-xs leading-relaxed mb-4">No coração histórico de Piranhas, com acesso ao Museu do Cangaço e ao centro cultural.</p>
                    <div class="flex items-center justify-between">
                        <div class="flex text-amber-400 text-xs gap-0.5">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                        </div>
                        <a href="https://wa.me/5579998443311?text=Quero%20informações%20sobre%20hospedagem%20em%20Piranhas." target="_blank" class="text-xs font-bold text-emerald-400 hover:text-emerald-300 transition flex items-center gap-1">
                            <i class="fa-brands fa-whatsapp"></i> Consultar
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="https://wa.me/5579998443311?text=Olá!%20Preciso%20de%20indicação%20de%20hospedagem%20na%20Região%20dos%20Cânions." target="_blank"
                   class="inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 font-bold text-sm bg-sertao-bg border border-sertao-border px-6 py-3 rounded-full transition group hover:border-emerald-500/40">
                    <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                    <span>Ver mais opções de hospedagem via WhatsApp</span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ====== SEÇÃO EVENTOS ====== -->
    <section id="eventos" class="py-24 bg-sertao-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-14">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-purple-500/15 text-purple-400 border border-purple-500/20 text-xs font-bold tracking-wider uppercase mb-3">
                    <i class="fa-solid fa-calendar-days"></i> AGENDA CULTURAL
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    Festividades & Eventos da Região
                </h2>
                <p class="text-slate-400 mt-2 text-base">
                    Confira as festividades, eventos esportivos e encontros culturais em Canindé (SE) e Piranhas (AL).
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($events as $event): ?>
                    <div class="bg-sertao-card rounded-2xl overflow-hidden border border-sertao-border card-lift flex flex-col group">

                        <div class="relative h-48 overflow-hidden">
                            <img src="<?php echo $event['image']; ?>" alt="<?php echo $event['title']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 to-transparent"></div>

                            <div class="absolute top-4 left-4 bg-amber-500 text-slate-950 font-black rounded-xl p-2.5 text-center shadow-lg w-14">
                                <span class="block text-xl leading-none font-extrabold"><?php echo $event['day']; ?></span>
                                <span class="block text-[9px] tracking-widest uppercase mt-0.5"><?php echo $event['month']; ?></span>
                            </div>

                            <div class="absolute bottom-3 right-3 bg-slate-900/80 backdrop-blur-md text-slate-300 text-xs px-3 py-1 rounded-full border border-slate-700">
                                <?php echo $event['category']; ?>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-white group-hover:text-amber-400 transition-colors mb-2">
                                    <?php echo $event['title']; ?>
                                </h3>
                                <p class="text-xs text-slate-500 font-medium mb-3 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-amber-500"></i>
                                    <span><?php echo $event['location']; ?></span>
                                </p>
                                <p class="text-slate-400 text-sm leading-relaxed mb-4">
                                    <?php echo $event['excerpt']; ?>
                                </p>
                            </div>

                            <a href="https://wa.me/5579998443311?text=Olá!%20Quero%20informações%20sobre%20o%20evento:<?php echo urlencode($event['title']); ?>" target="_blank"
                               class="inline-flex items-center gap-2 text-xs font-bold text-amber-400 hover:text-amber-300 group/link transition">
                                <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                                <span>Mais informações</span>
                                <i class="fa-solid fa-arrow-right transition-transform group-hover/link:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- ====== SEÇÃO EM NÚMEROS ====== -->
    <section id="estatisticas" class="py-24 bg-sertao-card relative overflow-hidden border-y border-sertao-border">

        <div class="absolute -top-24 -left-24 w-96 h-96 bg-amber-500/8 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-500/8 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-500/15 text-amber-400 border border-amber-500/20 text-xs font-bold tracking-wider uppercase mb-3">
                    <i class="fa-solid fa-chart-line"></i> IMPACTO E GRANDEZA REGIONAL
                </div>
                <h2 class="text-3xl sm:text-4xl font-black font-cinzel tracking-tight text-white">
                    A Região dos Cânions em Números
                </h2>
                <p class="text-slate-400 mt-3 text-base font-light">
                    Dados que comprovam a relevância turística, histórica e econômica de Canindé de São Francisco (SE) e Piranhas (AL).
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($stats as $stat): ?>
                    <div class="bg-sertao-bg rounded-2xl p-8 border border-sertao-border text-center hover:border-amber-500/40 transition-all group">
                        <div class="text-3xl sm:text-4xl font-black text-amber-400 tracking-tight mb-2 group-hover:text-amber-300 transition-colors">
                            <?php echo $stat['number']; ?>
                        </div>
                        <div class="text-base font-bold text-white mb-2">
                            <?php echo $stat['label']; ?>
                        </div>
                        <div class="text-xs text-slate-500 leading-relaxed">
                            <?php echo $stat['sub']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- ====== RODAPÉ (FOOTER) ====== -->
    <footer id="contato" class="bg-slate-950 text-slate-300 border-t-4 border-amber-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

                <!-- Coluna 1: Logo & Sobre -->
                <div class="space-y-4">
                    <a href="index.php" class="flex items-center gap-3 group" aria-label="Conexão Cânions">
                        <img src="assets/images/logo_icon.png" alt="Conexão Cânions" class="w-10 h-10 object-contain group-hover:scale-105 transition-transform shrink-0 drop-shadow-md">
                        <div class="flex flex-col">
                            <span class="text-base font-black tracking-tight text-white group-hover:text-amber-400 transition-colors">
                                CONEXÃO <span class="text-amber-500">CÂNIONS</span>
                            </span>
                            <span class="text-[10px] text-amber-400/80 font-semibold tracking-wider uppercase">
                                Conectando você ao melhor do Velho Chico
                            </span>
                        </div>
                    </a>

                    <p class="text-xs text-slate-500 leading-relaxed">
                        Guia turístico privado da Região dos Cânions do São Francisco, cobrindo <strong class="text-slate-400">Canindé de São Francisco (SE)</strong> e <strong class="text-slate-400">Piranhas (AL)</strong> com foco em ecoturismo, cultura e gastronomia.
                    </p>

                    <div class="flex items-center gap-3 pt-1">
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 text-slate-400 hover:text-slate-950 hover:bg-amber-500 flex items-center justify-center transition" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 text-slate-400 hover:text-slate-950 hover:bg-amber-500 flex items-center justify-center transition" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 text-slate-400 hover:text-slate-950 hover:bg-amber-500 flex items-center justify-center transition" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                        <a href="https://wa.me/5579998443311" target="_blank" class="w-9 h-9 rounded-lg bg-slate-900 text-slate-400 hover:text-white hover:bg-emerald-600 flex items-center justify-center transition" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Coluna 2: Acesso Rápido -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider border-b border-slate-900 pb-3 mb-4">Acesso Rápido</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="#inicio" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-600"></i> Início</a></li>
                        <li><a href="restaurantes.php" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-600"></i> Guia Gastronômico</a></li>
                        <li><a href="#hospedagem" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-600"></i> Onde Ficar</a></li>
                        <li><a href="#turismo" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-600"></i> Passeios & Cânions</a></li>
                        <li><a href="#cordel-cangaco" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-600"></i> Rota do Cangaço</a></li>
                        <li><a href="#eventos" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-600"></i> Calendário de Eventos</a></li>
                    </ul>
                </div>

                <!-- Coluna 3: Serviços ao Turista -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider border-b border-slate-900 pb-3 mb-4">Serviços ao Turista</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><button onclick="showQuickInfo('catamaras')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-ship text-[10px] text-amber-600"></i> Passeios de Catamarã</button></li>
                        <li><button onclick="showQuickInfo('guias')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-user-check text-[10px] text-amber-600"></i> Guias de Turismo</button></li>
                        <li><button onclick="showQuickInfo('hospedagem')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-hotel text-[10px] text-amber-600"></i> Rede Hoteleira</button></li>
                        <li><button onclick="showQuickInfo('gastronomia')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-utensils text-[10px] text-amber-600"></i> Restaurantes & Bares</button></li>
                        <li><button onclick="showQuickInfo('comochegar')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-route text-[10px] text-amber-600"></i> Como Chegar à Região</button></li>
                    </ul>
                </div>

                <!-- Coluna 4: Contatos -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider border-b border-slate-900 pb-3 mb-4">Contatos & Atendimento</h3>
                    <ul class="space-y-3 text-xs text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-amber-600 mt-0.5"></i>
                            <span>Região do Xingó, Canindé de São Francisco (SE) & Piranhas (AL)</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-amber-600"></i>
                            <span>contato@conexaocanions.com.br</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                            <a href="https://wa.me/5579998443311" target="_blank" class="hover:text-emerald-400 transition">(79) 99844-3311</a>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-clock text-amber-600"></i>
                            <span>Atendimento ao Turista: Segunda a Domingo</span>
                        </li>
                    </ul>

                    <!-- Botão Anunciar no footer -->
                    <a href="https://wa.me/5579998443311?text=Olá!%20Quero%20anunciar%20meu%20negócio%20no%20portal%20Conexão%20Cânions."
                       target="_blank"
                       class="mt-5 w-full bg-gradient-to-r from-orange-700 to-amber-600 hover:from-orange-600 hover:to-amber-500 text-white font-bold px-4 py-2.5 rounded-xl text-xs transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-bullhorn"></i> Anunciar Estabelecimento
                    </a>
                </div>

            </div>

            <!-- Direitos Autorais -->
            <div class="border-t border-slate-900 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-600">
                <p>© <?php echo $currentYear; ?> CONEXÃO CÂNIONS - Conectando você ao melhor do Velho Chico. Todos os direitos reservados.</p>
                <div class="flex items-center gap-4">
                    <a href="index.php" class="hover:text-slate-400 transition">Início</a>
                    <span>•</span>
                    <a href="restaurantes.php" class="hover:text-slate-400 transition">Guia Gastronômico</a>
                    <span>•</span>
                    <a href="#contato" class="hover:text-slate-400 transition">Contato</a>
                    <span>•</span>
                    <a href="admin/login.php" class="hover:text-slate-400 transition">Admin</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ====== MODAIS ====== -->

    <!-- Modal Fale Conosco -->
    <div id="contact-modal" class="fixed inset-0 z-50 hidden bg-slate-950/85 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-sertao-border rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative modal-enter">
            <button onclick="toggleModal('contact-modal')" class="absolute top-5 right-5 text-slate-500 hover:text-white text-xl w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center transition" aria-label="Fechar">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="flex items-center gap-3 mb-5">
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-comments"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Fale Conosco</h3>
                    <p class="text-xs text-slate-400">Conexão Cânions — Atendimento & Informações Turísticas</p>
                </div>
            </div>

            <form onsubmit="handleFormSubmit(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1">Seu Nome Completo</label>
                    <input type="text" required placeholder="Digite seu nome" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm placeholder-slate-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1">E-mail de Contato</label>
                    <input type="email" required placeholder="seuemail@exemplo.com" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm placeholder-slate-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1">Assunto</label>
                    <select class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                        <option>Informações sobre Passeios de Catamarã</option>
                        <option>Rota do Cangaço e Guias Turísticos</option>
                        <option>Hospedagem e Alimentação</option>
                        <option>Anunciar meu Estabelecimento</option>
                        <option>Eventos Regionais</option>
                        <option>Outros Assuntos</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1">Sua Mensagem</label>
                    <textarea rows="3" required placeholder="Como podemos ajudar em sua visita à Região dos Cânions?" class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm resize-none placeholder-slate-600"></textarea>
                </div>
                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold py-3 rounded-xl shadow-lg transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Enviar Mensagem
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Busca -->
    <div id="search-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-start justify-center pt-20 p-4">
        <div class="bg-slate-900 border border-sertao-border rounded-2xl max-w-xl w-full p-6 shadow-2xl relative modal-enter">
            <button onclick="toggleModal('search-modal')" class="absolute top-4 right-4 text-slate-500 hover:text-white text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass text-amber-500"></i> Buscar no Portal Conexão Cânions
            </h3>

            <input type="text" id="search-input" onkeyup="handleSearch()" placeholder="Digite o que procura (ex: Cânions, Angico, Hotéis...)"
                   class="w-full px-4 py-3 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm mb-4 placeholder-slate-500">

            <div id="search-results" class="space-y-2 max-h-60 overflow-y-auto text-xs text-slate-400">
                <p class="text-slate-500 italic">Digite algo acima para pesquisar...</p>
            </div>
        </div>
    </div>

    <!-- Modal Info Rápida -->
    <div id="quick-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-sertao-border rounded-2xl max-w-md w-full p-6 shadow-2xl relative modal-enter">
            <button onclick="toggleModal('quick-modal')" class="absolute top-4 right-4 text-slate-500 hover:text-white text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div id="quick-modal-content"></div>
        </div>
    </div>

    <!-- Modal Cadastrar Restaurante -->
    <div id="register-restaurant-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-slate-900 border border-sertao-border rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl relative my-8 modal-enter max-h-[90vh] overflow-y-auto">

            <button onclick="toggleModal('register-restaurant-modal')" class="absolute top-5 right-5 text-slate-500 hover:text-white text-xl w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center transition" aria-label="Fechar">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="flex items-center gap-3 mb-5 border-b border-sertao-border pb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-xl font-bold shrink-0">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-white">Anuncie seu Estabelecimento</h3>
                    <p class="text-xs text-amber-500/80 font-semibold">Portal Conexão Cânions — Canindé (SE) & Piranhas (AL)</p>
                </div>
            </div>

            <div class="bg-amber-950/30 border-l-4 border-amber-500 p-4 rounded-r-xl mb-6">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-amber-500 text-base mt-0.5 shrink-0"></i>
                    <p class="text-xs text-amber-200 leading-relaxed">
                        <strong>Nota:</strong> Seu cadastro será analisado pela nossa equipe antes de ser publicado no guia.
                    </p>
                </div>
            </div>

            <?php if ($userMsg === 'success'): ?>
                <div class="bg-emerald-900/30 border border-emerald-700 text-emerald-300 p-4 rounded-xl mb-4 text-sm font-medium">
                    <i class="fa-solid fa-circle-check mr-2"></i> Cadastro enviado com sucesso! Em breve nossa equipe analisará e publicará seu estabelecimento.
                </div>
            <?php elseif ($userMsg === 'error'): ?>
                <div class="bg-red-900/30 border border-red-700 text-red-300 p-4 rounded-xl mb-4 text-sm font-medium">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i> Erro ao processar solicitação. Tente novamente ou entre em contato via WhatsApp.
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php" class="space-y-4">
                <input type="hidden" name="user_register_restaurant" value="1">

                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1">Nome do Estabelecimento *</label>
                    <input type="text" name="name" required placeholder="Ex: Restaurante Sabor do Velho Chico"
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm placeholder-slate-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-1">Categoria *</label>
                        <select name="category" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                            <option value="">Selecione</option>
                            <option>Peixes & Frutos do Rio</option>
                            <option>Comida Típica Sertaneja</option>
                            <option>Buffet & Self-Service</option>
                            <option>Lanchonete & Petiscaria</option>
                            <option>Pizzaria & Italiana</option>
                            <option>Doces & Sobremesas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 mb-1">Cidade *</label>
                        <select name="cidade" required class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                            <option value="Canindé de São Francisco">Canindé de São Francisco (SE)</option>
                            <option value="Piranhas">Piranhas (AL)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1">Telefone / WhatsApp *</label>
                    <input type="tel" name="phone" required placeholder="(79) 99999-9999"
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm placeholder-slate-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1">Endereço *</label>
                    <input type="text" name="location" required placeholder="Ex: Av. Beira Rio, nº 120 - Centro"
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm placeholder-slate-600">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 mb-1">Prato Destaque / Descrição *</label>
                    <textarea name="description" rows="3" required placeholder="Pratos principais, horários e diferenciais..."
                              class="w-full px-4 py-2.5 rounded-xl bg-slate-800 border border-sertao-border text-white focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm resize-none placeholder-slate-600"></textarea>
                </div>

                <div class="pt-2 flex flex-col sm:flex-row gap-3">
                    <button type="button" onclick="toggleModal('register-restaurant-modal')" class="w-full sm:w-1/3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold py-3 rounded-xl text-xs transition border border-sertao-border">
                        Cancelar
                    </button>
                    <button type="submit" class="w-full sm:w-2/3 bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold py-3 rounded-xl shadow-lg transition text-xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Enviar Cadastro para Análise
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- quick-modal: única instância no DOM. O duplicado foi removido para corrigir o bug do overlay fantasma. -->

    <!-- ====== JAVASCRIPT ====== -->
    <script>
        // ============================================================
        // SISTEMA DE MODAL — robusto, sem duplicatas, com scroll-lock
        // ============================================================

        /**
         * Abre um modal pelo ID.
         * - Adiciona 'overflow-hidden' ao body para travar o scroll.
         * - Remove a classe 'hidden' APENAS do overlay com aquele ID.
         */
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        /**
         * Fecha um modal pelo ID.
         * - Adiciona 'hidden' ao overlay pai.
         * - Remove 'overflow-hidden' do body para liberar o scroll.
         */
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        /**
         * Alias legado (usado em onclick="toggleModal(...)" de contact/search/register)
         * Agora delega corretamente para openModal/closeModal sem duplicar estado.
         */
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            if (modal.classList.contains('hidden')) {
                openModal(modalId);
            } else {
                closeModal(modalId);
            }
        }

        // Toggle do Menu Mobile
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            if (menu) {
                menu.classList.toggle('hidden');
                icon.className = menu.classList.contains('hidden')
                    ? 'fa-solid fa-bars-staggered text-2xl'
                    : 'fa-solid fa-xmark text-2xl';
            }
        }

        // Modal de Informações Rápidas
        function showQuickInfo(type) {
            const contentDiv = document.getElementById('quick-modal-content');
            let html = '';

            const infoMap = {
                gastronomia: {
                    icon: 'fa-utensils', color: 'text-amber-400', bg: 'bg-amber-500/20',
                    title: 'Onde Comer na Região dos Cânions',
                    desc: 'Saboreie o melhor da culinária sertaneja: peixe frito do Rio São Francisco (Tucunaré e Surubim), carne de sol com macaxeira e doces típicos nas duas cidades.',
                    items: [
                        'Restaurante Karrancas: Orla do Cânion — Peixes e Buffet variado',
                        'Restaurante Castanho: Gastronomia com vista para as águas do Chico',
                        'Sabor do Sertão: Comida caseira sertaneja no centro de Canindé'
                    ]
                },
                hospedagem: {
                    icon: 'fa-hotel', color: 'text-sky-400', bg: 'bg-sky-500/20',
                    title: 'Onde Ficar na Região dos Cânions',
                    desc: 'Acomodações para todos os perfis em Canindé (SE) e Piranhas (AL), com vista para a caatinga e para o Rio São Francisco.',
                    items: [
                        'Xingó Parque Hotel: Estrutura completa de lazer com vista panorâmica (Canindé)',
                        'Pousada do Velho Chico: Conforto e localização central (Canindé)',
                        'Hotel das Piranhas: Centro histórico de Piranhas com acesso ao Museu do Cangaço'
                    ]
                },
                comochegar: {
                    icon: 'fa-route', color: 'text-emerald-400', bg: 'bg-emerald-500/20',
                    title: 'Como Chegar à Região dos Cânions',
                    desc: 'Canindé de São Francisco fica a 213 km de Aracaju (SE) e a 15 km de Piranhas (AL). Piranhas fica a 280 km de Maceió.',
                    items: [
                        'De Aracaju (SE): Siga pela SE-230 via Nossa Senhora da Glória até Canindé',
                        'De Maceió (AL): Siga pela AL-220 via Delmiro Gouveia até Piranhas',
                        'De Ônibus: Linhas diárias nos terminais rodoviários de Aracaju e Maceió'
                    ]
                },
                catamaras: {
                    icon: 'fa-ship', color: 'text-blue-400', bg: 'bg-blue-500/20',
                    title: 'Passeios de Catamarã & Cânions',
                    desc: 'Navegue com conforto e segurança pelos Cânions do Xingó — uma das experiências mais incríveis do Brasil.',
                    items: [
                        'Duração: Aprox. 3 horas com parada para banho no Porto de Alagadiço',
                        'Saídas: Diárias a partir dos embarcadouros de Canindé de São Francisco',
                        'Grupos e passeios privativos disponíveis — consulte via WhatsApp'
                    ]
                },
                guias: {
                    icon: 'fa-user-check', color: 'text-purple-400', bg: 'bg-purple-500/20',
                    title: 'Guias de Turismo Credenciados',
                    desc: 'Conheça a região com guias profissionais credenciados que dominam a história, os cânions e as trilhas da Rota do Cangaço.',
                    items: [
                        'Guias bilíngues disponíveis (Português e Inglês)',
                        'Especializados em Rota do Cangaço, Grota do Angico e Cânions',
                        'Agendamento via WhatsApp: (79) 99844-3311'
                    ]
                }
            };

            const info = infoMap[type] || {
                icon: 'fa-circle-info', color: 'text-amber-400', bg: 'bg-amber-500/20',
                title: 'Informações Turísticas',
                desc: 'Para mais informações sobre turismo na Região dos Cânions, entre em contato via WhatsApp.',
                items: ['WhatsApp: (79) 99844-3311', 'E-mail: contato@conexaocanions.com.br', 'Atendimento: Segunda a Domingo']
            };

            html = `
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl ${info.bg} ${info.color} flex items-center justify-center text-lg">
                        <i class="fa-solid ${info.icon}"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">${info.title}</h3>
                </div>
                <p class="text-xs text-slate-400 mb-4 leading-relaxed">${info.desc}</p>
                <ul class="text-xs space-y-2">
                    ${info.items.map(i => `<li class="p-2.5 bg-slate-800 rounded-xl border border-zinc-800 text-slate-300">${i}</li>`).join('')}
                </ul>
                <div class="mt-5 pt-4 border-t border-zinc-800">
                    <a href="https://wa.me/5579998443311?text=Olá!%20Quero%20informações%20sobre%20${encodeURIComponent(info.title)}" target="_blank"
                       class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition">
                        <i class="fa-brands fa-whatsapp"></i> Falar via WhatsApp
                    </a>
                </div>
            `;

            contentDiv.innerHTML = html;

            openModal('quick-modal');
        }

        // Modal de Roteiro do Atrativo
        function openAttractionModal(id) {
            const data = <?php echo json_encode($attractions); ?>;
            const item = data.find(i => i.id === id);
            if (!item) return;

            const html = `
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">${item.title}</h3>
                        <span class="text-xs font-semibold text-amber-500/80">${item.subtitle}</span>
                    </div>
                </div>
                <img src="${item.image}" class="w-full h-48 object-cover rounded-xl mb-4 border border-zinc-800" alt="${item.title}">
                <p class="text-xs text-slate-400 leading-relaxed mb-4">${item.description}</p>
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">O que você vai vivenciar:</h4>
                <ul class="text-xs text-slate-300 space-y-1.5 mb-5">
                    ${item.highlights.map(h => `<li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500"></i> ${h}</li>`).join('')}
                </ul>
                <div class="border-t border-zinc-800 pt-4">
                    <a href="https://wa.me/5579998443311?text=Olá!%20Quero%20informações%20sobre:%20${encodeURIComponent(item.title)}" target="_blank"
                       class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition">
                        <i class="fa-brands fa-whatsapp"></i> Agendar via WhatsApp
                    </a>
                </div>
            `;

            document.getElementById('quick-modal-content').innerHTML = html;
            openModal('quick-modal');
        }

        // Busca simples
        function handleSearch() {
            const query = document.getElementById('search-input').value.toLowerCase().trim();
            const resultsDiv = document.getElementById('search-results');
            if (!query) {
                resultsDiv.innerHTML = '<p class="text-slate-500 italic">Digite algo acima para pesquisar...</p>';
                return;
            }

            const items = [
                { name: 'Cânions do Xingó', link: '#turismo', desc: 'Navegação em catamarã e banho de rio' },
                { name: 'Rota do Cangaço e Grota do Angico', link: '#cordel-cangaco', desc: 'Trilha histórica onde Lampião viveu a última batalha (1938)' },
                { name: 'Usina Hidrelétrica de Xingó', link: '#turismo', desc: 'Visita técnica ao complexo de engenharia da CHESF' },
                { name: 'Mirante da Seabra', link: '#turismo', desc: 'Pôr do sol panorâmico no Rio São Francisco' },
                { name: 'Onde Comer — Guia Gastronômico', link: 'restaurantes.php', desc: 'Peixes do Velho Chico, carne de sol e gastronomia regional' },
                { name: 'Onde Ficar — Hospedagem', link: '#hospedagem', desc: 'Hotéis e pousadas em Canindé e Piranhas' },
                { name: 'Como Chegar à Região', link: 'javascript:showQuickInfo("comochegar")', desc: 'Rotas de acesso a partir de Aracaju e Maceió' },
                { name: 'Festival Cordel & Cangaço', link: '#eventos', desc: 'Poesia, viola e repentistas em Setembro' },
                { name: 'Passeios de Catamarã', link: 'javascript:showQuickInfo("catamaras")', desc: 'Navegue pelos cânions com segurança e conforto' },
                { name: 'Piranhas — Patrimônio Histórico', link: '#nossa-cidade', desc: 'Centro histórico e Museu do Cangaço em Piranhas (AL)' },
            ];

            const filtered = items.filter(i => i.name.toLowerCase().includes(query) || i.desc.toLowerCase().includes(query));

            if (filtered.length === 0) {
                resultsDiv.innerHTML = `<p class="text-slate-500">Nenhum resultado para "<strong class="text-slate-400">${query}</strong>".</p>`;
            } else {
                resultsDiv.innerHTML = filtered.map(i => `
                    <a href="${i.link}" onclick="toggleModal('search-modal')" class="block p-2.5 hover:bg-slate-800 rounded-xl transition border border-transparent hover:border-zinc-700">
                        <div class="font-bold text-white text-xs">${i.name}</div>
                        <div class="text-slate-500 text-[11px] mt-0.5">${i.desc}</div>
                    </a>
                `).join('');
            }
        }

        // Submissão do formulário de contato (demo)
        function handleFormSubmit(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button[type="submit"]');
            btn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Mensagem enviada!';
            btn.classList.replace('bg-amber-500', 'bg-emerald-500');
            setTimeout(() => closeModal('contact-modal'), 1500);
        }

        // Rolagem do Carrossel
        function scrollRestaurants(direction) {
            const container = document.getElementById('restaurant-carousel');
            if (!container || !container.firstElementChild) return;
            const itemWidth = container.firstElementChild.clientWidth + 24;
            container.scrollBy({ left: direction === 'left' ? -itemWidth : itemWidth, behavior: 'smooth' });
        }

        // ---- Fechar ao clicar no overlay (fundo escuro) ----
        // Funciona para TODOS os modais: basta clicar fora do card interno.
        const ALL_MODAL_IDS = ['contact-modal', 'search-modal', 'register-restaurant-modal', 'quick-modal'];

        document.addEventListener('click', function(e) {
            ALL_MODAL_IDS.forEach(id => {
                const modal = document.getElementById(id);
                // O clique foi diretamente no overlay (não no conteúdo interno)
                if (modal && !modal.classList.contains('hidden') && e.target === modal) {
                    closeModal(id);
                }
            });
        });

        // ---- Fechar com tecla ESC ----
        document.addEventListener('keydown', function(e) {
            if (e.key !== 'Escape') return;
            ALL_MODAL_IDS.forEach(id => {
                const modal = document.getElementById(id);
                if (modal && !modal.classList.contains('hidden')) {
                    closeModal(id);
                }
            });
        });

        // Fechar mobile menu ao rolar
        window.addEventListener('scroll', () => {
            const menu = document.getElementById('mobile-menu');
            if (menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                document.getElementById('menu-icon').className = 'fa-solid fa-bars-staggered text-2xl';
            }
        }, { passive: true });
    </script>

</body>
</html>
