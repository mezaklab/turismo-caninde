<?php
header('Content-Type: text/html; charset=utf-8');
// Prefeitura de Canindé de São Francisco - Sergipe
// Portal de Turismo Oficial
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
        'title' => 'Mirante da Seabra',
        'subtitle' => 'Vista panorâmica inesquecível da cidade e do rio',
        'tag' => 'CONTEMPLAÇÃO',
        'badge_type' => 'green',
        'image' => 'assets/images/mirante_seabra.jpg',
        'description' => 'Ponto mais alto e privilegiado para contemplar o pôr do sol dourado refletindo no Rio São Francisco e contornando Canindé de São Francisco.',
        'highlights' => ['Pôr do Sol Fotogênico', 'Vista 360° da Região do Semiárido', 'Brisa Suave do Sertão', 'Espaço para Relaxar e Fotografar']
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
        'title' => 'Festival Cordel & Cangaço de Canindé',
        'location' => 'Centro Cultural Xingó',
        'category' => 'Arte & Literatura',
        'image' => 'assets/images/rota_cangaco.jpg',
        'excerpt' => 'Encontro de violeiros, repentistas, declamadores de cordel e encenações teatrais da Rota do Cangaço com gastronomia típica do sertão.'
    ],
    [
        'day' => '12',
        'month' => 'OUT',
        'title' => 'Desafio Cânions Run & EcoTrilha',
        'location' => 'Trilha do Talhado / Rio São Francisco',
        'category' => 'Esporte & Aventura',
        'image' => 'assets/images/canions_xingo.jpg',
        'excerpt' => 'Corrida de aventura e corrida aquática em caiaque entre as formações rochosas espetaculares dos Cânions do Xingó.'
    ]
];

// Estatísticas
$stats = [
    ['number' => '5º', 'label' => 'Maior Cânion Navegável', 'sub' => 'do Mundo em extensão de água doce'],
    ['number' => '+350k', 'label' => 'Turistas por Ano', 'sub' => 'Buscando ecoturismo e história'],
    ['number' => '1938', 'label' => 'Ano Histórico do Angico', 'sub' => 'Capítulo marcante do Cangaço'],
    ['number' => '100%', 'label' => 'Hospitalidade Sertaneja', 'sub' => 'Povo acolhedor de Canindé']
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

    if (!empty($nome) && !empty($telefone)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO restaurantes (nome, categoria, prato_destaque, endereco, telefone, status) VALUES (:nome, :categoria, :prato_destaque, :endereco, :telefone, 'pendente')");
            $stmt->execute([
                'nome' => $nome,
                'categoria' => $categoria,
                'prato_destaque' => $descricao,
                'endereco' => $endereco,
                'telefone' => $telefone
            ]);
            $userMsg = 'Seu cadastro foi enviado com sucesso! A Prefeitura de Canindé de São Francisco analisará as informações antes da publicação.';
        } catch (PDOException $e) {
            $userMsg = 'Erro ao processar solicitação no banco MySQL.';
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
    <title>Turismo Canindé de São Francisco - Sergipe | Portal Oficial</title>
    <meta name="description" content="Descubra os Cânions do Xingó, Rota do Cangaço, Usina do Xingó e a rica cultura de Cordel em Canindé de São Francisco, Sergipe. Viva essa experiência!">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Eczar:wght@500;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,800;1,600;1,800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 icons -->
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
                            amberDark: '#b45309',
                            sertao: '#15803d',
                            sertaoDark: '#166534',
                            rio: '#0284c7',
                            rioDark: '#0369a1',
                            sand: '#fef3c7',
                            bg: '#f8fafc',
                            dark: '#0f172a',
                            darkCard: '#1e293b'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        cordel: ['Eczar', 'serif'],
                        display: ['Playfair Display', 'serif']
                    }
                }
            }
        }
    </script>

    <style>
        /* Estilos Customizados de Cordel e Xilogravura */
        .cordel-border {
            border: 2px dashed #b45309;
            border-image: repeating-linear-gradient(45deg, #d97706, #d97706 10px, transparent 10px, transparent 20px) 2;
        }
        .cordel-woodcut-box {
            background-color: #fffbeb;
            background-image: radial-gradient(#d97706 0.55px, transparent 0.55px), radial-gradient(#d97706 0.55px, #fffbeb 0.55px);
            background-size: 22px 22px;
            background-position: 0 0, 11px 11px;
            border: 3px solid #78350f;
            box-shadow: 6px 6px 0px #78350f;
        }
        .cordel-stamp {
            background-color: #78350f;
            color: #fef3c7;
            clip-path: polygon(0% 0%, 100% 0%, 95% 50%, 100% 100%, 0% 100%, 5% 50%);
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .hero-overlay {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.75) 0%, rgba(15, 23, 42, 0.5) 50%, rgba(15, 23, 42, 0.95) 100%);
        }
        .text-glow-gold {
            text-shadow: 0 0 20px rgba(234, 179, 8, 0.4);
        }
        .card-hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-caninde-bg text-slate-800 font-sans antialiased selection:bg-caninde-gold selection:text-slate-900">

    <!-- TOP HEADER INFORMATIVO -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-location-dot text-caninde-gold mr-1"></i> Estado de Sergipe | Região do São Francisco</span>
                <span class="hidden md:inline"><i class="fa-solid fa-sun text-amber-400 mr-1"></i> Sertão Baixo São Francisco</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="#contato" class="hover:text-caninde-gold transition-colors"><i class="fa-solid fa-phone text-caninde-gold mr-1"></i> (79) 3346-1200</a>
                <span class="text-slate-700">|</span>
                <div class="flex items-center gap-3 text-sm">
                    <a href="#" class="hover:text-caninde-gold transition" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="hover:text-caninde-gold transition" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="hover:text-caninde-gold transition" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- CABEÇALHO (NAVBAR) -->
    <header class="sticky top-0 z-50 transition-all duration-300 glass-nav border-b border-slate-700/50 shadow-lg" id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <a href="#" class="flex items-center gap-3 group">
                    <img src="assets/images/brasao_oficial.png" alt="Brasão Oficial de Canindé de São Francisco" class="h-16 w-auto object-contain drop-shadow-md group-hover:scale-105 transition-transform">
                    <div class="flex flex-col">
                        <span class="text-xs tracking-widest text-amber-400 font-bold uppercase">Prefeitura de</span>
                        <span class="text-lg font-extrabold tracking-tight text-white group-hover:text-amber-300 transition-colors">
                            CANINDÉ DE SÃO FRANCISCO
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden lg:flex items-center gap-7">
                    <a href="#inicio" class="text-sm font-semibold text-white hover:text-caninde-gold transition-colors relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-caninde-gold">Início</a>
                    <a href="#nossa-cidade" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Nossa Cidade</a>
                    <a href="#turismo" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Turismo</a>
                    <a href="#cordel-cangaco" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Rota do Cangaço</a>
                    <a href="#onde-comer" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Onde Comer</a>
                    <a href="#eventos" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Eventos</a>
                    <a href="#estatisticas" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Números</a>
                    <a href="#contato" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Contato</a>
                </nav>

                <!-- Action Buttons & Search -->
                <div class="hidden sm:flex items-center gap-3">
                    <button onclick="toggleModal('search-modal')" class="p-2.5 rounded-lg text-slate-300 hover:text-caninde-gold hover:bg-slate-800/80 transition" title="Buscar no portal" aria-label="Abrir busca">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>

                    <button onclick="toggleModal('contact-modal')" class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold px-5 py-2.5 rounded-xl shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 transition-all transform hover:-translate-y-0.5 flex items-center gap-2 text-sm">
                        <i class="fa-solid fa-comments"></i>
                        <span>Fale com a Prefeitura</span>
                    </button>
                </div>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition" aria-label="Menu Principal">
                    <i class="fa-solid fa-bars-staggered text-2xl" id="menu-icon"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div id="mobile-menu" class="hidden lg:hidden bg-slate-900 border-b border-slate-800 px-4 pt-3 pb-6 space-y-3">
            <a href="#inicio" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-semibold text-caninde-gold bg-slate-800/60">Início</a>
            <a href="#nossa-cidade" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Nossa Cidade</a>
            <a href="#turismo" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Turismo</a>
            <a href="#cordel-cangaco" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Rota do Cangaço</a>
            <a href="#eventos" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Eventos</a>
            <a href="#estatisticas" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Números</a>
            <a href="#contato" onclick="toggleMobileMenu()" class="block py-2.5 px-3 rounded-lg font-medium text-slate-200 hover:bg-slate-800">Contato</a>
            <div class="pt-2 flex flex-col gap-2">
                <button onclick="toggleMobileMenu(); toggleModal('search-modal')" class="w-full text-left py-2.5 px-3 rounded-lg font-medium text-slate-300 bg-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-caninde-gold"></i> Buscar no Portal
                </button>
                <button onclick="toggleMobileMenu(); toggleModal('contact-modal')" class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold py-3 rounded-xl text-center flex items-center justify-center gap-2 shadow-md">
                    <i class="fa-solid fa-comments"></i> Fale com a Prefeitura
                </button>
            </div>
        </div>
    </header>

    <!-- HERO SECTION (BANNER PRINCIPAL) -->
    <section id="inicio" class="relative min-h-[85vh] lg:min-h-[90vh] flex items-center justify-center bg-slate-950 overflow-hidden pt-12 pb-32">
        <!-- Imagem de Fundo com Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="assets/images/hero_canyons.jpg" alt="Cânions do Xingó no Rio São Francisco" class="w-full h-full object-cover object-center scale-105 transition-transform duration-1000">
            <div class="absolute inset-0 hero-overlay"></div>
        </div>

        <!-- Elementos Decorativos -->
        <div class="absolute top-10 left-10 w-72 h-72 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 text-center text-white">
            
            <!-- Tag de Boas-Vindas -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900/80 backdrop-blur-md border border-amber-500/40 text-amber-400 text-xs sm:text-sm font-bold tracking-wider uppercase mb-8 shadow-xl">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                <i class="fa-solid fa-compass text-amber-400"></i> BEM-VINDO A CANINDÉ DE SÃO FRANCISCO
            </div>

            <!-- Título Principal -->
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-white leading-none mb-6">
                História, natureza e cultura que <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-amber-400 to-amber-500 font-display italic font-semibold text-glow-gold">encantam</span>
            </h1>

            <!-- Subtítulo -->
            <p class="text-lg sm:text-xl md:text-2xl text-slate-200 font-light max-w-3xl mx-auto leading-relaxed mb-10 text-shadow">
                Navegue pelas águas cristalinas do Rio São Francisco, descubra os imponentes Cânions do Xingó e vivencie a autêntica tradição do Cangaço e do Cordel no coração de Sergipe.
            </p>

            <!-- Botões de Ação -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
                <a href="#turismo" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold text-base px-8 py-4 rounded-xl shadow-xl shadow-amber-500/30 hover:shadow-amber-500/50 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3">
                    <span>Conheça Canindé</span>
                    <i class="fa-solid fa-arrow-down-long"></i>
                </a>

                <button onclick="toggleModal('video-modal')" class="w-full sm:w-auto bg-slate-900/70 hover:bg-slate-900/90 text-white font-semibold text-base px-8 py-4 rounded-xl border border-slate-600/80 hover:border-amber-400/60 backdrop-blur-md transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 group">
                    <span class="w-8 h-8 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center text-xs group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-play ml-0.5"></i>
                    </span>
                    <span>Assista ao Vídeo</span>
                </button>
            </div>
        </div>
    </section>

    <!-- CARDS DE ACESSO RÁPIDO (Flutuando sobre a divisa da Hero) -->
    <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 -mt-20">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 sm:gap-4">
            
            <!-- Card 1 -->
            <a href="#turismo" class="bg-white rounded-2xl p-5 shadow-xl border-t-4 border-amber-500 text-slate-800 card-hover-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-3 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-amber-600 transition-colors">Pontos Turísticos</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Cânions, mirantes e passeios</p>
            </a>

            <!-- Card 2 -->
            <a href="#eventos" class="bg-white rounded-2xl p-5 shadow-xl border-t-4 border-amber-500 text-slate-800 card-hover-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-3 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                    <i class="fa-solid fa-calendar-star"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-amber-600 transition-colors">Eventos Típicos</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Festas e celebrações</p>
            </a>

            <!-- Card 3 -->
            <a href="#onde-comer" class="bg-white rounded-2xl p-5 shadow-xl border-t-4 border-amber-500 text-slate-800 card-hover-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-3 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                    <i class="fa-solid fa-utensils"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-amber-600 transition-colors">Onde Comer</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Gastronomia sergipana</p>
            </a>

            <!-- Card 4 -->
            <button onclick="showQuickInfo('hospedagem')" class="bg-white rounded-2xl p-5 shadow-xl border-t-4 border-amber-500 text-slate-800 card-hover-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-3 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                    <i class="fa-solid fa-hotel"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-amber-600 transition-colors">Onde Ficar</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Hotéis e pousadas</p>
            </button>

            <!-- Card 5 -->
            <button onclick="showQuickInfo('comochegar')" class="col-span-2 md:col-span-1 bg-white rounded-2xl p-5 shadow-xl border-t-4 border-amber-500 text-slate-800 card-hover-lift group flex flex-col items-center text-center">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-3 group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                    <i class="fa-solid fa-route"></i>
                </div>
                <h3 class="font-bold text-sm sm:text-base text-slate-900 group-hover:text-amber-600 transition-colors">Como Chegar</h3>
                <p class="text-xs text-slate-500 mt-1 hidden sm:block">Rotas e acessos fáceis</p>
            </button>

        </div>
    </div>

    <!-- SEÇÃO NOSSA CIDADE & CORDEL BOAS-VINDAS -->
    <section id="nossa-cidade" class="py-20 bg-caninde-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Informações da Cidade -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-emerald-100 text-emerald-800 text-xs font-extrabold tracking-wider uppercase">
                        <i class="fa-solid fa-landmark"></i> NOSSA CIDADE HISTÓRICA
                    </div>
                    
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        Canindé de São Francisco: Onde a força do Velho Chico abraça o Sertão
                    </h2>

                    <p class="text-slate-650 text-base sm:text-lg leading-relaxed">
                        Localizada no extremo noroeste de Sergipe, às margens do majestoso Rio São Francisco, Canindé de São Francisco é um polo nacional de ecoturismo, arqueologia e história cultural do Nordeste brasileiro.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-white shadow-sm border border-slate-100">
                            <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-water"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Águas Cristalinas</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Navegação e banho seguro em águas calmas</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-xl bg-white shadow-sm border border-slate-100">
                            <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-lg shrink-0">
                                <i class="fa-solid fa-hat-cowboy"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Herança do Cangaço</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Trilhas preservadas e lendas vivas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estrofe em formato de Cordel de Boas-Vindas -->
                <div class="lg:col-span-5">
                    <div class="cordel-woodcut-box p-8 rounded-2xl relative overflow-hidden">
                        
                        <div class="flex items-center justify-between border-b-2 border-amber-900/30 pb-4 mb-6">
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-feather-pointed text-2xl text-amber-900"></i>
                                <span class="font-cordel font-bold text-amber-950 text-xl tracking-wide uppercase">Cordel de Canindé</span>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 bg-amber-900 text-amber-100 rounded">Estrofe Popular</span>
                        </div>

                        <!-- Estrofe em Cordel -->
                        <blockquote class="font-cordel text-xl sm:text-2xl text-amber-950 leading-relaxed italic font-medium text-center py-2">
                            "Nas curvas do Velho Chico,<br>
                            Canindé faz o sertão florir,<br>
                            Com cânions de imenso encanto,<br>
                            E estórias pra se ouvir.<br>
                            Da Grota até as Usinas,<br>
                            É beleza sem ter fim!"
                        </blockquote>

                        <div class="mt-6 text-right border-t border-amber-900/20 pt-3">
                            <span class="text-xs font-bold text-amber-900 uppercase tracking-widest">— Tradição Oral de Canindé</span>
                        </div>

                        <!-- Detalhe decorativo estilo xilogravura -->
                        <div class="absolute -bottom-6 -right-6 opacity-10 text-amber-950 pointer-events-none">
                            <i class="fa-solid fa-sun text-9xl"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SEÇÃO "ENCANTOS QUE VOCÊ PRECISA CONHECER" -->
    <section id="turismo" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Cabeçalho da Seção -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-amber-100 text-amber-800 text-xs font-extrabold tracking-wider uppercase mb-3">
                        <i class="fa-solid fa-star text-amber-600"></i> ATRATIVOS PRINCIPAIS
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                        Encantos que você precisa conhecer
                    </h2>
                    <p class="text-slate-600 mt-2 text-base max-w-2xl">
                        Explore as maravilhas naturais, históricas e arquitetônicas que fazem de Canindé de São Francisco um destino inesquecível.
                    </p>
                </div>
                
                <a href="#cordel-cangaco" class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-bold text-sm group">
                    <span>Ver Rota Cultural Completa</span>
                    <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <!-- Grid de 4 Cards de Atrativos Turísticos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach ($attractions as $item): ?>
                    <div class="bg-caninde-bg rounded-2xl overflow-hidden border border-slate-200/80 shadow-md card-hover-lift flex flex-col group">
                        
                        <!-- Imagem do Card -->
                        <div class="relative h-56 overflow-hidden">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['title']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            
                            <!-- Badges Dinâmicas -->
                            <div class="absolute top-4 left-4">
                                <?php if ($item['badge_type'] === 'blue'): ?>
                                    <span class="bg-sky-600 text-white font-extrabold text-[11px] px-3 py-1.5 rounded-lg shadow-md tracking-wider uppercase flex items-center gap-1.5">
                                        <i class="fa-solid fa-water"></i> <?php echo $item['tag']; ?>
                                    </span>
                                <?php elseif ($item['badge_type'] === 'cordel'): ?>
                                    <span class="bg-amber-500 text-slate-950 font-cordel font-extrabold text-xs px-3 py-1.5 rounded-lg shadow-md border border-amber-950/30 uppercase tracking-wider flex items-center gap-1.5">
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

                        <!-- Conteúdo do Card -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 group-hover:text-amber-600 transition-colors mb-2">
                                    <?php echo $item['title']; ?>
                                </h3>
                                <p class="text-xs font-semibold text-amber-700 mb-3">
                                    <?php echo $item['subtitle']; ?>
                                </p>
                                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                    <?php echo $item['description']; ?>
                                </p>
                            </div>

                            <div class="border-t border-slate-200 pt-4 mt-2">
                                <h4 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Destaques:</h4>
                                <ul class="text-xs text-slate-700 space-y-1.5 mb-5">
                                    <?php foreach (array_slice($item['highlights'], 0, 2) as $hl): ?>
                                        <li class="flex items-center gap-2">
                                            <i class="fa-solid fa-check text-amber-500 font-bold text-xs"></i>
                                            <span><?php echo $hl; ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <button onclick="openAttractionModal('<?php echo $item['id']; ?>')" class="w-full bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white font-bold py-2.5 rounded-xl text-xs transition-all flex items-center justify-center gap-2">
                                    <span>Ver Detalhes do Roteiro</span>
                                    <i class="fa-solid fa-[#chevron-right]"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- SEÇÃO ESPECIAL CORDEL & CANGAÇO -->
    <section id="cordel-cangaco" class="py-20 bg-amber-50/60 relative overflow-hidden border-y border-amber-200/60">
        
        <!-- Textura e Grafismo de Cordel -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-2xl border-2 border-amber-900/20 relative">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                    
                    <!-- Lado Esquerdo: Imagem Xilogravura / História -->
                    <div class="lg:col-span-5 relative">
                        <div class="rounded-2xl overflow-hidden shadow-xl border-4 border-slate-900 group">
                            <img src="assets/images/cordel_art.jpg" alt="Arte Cordel e Rota do Cangaço" class="w-full h-80 lg:h-96 object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="cordel-stamp absolute -top-4 -left-4 font-cordel text-sm font-extrabold px-5 py-2 uppercase tracking-widest shadow-lg">
                            Patrimônio Vivo
                        </div>
                    </div>

                    <!-- Lado Direito: Texto Cultural e Convite -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-amber-200/80 text-amber-950 font-cordel text-xs font-extrabold tracking-wider uppercase border border-amber-900/20">
                            <i class="fa-solid fa-scroll"></i> HISTÓRIA & TRADIÇÃO SERTANEJA
                        </div>

                        <h2 class="text-3xl sm:text-4xl font-cordel font-extrabold text-slate-900 leading-tight">
                            Rota do Cangaço & A Tradição do Cordel de Canindé
                        </h2>

                        <p class="text-slate-700 text-base leading-relaxed">
                            Canindé de São Francisco guarda um dos capítulos mais marcantes da história do Brasil. Foi no coração do nosso bioma Caatinga, na célebre <strong>Grota do Angico</strong>, que o lendário Lampião, Maria Bonita e seu bando viveram seus últimos momentos em 1938.
                        </p>

                        <p class="text-slate-700 text-base leading-relaxed">
                            Até hoje, poetas de cordel, rabequeiros e rústicos contadores de história mantêm viva a memória cultural sertaneja em folhetos gravados com arte em xilogravura.
                        </p>

                        <!-- Box de Citação Cordel -->
                        <div class="cordel-border p-4 bg-amber-50/80 rounded-xl">
                            <p class="font-cordel text-amber-950 text-lg font-bold italic">
                                "Entre pedras e cactos do sertão,<br>
                                A poesia do cordel canta a história do cangaço e a força do nosso chão."
                            </p>
                        </div>

                        <!-- Botão Saiba Mais -->
                        <div class="pt-2">
                            <button onclick="toggleModal('cangaco-modal')" class="bg-amber-600 hover:bg-amber-700 text-slate-950 font-extrabold px-8 py-4 rounded-xl shadow-lg shadow-amber-600/30 transition-all transform hover:-translate-y-1 inline-flex items-center gap-3 text-base">
                                <i class="fa-solid fa-book-open"></i>
                                <span>Saiba Mais Sobre a Rota do Cangaço</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- SEÇÃO "GASTRONOMIA SERTANEJA & ONDE COMER" -->
    <section id="onde-comer" class="py-20 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Cabeçalho da Seção -->
            <div class="mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-amber-100 text-amber-800 text-xs font-extrabold tracking-wider uppercase mb-3">
                    <i class="fa-solid fa-utensils text-amber-600"></i> GASTRONOMIA LOCAL & RESTAURANTES
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Sabores do Sertão & Onde Comer
                </h2>
                <p class="text-slate-600 mt-2 text-base max-w-2xl">
                    Experimente a deliciosa culinária de Canindé de São Francisco: peixes frescos do Rio São Francisco, carne de sol sertaneja, doces tradicionais e tempero acolhedor.
                </p>
            </div>

            <!-- Carrossel de Restaurantes em Destaque (3 no Desktop, 1 no Mobile) -->
            <div class="relative group/onde-comer px-2 sm:px-0">
                
                <!-- Seta de Navegação Esquerda (Flutuante com Transparência e Hover) -->
                <button onclick="scrollRestaurants('left')" class="absolute -left-3 sm:-left-6 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-slate-900/70 hover:bg-amber-500 text-white hover:text-slate-950 backdrop-blur-md opacity-40 group-hover/onde-comer:opacity-75 hover:!opacity-100 transition-all duration-300 transform hover:scale-110 shadow-2xl flex items-center justify-center border border-white/20" title="Restaurante anterior" aria-label="Restaurante anterior">
                    <i class="fa-solid fa-chevron-left text-base sm:text-lg"></i>
                </button>

                <!-- Seta de Navegação Direita (Flutuante com Transparência e Hover) -->
                <button onclick="scrollRestaurants('right')" class="absolute -right-3 sm:-right-6 top-1/2 -translate-y-1/2 z-30 w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-slate-900/70 hover:bg-amber-500 text-white hover:text-slate-950 backdrop-blur-md opacity-40 group-hover/onde-comer:opacity-75 hover:!opacity-100 transition-all duration-300 transform hover:scale-110 shadow-2xl flex items-center justify-center border border-white/20" title="Próximo restaurante" aria-label="Próximo restaurante">
                    <i class="fa-solid fa-chevron-right text-base sm:text-lg"></i>
                </button>

                <!-- Track do Carrossel (3 Cards por vez no Desktop, 1 no Celular com Swipe) -->
                <div id="restaurant-carousel" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth pb-4 pt-2 no-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <?php foreach ($restaurants as $restaurant): ?>
                        <div class="snap-start shrink-0 w-full sm:w-[calc((100%-1.5rem)/2)] lg:w-[calc((100%-3rem)/3)] bg-caninde-bg rounded-2xl overflow-hidden border border-slate-200/80 shadow-md card-hover-lift flex flex-col group">
                            <div class="relative h-48 overflow-hidden">
                                <img src="<?php echo htmlspecialchars($restaurant['image'] ?? 'assets/images/canions_xingo.jpg'); ?>" alt="<?php echo htmlspecialchars($restaurant['name'] ?? $restaurant['nome'] ?? ''); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-4 left-4 bg-amber-500 text-slate-950 font-extrabold text-xs px-3 py-1 rounded-lg shadow-md uppercase tracking-wider">
                                    <?php echo htmlspecialchars($restaurant['category'] ?? $restaurant['categoria'] ?? 'Geral'); ?>
                                </div>
                            </div>
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-amber-600 transition-colors mb-2">
                                        <?php echo htmlspecialchars($restaurant['name'] ?? $restaurant['nome'] ?? ''); ?>
                                    </h3>
                                    <p class="text-xs font-semibold text-amber-700 mb-2 flex items-center gap-1.5">
                                        <i class="fa-solid fa-utensils"></i> <?php echo htmlspecialchars($restaurant['specialty'] ?? $restaurant['prato_destaque'] ?? $restaurant['description'] ?? $restaurant['descricao'] ?? ''); ?>
                                    </p>
                                    <p class="text-xs text-slate-500 mb-4 flex items-start gap-1.5">
                                        <i class="fa-solid fa-location-dot text-amber-500 mt-0.5"></i>
                                        <span><?php echo htmlspecialchars($restaurant['location'] ?? $restaurant['endereco'] ?? ''); ?></span>
                                    </p>
                                </div>
                                <div class="border-t border-slate-200/80 pt-3 flex items-center justify-between text-xs">
                                    <span class="font-bold text-slate-700 flex items-center gap-1">
                                        <i class="fa-brands fa-whatsapp text-emerald-600 text-sm"></i> <?php echo htmlspecialchars($restaurant['phone'] ?? $restaurant['telefone'] ?? ''); ?>
                                    </span>
                                    <span class="bg-slate-200 text-slate-700 px-2.5 py-1 rounded-md text-[10px] font-bold">
                                        <?php echo htmlspecialchars($restaurant['tag'] ?? 'Recomendado'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Botão Ver Todos os Restaurantes (Discreto e Centralizado) -->
            <div class="text-center mt-8 mb-4">
                <a href="restaurantes.php" class="inline-flex items-center gap-2.5 text-slate-600 hover:text-amber-600 font-bold text-sm bg-slate-100 hover:bg-amber-100/80 px-6 py-3 rounded-full transition-all group border border-slate-200/80 shadow-sm">
                    <span>Ver todos os restaurantes</span>
                    <i class="fa-solid fa-arrow-right text-amber-500 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <!-- Chamada para Novos Proprietários -->
            <div class="cordel-border mt-10 p-6 sm:p-8 bg-amber-50/70 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center text-xl shrink-0 shadow-md">
                        <i class="fa-solid fa-utensils"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-slate-900 text-lg">Possui um restaurante ou lanchonete em Canindé?</h4>
                        <p class="text-xs text-slate-600 mt-0.5">Cadastre gratuitamente seu estabelecimento no portal oficial de turismo da Prefeitura.</p>
                    </div>
                </div>
                <button onclick="toggleModal('register-restaurant-modal')" class="w-full sm:w-auto bg-slate-900 hover:bg-amber-500 hover:text-slate-950 text-white font-bold px-6 py-3 rounded-xl text-xs transition-all shrink-0 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus-circle"></i> Cadastrar Estabelecimento
                </button>
            </div>

        </div>
    </section>

    <!-- SEÇÃO "FIQUE POR DENTRO DOS EVENTOS" -->
    <section id="eventos" class="py-20 bg-caninde-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Cabeçalho -->
            <div class="text-center max-w-3xl mx-auto mb-14">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-amber-100 text-amber-800 text-xs font-extrabold tracking-wider uppercase mb-3">
                    <i class="fa-solid fa-calendar-days text-amber-600"></i> AGENDA CULTURAL
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Fique por dentro dos eventos
                </h2>
                <p class="text-slate-600 mt-2 text-base">
                    Confira as festividades, eventos esportivos e encontros culturais planejados para movimentar nossa cidade durante todo o ano.
                </p>
            </div>

            <!-- Cards de Eventos -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($events as $event): ?>
                    <div class="bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-lg card-hover-lift flex flex-col group">
                        
                        <!-- Imagem do Evento com Badge de Data -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?php echo $event['image']; ?>" alt="<?php echo $event['title']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <!-- Badge de Data no Topo Esquerdo -->
                            <div class="absolute top-4 left-4 bg-amber-500 text-slate-950 font-black rounded-xl p-2.5 text-center shadow-lg border border-amber-300 w-16">
                                <span class="block text-2xl leading-none font-extrabold"><?php echo $event['day']; ?></span>
                                <span class="block text-[10px] tracking-widest uppercase mt-0.5"><?php echo $event['month']; ?></span>
                            </div>

                            <!-- Categoria -->
                            <div class="absolute bottom-3 right-3 bg-slate-900/80 backdrop-blur-md text-slate-200 text-xs px-3 py-1 rounded-full border border-slate-700">
                                <?php echo $event['category']; ?>
                            </div>
                        </div>

                        <!-- Conteúdo -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-slate-900 group-hover:text-amber-600 transition-colors mb-2">
                                    <?php echo $event['title']; ?>
                                </h3>
                                <p class="text-xs text-slate-500 font-medium mb-3 flex items-center gap-1.5">
                                    <i class="fa-solid fa-location-dot text-amber-500"></i>
                                    <span><?php echo $event['location']; ?></span>
                                </p>
                                <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                    <?php echo $event['excerpt']; ?>
                                </p>
                            </div>

                            <a href="#contato" class="inline-flex items-center gap-2 text-xs font-bold text-amber-600 hover:text-amber-700 group/link">
                                <span>Mais Informações com a Secretaria de Turismo</span>
                                <i class="fa-solid fa-arrow-right transition-transform group-hover/link:translate-x-1"></i>
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- SEÇÃO DE ESTATÍSTICAS / NÚMEROS -->
    <section id="estatisticas" class="py-20 bg-slate-900 text-white relative overflow-hidden">
        
        <!-- Fundo com luzes sutis -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-amber-500/20 text-amber-400 border border-amber-500/30 text-xs font-extrabold tracking-wider uppercase mb-3">
                    <i class="fa-solid fa-chart-line"></i> IMPACTO E GRANDEZA
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
                    Canindé de São Francisco em Números
                </h2>
                <p class="text-slate-400 mt-2 text-base">
                    Dados que comprovam a relevância turística, histórica e econômica da nossa cidade.
                </p>
            </div>

            <!-- Grid de Estatísticas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($stats as $stat): ?>
                    <div class="bg-slate-800/80 rounded-2xl p-8 border border-slate-700/80 text-center hover:border-amber-500/50 transition-all hover:bg-slate-800">
                        <div class="text-4xl sm:text-5xl font-black text-amber-400 font-sans tracking-tight mb-2">
                            <?php echo $stat['number']; ?>
                        </div>
                        <div class="text-lg font-bold text-white mb-1">
                            <?php echo $stat['label']; ?>
                        </div>
                        <div class="text-xs text-slate-400">
                            <?php echo $stat['sub']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- RODAPÉ (FOOTER) -->
    <footer id="contato" class="bg-slate-950 text-slate-300 border-t-4 border-amber-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                
                <!-- Coluna 1: Logo & Sobre -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="assets/images/brasao_oficial.png" alt="Brasão Oficial de Canindé de São Francisco" class="h-16 w-auto object-contain drop-shadow-md">
                        <div class="flex flex-col">
                            <span class="text-[10px] tracking-widest text-amber-400 font-bold uppercase">Prefeitura de</span>
                            <span class="text-base font-extrabold text-white">CANINDÉ DE SÃO FRANCISCO</span>
                        </div>
                    </div>
                    
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Secretaria Municipal de Turismo e Cultura.<br>
                        Promovendo o ecoturismo sustentável, a preservação histórica e o acolhimento sertanejo no estado de Sergipe.
                    </p>

                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 text-slate-300 hover:text-slate-950 hover:bg-amber-500 flex items-center justify-center transition" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 text-slate-300 hover:text-slate-950 hover:bg-amber-500 flex items-center justify-center transition" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-900 text-slate-300 hover:text-slate-950 hover:bg-amber-500 flex items-center justify-center transition" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Coluna 2: Acesso Rápido -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider border-b border-slate-800 pb-3 mb-4">Acesso Rápido</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="#inicio" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-500"></i> Início</a></li>
                        <li><a href="#nossa-cidade" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-500"></i> Nossa Cidade</a></li>
                        <li><a href="#turismo" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-500"></i> Cânions do Xingó</a></li>
                        <li><a href="#cordel-cangaco" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-500"></i> Rota do Cangaço</a></li>
                        <li><a href="#eventos" class="hover:text-amber-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-[10px] text-amber-500"></i> Calendário de Eventos</a></li>
                    </ul>
                </div>

                <!-- Coluna 3: Serviços ao Turista -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider border-b border-slate-800 pb-3 mb-4">Serviços ao Turista</h3>
                    <ul class="space-y-2.5 text-xs">
                        <li><button onclick="showQuickInfo('catamaras')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-ship text-[10px] text-amber-500"></i> Passeios de Catamarã</button></li>
                        <li><button onclick="showQuickInfo('guias')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-user-check text-[10px] text-amber-500"></i> Guias de Turismo Credenciados</button></li>
                        <li><button onclick="showQuickInfo('hospedagem')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-hotel text-[10px] text-amber-500"></i> Rede Hoteleira</button></li>
                        <li><button onclick="showQuickInfo('gastronomia')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-utensils text-[10px] text-amber-500"></i> Restaurantes & Bares</button></li>
                        <li><button onclick="showQuickInfo('CAT')" class="hover:text-amber-400 transition text-left flex items-center gap-2"><i class="fa-solid fa-circle-info text-[10px] text-amber-500"></i> Centro de Atendimento ao Turista (CAT)</button></li>
                    </ul>
                </div>

                <!-- Coluna 4: Contatos Oficiais -->
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-wider border-b border-slate-800 pb-3 mb-4">Contatos Oficiais</h3>
                    <ul class="space-y-3 text-xs text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-amber-400 mt-0.5"></i>
                            <span>Praça Ananias Fernandes dos Santos, Centro - Canindé de São Francisco, SE</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-amber-400"></i>
                            <span>(79) 3346-1200 / (79) 99800-4455</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-amber-400"></i>
                            <span>turismo@caninde.se.gov.br</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-clock text-amber-400"></i>
                            <span>Segunda a Sexta: 07:00 às 13:00</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Direitos Autorais -->
            <div class="border-t border-slate-900 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>© <?php echo $currentYear; ?> Prefeitura Municipal de Canindé de São Francisco - Sergipe. Todos os direitos reservados.</p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:text-slate-400">Termos de Uso</a>
                    <span>•</span>
                    <a href="#" class="hover:text-slate-400">Privacidade</a>
                    <span>•</span>
                    <a href="#" class="hover:text-slate-400">Transparência</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- MODAL FALE COM A PREFEITURA -->
    <div id="contact-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative animate-fade-in">
            <button onclick="toggleModal('contact-modal')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-xl" aria-label="Fechar">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-comments"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">Fale com a Prefeitura</h3>
                    <p class="text-xs text-slate-500">Secretaria de Turismo & Atendimento ao Turista</p>
                </div>
            </div>

            <form onsubmit="handleFormSubmit(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Seu Nome Completo</label>
                    <input type="text" required placeholder="Digite seu nome" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">E-mail de Contato</label>
                    <input type="email" required placeholder="seuemail@exemplo.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Assunto</label>
                    <select class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                        <option>Informações sobre Passeios de Catamarã</option>
                        <option>Rota do Cangaço e Guias</option>
                        <option>Hospedagem e Alimentação</option>
                        <option>Eventos Municipais</option>
                        <option>Outros Assuntos</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sua Mensagem</label>
                    <textarea rows="3" required placeholder="Como podemos ajudar em sua viagem a Canindé?" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm resize-none"></textarea>
                </div>

                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold py-3 rounded-xl shadow-lg transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Enviar Mensagem
                </button>
            </form>
        </div>
    </div>

    <!-- MODAL DE VÍDEO -->
    <div id="video-modal" class="fixed inset-0 z-50 hidden bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-4">
        <div class="max-w-4xl w-full bg-slate-900 rounded-2xl overflow-hidden shadow-2xl relative">
            <button onclick="toggleModal('video-modal')" class="absolute top-3 right-4 text-white hover:text-amber-400 text-2xl z-10" aria-label="Fechar vídeo">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="aspect-video w-full">
                <!-- Embedded Video Demo -->
                <iframe class="w-full h-full" src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ" title="Vídeo Institucional Canindé de São Francisco" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- MODAL DE BUSCA -->
    <div id="search-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-start justify-center pt-20 p-4">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl relative">
            <button onclick="toggleModal('search-modal')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass text-amber-500"></i> Buscar no Portal de Turismo
            </h3>

            <input type="text" id="search-input" onkeyup="handleSearch()" placeholder="Digite o que procura (ex: Cânions, Angico, Hotéis...)" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm mb-4">

            <div id="search-results" class="space-y-2 max-h-60 overflow-y-auto text-xs text-slate-600">
                <p class="text-slate-400 italic">Digite algo acima para pesquisar...</p>
            </div>
        </div>
    </div>

    <!-- MODAL DE INFORMAÇÃO RÁPIDA -->
    <div id="quick-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl relative">
            <button onclick="toggleModal('quick-modal')" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div id="quick-modal-content">
                <!-- Conteúdo Injetado via JS -->
            </div>
        </div>
    </div>

    <!-- MODAL CADASTRE SEU RESTAURANTE -->
    <div id="register-restaurant-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative my-8 animate-fade-in max-h-[90vh] overflow-y-auto">
            
            <!-- Botão Fechar -->
            <button onclick="toggleModal('register-restaurant-modal')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-xl w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center transition" aria-label="Fechar modal">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <!-- Cabeçalho do Modal -->
            <div class="flex items-center gap-3 mb-5 border-b border-slate-100 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center text-xl font-bold shadow-md shrink-0">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">Cadastre seu Restaurante</h3>
                    <p class="text-xs text-amber-700 font-semibold">Portal Oficial de Turismo da Prefeitura de Canindé</p>
                </div>
            </div>

            <!-- Nota Informativa Clara no Topo -->
            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl mb-6">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-amber-600 text-base mt-0.5 shrink-0"></i>
                    <p class="text-xs text-amber-950 font-medium leading-relaxed">
                        <strong>Nota importante:</strong> Seu cadastro será enviado para análise da administração da Prefeitura antes de ser exibido no site.
                    </p>
                </div>
            </div>

            <!-- Formulário de Cadastro -->
            <form method="POST" action="index.php" class="space-y-4">
                <input type="hidden" name="user_register_restaurant" value="1">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nome do Estabelecimento *</label>
                    <input type="text" name="name" required placeholder="Ex: Restaurante Sabor do Velho Chico" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Categoria / Tipo de Culinária *</label>
                        <select name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm bg-white">
                            <option value="">Selecione Categoria</option>
                            <option>Peixes & Frutos do Rio</option>
                            <option>Comida Típica Sertaneja</option>
                            <option>Buffet & Self-Service</option>
                            <option>Lanchonete & Petiscaria</option>
                            <option>Pizzaria & Italiana</option>
                            <option>Doces & Sobremesas</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Telefone / WhatsApp *</label>
                        <input type="tel" name="phone" required placeholder="(79) 99999-9999" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Endereço / Localização *</label>
                    <input type="text" name="location" required placeholder="Ex: Av. Beira Rio, nº 120 - Centro, Canindé de São Francisco" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Descrição Curta *</label>
                    <textarea name="description" rows="3" required placeholder="Descreva os pratos principais, horários de funcionamento e atrativos do seu estabelecimento..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm resize-none"></textarea>
                </div>

                <div class="pt-2 flex flex-col sm:flex-row gap-3">
                    <button type="button" onclick="toggleModal('register-restaurant-modal')" class="w-full sm:w-1/3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3 rounded-xl text-xs transition">
                        Cancelar
                    </button>
                    <button type="submit" class="w-full sm:w-2/3 bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold py-3 rounded-xl shadow-lg transition text-xs flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i> Enviar Cadastro para Análise
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- JAVASCRIPT DE INTERATIVIDADE -->
    <script>
        // Toggle de Modais generico
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
            }
        }

        // Toggle do Menu Mobile
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            if (menu) {
                menu.classList.toggle('hidden');
                if (menu.classList.contains('hidden')) {
                    icon.className = "fa-solid fa-bars-staggered text-2xl";
                } else {
                    icon.className = "fa-solid fa-xmark text-2xl";
                }
            }
        }

        // Modal de Informações Rápidas (Gastronomia, Hospedagem, Como Chegar)
        function showQuickInfo(type) {
            const contentDiv = document.getElementById('quick-modal-content');
            let html = '';

            if (type === 'gastronomia') {
                html = `
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-lg"><i class="fa-solid fa-utensils"></i></div>
                        <h3 class="text-lg font-bold text-slate-900">Onde Comer em Canindé</h3>
                    </div>
                    <p class="text-xs text-slate-600 mb-4">Saboreie o melhor da culinária sertaneja: peixe frito do Rio São Francisco (Tucunaré e Surubim), carne de sol com macaxeira e doces típicos.</p>
                    <ul class="text-xs space-y-2 text-slate-700">
                        <li class="p-2 bg-slate-50 rounded border"><strong>Restaurante Karrancas:</strong> Orla do Cânion (Peixes e Buffet variado)</li>
                        <li class="p-2 bg-slate-50 rounded border"><strong>Restaurante Castanho:</strong> Gastronomia com vista para as águas</li>
                        <li class="p-2 bg-slate-50 rounded border"><strong>Sabor do Sertão:</strong> Comida caseira sertaneja no centro</li>
                    </ul>
                `;
            } else if (type === 'hospedagem') {
                html = `
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center text-lg"><i class="fa-solid fa-hotel"></i></div>
                        <h3 class="text-lg font-bold text-slate-900">Onde Ficar em Canindé</h3>
                    </div>
                    <p class="text-xs text-slate-600 mb-4">Acomodações aconchegantes com vista para a caatinga e para o Rio São Francisco.</p>
                    <ul class="text-xs space-y-2 text-slate-700">
                        <li class="p-2 bg-slate-50 rounded border"><strong>Xingó Parque Hotel:</strong> Estrutura completa de lazer com vista panorâmica</li>
                        <li class="p-2 bg-slate-50 rounded border"><strong>Pousada do Velho Chico:</strong> Conforto e localização central</li>
                        <li class="p-2 bg-slate-50 rounded border"><strong>Pousada Cânions do Xingó:</strong> Acesso rápido aos embarcadouros</li>
                    </ul>
                `;
            } else if (type === 'comochegar') {
                html = `
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-lg"><i class="fa-solid fa-route"></i></div>
                        <h3 class="text-lg font-bold text-slate-900">Como Chegar a Canindé</h3>
                    </div>
                    <p class="text-xs text-slate-600 mb-3">Localizada a 213 km de Aracaju (SE) e a 15 km de Piranhas (AL).</p>
                    <div class="text-xs space-y-2 text-slate-700">
                        <p><strong>De Carro/Aracaju:</strong> Siga pela SE-230 passando por Nossa Senhora da Glória até Canindé de São Francisco.</p>
                        <p><strong>De Carro/Maceió:</strong> Siga pela AL-220 via Piranhas e atravesse a ponte sobre o Rio São Francisco.</p>
                        <p><strong>De Ônibus:</strong> Linhas diárias saindo do Terminal Rodoviário de Aracaju.</p>
                    </div>
                `;
            } else if (type === 'catamaras') {
                html = `
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-lg"><i class="fa-solid fa-ship"></i></div>
                        <h3 class="text-lg font-bold text-slate-900">Passeios de Catamarã</h3>
                    </div>
                    <p class="text-xs text-slate-600 mb-3">Navegue com total segurança e conforto pelos Cânions do Xingó.</p>
                    <div class="text-xs space-y-2 text-slate-700">
                        <p><strong>Duração:</strong> Aprox. 3 horas (incluindo parada para banho de rio nas plataformas do Porto de Alagadiço).</p>
                        <p><strong>Saídas:</strong> Diárias a partir do Restaurante Karrancas.</p>
                    </div>
                `;
            } else {
                html = `
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-lg"><i class="fa-solid fa-circle-info"></i></div>
                        <h3 class="text-lg font-bold text-slate-900">Informações Turísticas</h3>
                    </div>
                    <p class="text-xs text-slate-600">O Centro de Atendimento ao Turista (CAT) de Canindé funciona diariamente das 08h às 17h no Centro da Cidade. Telefone: (79) 3346-1200.</p>
                `;
            }

            contentDiv.innerHTML = html;
            toggleModal('quick-modal');
        }

        // Modal de Roteiro do Atrativo
        function openAttractionModal(id) {
            const data = <?php echo json_encode($attractions); ?>;
            const item = data.find(i => i.id === id);
            if (!item) return;

            let html = `
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-500 text-slate-950 flex items-center justify-center text-lg font-bold"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">${item.title}</h3>
                        <span class="text-xs font-semibold text-amber-700">${item.subtitle}</span>
                    </div>
                </div>
                <img src="${item.image}" class="w-full h-48 object-cover rounded-xl mb-4 border border-slate-200 shadow-sm">
                <p class="text-xs text-slate-600 leading-relaxed mb-4">${item.description}</p>
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-2">O que você vai vivenciar:</h4>
                <ul class="text-xs text-slate-700 space-y-1.5 mb-4">
                    ${item.highlights.map(h => `<li class="flex items-center gap-2"><i class="fa-solid fa-check text-amber-500"></i> ${h}</li>`).join('')}
                </ul>
                <div class="border-t pt-3 flex justify-end">
                    <button onclick="toggleModal('contact-modal'); toggleModal('quick-modal');" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-4 py-2 rounded-xl text-xs">
                        Agendar / Tirar Dúvidas
                    </button>
                </div>
            `;
            document.getElementById('quick-modal-content').innerHTML = html;
            toggleModal('quick-modal');
        }

        // Lógica de Busca Simples
        function handleSearch() {
            const query = document.getElementById('search-input').value.toLowerCase().trim();
            const resultsDiv = document.getElementById('search-results');
            if (!query) {
                resultsDiv.innerHTML = '<p class="text-slate-400 italic">Digite algo acima para pesquisar...</p>';
                return;
            }

            const items = [
                { name: 'Cânions do Xingó', link: '#turismo', desc: 'Navegação em catamarã e banho de rio' },
                { name: 'Rota do Cangaço e Grota do Angico', link: '#cordel-cangaco', desc: 'Trilha onde Lampião viveu a última batalha' },
                { name: 'Usina Hidrelétrica de Xingó', link: '#turismo', desc: 'Visita técnica ao complexo de engenharia' },
                { name: 'Mirante da Seabra', link: '#turismo', desc: 'Pôr do sol panorâmico no Rio São Francisco' },
                { name: 'Festa de Nossa Senhora da Conceição', link: '#eventos', desc: 'Festa da padroeira em Agosto' },
                { name: 'Festival Cordel & Cangaço', link: '#eventos', desc: 'Poesia, viola e repentistas em Setembro' },
                { name: 'Restaurantes e Culinária', link: 'javascript:showQuickInfo("gastronomia")', desc: 'Peixes do Velho Chico e carne de sol' },
                { name: 'Hotéis e Pousadas', link: 'javascript:showQuickInfo("hospedagem")', desc: 'Onde se hospedar em Canindé' }
            ];

            const filtered = items.filter(i => i.name.toLowerCase().includes(query) || i.desc.toLowerCase().includes(query));

            if (filtered.length === 0) {
                resultsDiv.innerHTML = '<p class="text-slate-500">Nenhum resultado encontrado para "' + query + '".</p>';
            } else {
                resultsDiv.innerHTML = filtered.map(i => `
                    <a href="${i.link}" onclick="toggleModal('search-modal')" class="block p-2.5 hover:bg-slate-50 rounded-xl transition border border-transparent hover:border-slate-200">
                        <div class="font-bold text-slate-900">${i.name}</div>
                        <div class="text-slate-500 text-[11px]">${i.desc}</div>
                    </a>
                `).join('');
            }
        }

        // Submissão do formulário de contato
        function handleFormSubmit(e) {
            e.preventDefault();
            alert('Mensagem enviada com sucesso! A Prefeitura de Canindé de São Francisco responderá em breve.');
            toggleModal('contact-modal');
        }

        // Submissão do cadastro de restaurante
        function handleRestaurantSubmit(e) {
            e.preventDefault();
            alert('Cadastro enviado com sucesso! Seu cadastro será enviado para análise da administração da Prefeitura antes de ser exibido no site.');
            toggleModal('register-restaurant-modal');
            e.target.reset();
        }

        // Rolagem do Carrossel de Restaurantes (Suave ~500ms)
        function scrollRestaurants(direction) {
            const container = document.getElementById('restaurant-carousel');
            if (!container || !container.firstElementChild) return;
            
            // Largura do item + gap de 24px (1.5rem)
            const itemWidth = container.firstElementChild.clientWidth + 24;
            
            if (direction === 'left') {
                container.scrollBy({ left: -itemWidth, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: itemWidth, behavior: 'smooth' });
            }
        }
    </script>

</body>
</html>
