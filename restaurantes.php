<?php
header('Content-Type: text/html; charset=utf-8');
// CONEXÃO CÂNIONS - Conectando você ao melhor do Velho Chico
// Guia Gastronômico Regional (Canindé de São Francisco & Piranhas)
$currentYear = date('Y');

// Dados dinâmicos e fallback
$dataFile = __DIR__ . '/data/restaurants.json';
$allRestaurants = [
    [
        'id' => 1,
        'name' => 'Restaurante Karrancas',
        'cidade' => 'Canindé de São Francisco',
        'category' => 'Peixes & Frutos do Rio',
        'category_slug' => 'peixes',
        'specialty' => 'Tucunaré Frito & Surubim ao Molho de Camarão',
        'description' => 'Localizado na orla do embarcadouro dos Cânions do Xingó, oferecendo amplo buffet e pratos à la carte com peixes frescos do Rio São Francisco.',
        'location' => 'Orla do Cânion do Xingó - Canindé de São Francisco',
        'phone' => '(79) 99844-3311',
        'hours' => 'Seg a Dom: 08:00 às 17:30',
        'tag' => 'Orla do Cânion',
        'image' => 'assets/images/canions_xingo.jpg'
    ],
    [
        'id' => 2,
        'name' => 'Restaurante O Castanho',
        'cidade' => 'Canindé de São Francisco',
        'category' => 'Comida Sertaneja',
        'category_slug' => 'sertaneja',
        'specialty' => 'Carne de Sol com Macaxeira & Peixe Grelhado',
        'description' => 'Experiência gastronômica única integrada à reserva ecológica com vista privilegiada para o braço de rio dos Cânions.',
        'location' => 'Reserva Ecológica do Castanho - Sertão',
        'phone' => '(79) 99912-8844',
        'hours' => 'Diariamente: 09:00 às 16:30',
        'tag' => 'Vista Panorâmica',
        'image' => 'assets/images/rota_cangaco.jpg'
    ],
    [
        'id' => 3,
        'name' => 'Sabor do Sertão',
        'cidade' => 'Canindé de São Francisco',
        'category' => 'Comida Caseira',
        'category_slug' => 'sertaneja',
        'specialty' => 'Galinha Caipira com Pirão & Doces Típicos',
        'description' => 'Acolhedor restaurante no centro da cidade com o autêntico tempero sertanejo, pirão reforçado e doces de leite de produção local.',
        'location' => 'Rua do Comércio, nº 45 - Centro',
        'phone' => '(79) 98822-7700',
        'hours' => 'Seg a Sáb: 11:00 às 15:00',
        'tag' => 'Centro Histórico',
        'image' => 'assets/images/cordel_art.jpg'
    ],
    [
        'id' => 4,
        'name' => 'Restaurante Bode Assado do Sertão',
        'cidade' => 'Canindé de São Francisco',
        'category' => 'Comida Típica / Churrasco',
        'category_slug' => 'churrasco',
        'specialty' => 'Bode Assado na Brasa & Pirão de Queijo',
        'description' => 'Especializado em cortes de bode e carneiro assados na brasa com temperos tradicionais, acompanhados de pirão de queijo coalho e feijão de corda.',
        'location' => 'Av. Principal, nº 310 - Canindé de São Francisco',
        'phone' => '(79) 99811-2233',
        'hours' => 'Ter a Dom: 11:30 às 22:00',
        'tag' => 'Tradição Sertaneja',
        'image' => 'assets/images/bode_assado.jpg'
    ],
    [
        'id' => 5,
        'name' => 'Restaurante & Bar da Orla',
        'cidade' => 'Canindé de São Francisco',
        'category' => 'Petiscaria & Frutos do Rio',
        'category_slug' => 'peixes',
        'specialty' => 'Caldinho de Peixe & Caipirinhas da Caatinga',
        'description' => 'Petiscaria à beira do Velho Chico com frutos do rio frescos, ambiente descontraído e música ao vivo aos finais de semana.',
        'location' => 'Orla Fluvial - Canindé de São Francisco',
        'phone' => '(79) 99888-5544',
        'hours' => 'Qua a Dom: 10:00 às 23:00',
        'tag' => 'Beira-Rio',
        'image' => 'assets/images/hero_canyons.jpg'
    ],
    [
        'id' => 6,
        'name' => 'Mirante Xingó Gastrobar',
        'cidade' => 'Piranhas',
        'category' => 'Culinária Variada',
        'category_slug' => 'variada',
        'specialty' => 'Filé de Tilápia Grelhado & Drinks Tropicais',
        'description' => 'Gastrobar com vista espetacular para os Cânions e a histórica cidade de Piranhas. Coquetelaria autoral e petiscos gurmê.',
        'location' => 'Mirante Histórico - Piranhas (AL)',
        'phone' => '(82) 99777-3322',
        'hours' => 'Qui a Dom: 16:00 às 00:00',
        'tag' => 'Pôr do Sol em Piranhas',
        'image' => 'assets/images/mirante_seabra.jpg'
    ],
    [
        'id' => 7,
        'name' => 'Pizzaria & Forno a Lenha Sertão',
        'cidade' => 'Piranhas',
        'category' => 'Pizzaria & Italiana',
        'category_slug' => 'variada',
        'specialty' => 'Pizzas Artesanais com Queijo Coalho & Carne de Sol',
        'description' => 'Pizzas assadas em forno a lenha com ingredientes típicos da caatinga e massas de fermentação natural no Centro Histórico de Piranhas.',
        'location' => 'Centro Histórico - Piranhas (AL)',
        'phone' => '(82) 99666-4411',
        'hours' => 'Seg a Dom: 18:00 às 23:30',
        'tag' => 'Forno a Lenha',
        'image' => 'assets/images/cordel_art.jpg'
    ],
    [
        'id' => 8,
        'name' => 'Doceria & Cafezal do Velho Chico',
        'cidade' => 'Piranhas',
        'category' => 'Doces & Cafés',
        'category_slug' => 'variada',
        'specialty' => 'Cartola Sertaneja, Doce de Leite & Café Raiz',
        'description' => 'Cafetaria aconchegante com doces tradicionais, cartola com queijo coalho grelhado e cafés especiais selecionados.',
        'location' => 'Orla de Piranhas (AL)',
        'phone' => '(82) 99555-8822',
        'hours' => 'Ter a Dom: 14:00 às 21:00',
        'tag' => 'Doces Caseiros',
        'image' => 'assets/images/rota_cangaco.jpg'
    ]
];

// Conexão MySQL e Busca de Restaurantes Aprovados
require_once __DIR__ . '/conexao.php';

try {
    $stmt = $pdo->query("SELECT *, nome AS name, prato_destaque AS specialty, endereco AS location, telefone AS phone, categoria AS category FROM restaurantes WHERE status = 'aprovado' ORDER BY id DESC");
    $dbList = $stmt->fetchAll();
    if (!empty($dbList)) {
        foreach ($dbList as &$r) {
            if (empty($r['cidade'])) $r['cidade'] = 'Canindé de São Francisco';
            if (empty($r['image'])) $r['image'] = 'assets/images/canions_xingo.jpg';
            if (empty($r['hours'])) $r['hours'] = 'Seg a Dom: 10:00 às 22:00';
            if (empty($r['tag'])) $r['tag'] = 'Verificado';
            if (!isset($r['description']) || empty($r['description'])) {
                $r['description'] = $r['specialty'] ?? 'Especialidade gastronômica local na Região dos Cânions do São Francisco.';
            }
            if (empty($r['category_slug'])) {
                $cat = strtolower($r['category']);
                if (strpos($cat, 'peix') !== false) $r['category_slug'] = 'peixes';
                elseif (strpos($cat, 'sert') !== false || strpos($cat, 'caseir') !== false) $r['category_slug'] = 'sertaneja';
                elseif (strpos($cat, 'churrasc') !== false || strpos($cat, 'bode') !== false) $r['category_slug'] = 'churrasco';
                else $r['category_slug'] = 'variada';
            }
        }
        $allRestaurants = $dbList;
    }
} catch (PDOException $e) {
    // Mantém fallback
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons Conexão Cânions -->
    <link rel="icon" type="image/x-icon" href="/turismo-caninde/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/turismo-caninde/assets/images/favicon-16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/turismo-caninde/assets/images/favicon-32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/turismo-caninde/assets/images/favicon-192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/turismo-caninde/assets/images/apple-touch-icon.png">
    <meta name="theme-color" content="#EA580C">
    <title>Guia Gastronômico | CONEXÃO CÂNIONS - Canindé & Piranhas</title>
    <meta name="description" content="Onde comer nos Cânions do São Francisco. Guia completo de restaurantes em Canindé de São Francisco (SE) e Piranhas (AL).">
    
    <!-- Google Fonts (Playfair Display & Cinzel para Neocordel + Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Eczar:wght@600;800&family=Playfair+Display:ital,wght@0,600;0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Alpine.js via CDN (Reatividade Frontend Instantânea) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sertao: {
                            bg: '#0F172A',
                            dark: '#090D16',
                            card: '#18181B',
                            terracotta: '#EA580C',
                            amber: '#D97706',
                            gold: '#F59E0B',
                            blue: '#0284C7',
                            lightBlue: '#38BDF8',
                            green: '#10B981'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                        cinzel: ['Cinzel', 'serif'],
                        cordel: ['Eczar', 'serif']
                    }
                }
            }
        }
    </script>

    <style>
        .woodcut-border {
            border: 2px solid #EA580C;
            box-shadow: 4px 4px 0px #090D16;
        }
        .woodcut-card {
            background: linear-gradient(145deg, #18181B 0%, #0F172A 100%);
            border: 1px solid rgba(234, 88, 12, 0.25);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .woodcut-card:hover {
            transform: translateY(-6px) scale(1.01);
            border-color: rgba(245, 158, 11, 0.6);
            box-shadow: 0 20px 30px -10px rgba(234, 88, 12, 0.25);
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(16px);
        }
        .gradient-text-sertao {
            background: linear-gradient(135deg, #F59E0B 0%, #EA580C 50%, #D97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-sertao-bg text-slate-100 font-sans antialiased min-h-screen flex flex-col" x-data="{ selectedCity: 'all', selectedCategory: 'all', searchQuery: '' }">
    <?php include_once __DIR__ . '/includes/loader.php'; ?>

    <!-- TOP BAR REGIONAL -->
    <div class="bg-sertao-dark text-slate-400 text-xs py-2.5 px-4 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-compass text-amber-500"></i> <strong class="text-slate-200">Conexão Cânions:</strong> Canindé de São Francisco (SE) & Piranhas (AL)</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="index.php" class="text-amber-400 hover:text-amber-300 font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Voltar ao Portal Principal
                </a>
            </div>
        </div>
    </div>

    <!-- CABEÇALHO (NAVBAR) NEOCORDEL PREMIUM -->
    <header class="sticky top-0 z-50 glass-nav border-b border-amber-900/30 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo da Marca CONEXÃO CÂNIONS -->
                <a href="index.php" class="flex items-center gap-3 group shrink-0">
                    <img src="assets/images/logo_icon.png" alt="Conexão Cânions" class="w-11 h-11 sm:w-12 sm:h-12 object-contain group-hover:scale-105 transition-transform shrink-0 drop-shadow-md">
                    <div class="flex flex-col">
                        <span class="text-lg sm:text-xl font-black font-cinzel tracking-wider text-white group-hover:text-amber-400 transition-colors leading-none">
                            CONEXÃO <span class="text-amber-500">CÂNIONS</span>
                        </span>
                        <span class="text-[10px] sm:text-[11px] text-amber-400/90 font-medium tracking-normal mt-1 whitespace-nowrap">
                            Conectando você ao melhor do Velho Chico
                        </span>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden lg:flex items-center gap-5 xl:gap-7 whitespace-nowrap">
                    <a href="index.php" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Início</a>
                    <a href="index.php#nossa-cidade" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Região</a>
                    <a href="index.php#turismo" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Atrativos</a>
                    <a href="restaurantes.php" class="text-sm font-bold text-amber-400 relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-amber-400 whitespace-nowrap">Guia Gastronômico</a>
                    <a href="index.php#eventos" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Eventos</a>
                </nav>

                <!-- Action Button -->
                <div class="flex items-center gap-3 shrink-0">
                    <button onclick="toggleModal('register-restaurant-modal')" class="bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-slate-950 font-black px-4 py-2.5 rounded-xl shadow-lg shadow-amber-500/20 transition text-xs flex items-center gap-2 border border-amber-400/30 uppercase tracking-wider whitespace-nowrap">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span>Cadastrar Restaurante</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO / SEÇÃO DE APRESENTAÇÃO DO GUIA GASTRONÔMICO -->
    <section class="relative py-16 bg-gradient-to-b from-sertao-dark via-sertao-bg to-sertao-bg border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Breadcrumbs e Botão Voltar -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                <nav class="flex items-center gap-2 text-xs text-amber-400 font-semibold">
                    <a href="index.php" class="hover:underline flex items-center gap-1"><i class="fa-solid fa-house"></i> Início</a>
                    <span>/</span>
                    <span class="text-slate-300">Sabores do Velho Chico</span>
                </nav>

                <a href="index.php" class="inline-flex items-center gap-2 text-xs font-bold text-amber-400 hover:text-amber-300 bg-slate-900/90 hover:bg-slate-800 px-4 py-2 rounded-xl border border-slate-700/80 shadow-md transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Voltar para o Conexão Cânions</span>
                </a>
            </div>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-3xl">
                    <span class="text-xs uppercase font-extrabold tracking-widest text-amber-400 bg-amber-500/10 px-3 py-1 rounded-lg border border-amber-500/20">
                        <i class="fa-solid fa-utensils mr-1.5"></i> Culinária Sertaneja & Frutos do Rio
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-black font-cinzel tracking-tight text-white mt-3 leading-tight">
                        Sabores dos <span class="gradient-text-sertao">Cânions do São Francisco</span>
                    </h1>
                    <p class="text-slate-300 text-base sm:text-lg mt-3 font-light leading-relaxed">
                        Explore os melhores restaurantes, peixarias, petiscarias beira-rio e casas de comida típica em <strong class="text-amber-400 font-semibold">Canindé de São Francisco (SE)</strong> e <strong class="text-amber-400 font-semibold">Piranhas (AL)</strong>.
                    </p>
                </div>

                <div class="bg-sertao-card/90 border border-amber-500/30 p-5 rounded-2xl shrink-0 text-center sm:text-left shadow-xl backdrop-blur-md">
                    <span class="block text-3xl font-black font-cinzel text-amber-400"><?php echo count($allRestaurants); ?> Opções</span>
                    <span class="text-xs text-slate-400 font-medium">Cadastradas no Conexão Cânions</span>
                </div>
            </div>

        </div>
    </section>

    <!-- ÁREA INTERATIVA DE FILTROS & BUSCA EM TEMPO REAL (ALPINE.JS) -->
    <section class="py-8 bg-slate-900/90 sticky top-20 z-40 border-y border-slate-800/80 backdrop-blur-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            
            <!-- 1. Filtros Rápidos de Cidade (Canindé x Piranhas) -->
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mr-1 hidden sm:inline">
                        <i class="fa-solid fa-location-dot text-amber-500"></i> Cidade:
                    </span>
                    <button @click="selectedCity = 'all'" :class="selectedCity === 'all' ? 'bg-amber-500 text-slate-950 font-black shadow-lg shadow-amber-500/20' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold'" class="px-4 py-2 rounded-xl text-xs transition uppercase tracking-wider border border-amber-500/30">
                        Todas as Cidades
                    </button>
                    <button @click="selectedCity = 'Canindé de São Francisco'" :class="selectedCity === 'Canindé de São Francisco' ? 'bg-amber-500 text-slate-950 font-black shadow-lg shadow-amber-500/20' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold'" class="px-4 py-2 rounded-xl text-xs transition uppercase tracking-wider border border-amber-500/30">
                        Canindé de São Francisco (SE)
                    </button>
                    <button @click="selectedCity = 'Piranhas'" :class="selectedCity === 'Piranhas' ? 'bg-amber-500 text-slate-950 font-black shadow-lg shadow-amber-500/20' : 'bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold'" class="px-4 py-2 rounded-xl text-xs transition uppercase tracking-wider border border-amber-500/30">
                        Piranhas (AL)
                    </button>
                </div>

                <!-- Campo de Busca instantânea em Tempo Real -->
                <div class="relative w-full md:w-72">
                    <input type="text" x-model="searchQuery" placeholder="Buscar por prato, restaurante..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 focus:outline-none text-xs text-white placeholder-slate-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-amber-500 text-xs"></i>
                </div>
            </div>

            <!-- 2. Filtros de Categoria -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar text-xs">
                <span class="text-slate-400 font-bold uppercase tracking-wider shrink-0 mr-1 hidden sm:inline">Culinária:</span>
                <button @click="selectedCategory = 'all'" :class="selectedCategory === 'all' ? 'bg-amber-500/20 text-amber-400 border-amber-500/50 font-bold' : 'bg-slate-800/60 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3.5 py-1.5 rounded-lg border transition shrink-0">
                    Todas
                </button>
                <button @click="selectedCategory = 'peixes'" :class="selectedCategory === 'peixes' ? 'bg-amber-500/20 text-amber-400 border-amber-500/50 font-bold' : 'bg-slate-800/60 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3.5 py-1.5 rounded-lg border transition shrink-0">
                    <i class="fa-solid fa-fish mr-1"></i> Peixes & Frutos do Rio
                </button>
                <button @click="selectedCategory = 'sertaneja'" :class="selectedCategory === 'sertaneja' ? 'bg-amber-500/20 text-amber-400 border-amber-500/50 font-bold' : 'bg-slate-800/60 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3.5 py-1.5 rounded-lg border transition shrink-0">
                    <i class="fa-solid fa-pepper-hot mr-1"></i> Comida Sertaneja
                </button>
                <button @click="selectedCategory = 'churrasco'" :class="selectedCategory === 'churrasco' ? 'bg-amber-500/20 text-amber-400 border-amber-500/50 font-bold' : 'bg-slate-800/60 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3.5 py-1.5 rounded-lg border transition shrink-0">
                    <i class="fa-solid fa-drumstick-bite mr-1"></i> Bode Assado & Churrasco
                </button>
                <button @click="selectedCategory = 'variada'" :class="selectedCategory === 'variada' ? 'bg-amber-500/20 text-amber-400 border-amber-500/50 font-bold' : 'bg-slate-800/60 text-slate-400 border-slate-800 hover:text-slate-200'" class="px-3.5 py-1.5 rounded-lg border transition shrink-0">
                    <i class="fa-solid fa-pizza-slice mr-1"></i> Pizzas & Lanches
                </button>
            </div>

        </div>
    </section>

    <!-- GRID REATIVO DE RESTAURANTES (ALPINE.JS STATE) -->
    <section class="py-12 flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($allRestaurants as $item): 
                    $phoneClean = preg_replace('/\D/', '', $item['phone']);
                    $waText = urlencode("Olá! Encontrei o " . $item['name'] . " no portal Conexão Cânions e gostaria de consultar informações.");
                    $waUrl = "https://wa.me/55{$phoneClean}?text={$waText}";
                    $cidadeName = $item['cidade'] ?? 'Canindé de São Francisco';
                    $catSlug = $item['category_slug'] ?? 'variada';
                ?>
                    <div 
                        x-data="{ 
                            cidade: '<?php echo addslashes($cidadeName); ?>', 
                            category: '<?php echo $catSlug; ?>', 
                            name: '<?php echo addslashes(strtolower($item['name'])); ?>', 
                            specialty: '<?php echo addslashes(strtolower($item['specialty'])); ?>',
                            location: '<?php echo addslashes(strtolower($item['location'])); ?>'
                        }"
                        x-show="(selectedCity === 'all' || cidade === selectedCity) && (selectedCategory === 'all' || category === selectedCategory) && (searchQuery === '' || name.includes(searchQuery.toLowerCase()) || specialty.includes(searchQuery.toLowerCase()) || location.includes(searchQuery.toLowerCase()))"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        onclick="window.location.href='restaurante.php?id=<?php echo $item['id']; ?>'" 
                        class="woodcut-card rounded-2xl overflow-hidden cursor-pointer flex flex-col group"
                    >
                        <!-- Imagem com Badges de Categoria e Cidade -->
                        <div class="relative h-56 overflow-hidden">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-sertao-card via-transparent to-transparent opacity-80"></div>
                            
                            <!-- Badge de Categoria -->
                            <div class="absolute top-4 left-4 bg-amber-500 text-slate-950 font-black text-[11px] px-3 py-1.5 rounded-lg shadow-md uppercase tracking-wider">
                                <?php echo htmlspecialchars($item['category']); ?>
                            </div>

                            <!-- Badge Visível de Cidade (Canindé / Piranhas) -->
                            <div class="absolute top-4 right-4 bg-slate-950/90 text-amber-300 font-bold text-[10px] px-2.5 py-1 rounded-lg border border-amber-500/40 backdrop-blur-md flex items-center gap-1 shadow-lg">
                                <i class="fa-solid fa-location-dot text-amber-400"></i>
                                <span><?php echo htmlspecialchars($cidadeName); ?></span>
                            </div>
                        </div>

                        <!-- Conteúdo do Card -->
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-xl font-bold font-serif text-white group-hover:text-amber-400 transition-colors">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </h3>
                                    <span class="bg-amber-500/10 text-amber-400 text-[10px] font-bold px-2 py-0.5 rounded border border-amber-500/20">
                                        <?php echo htmlspecialchars($item['tag']); ?>
                                    </span>
                                </div>

                                <p class="text-xs font-bold text-amber-400/90 mb-3 flex items-center gap-1.5">
                                    <i class="fa-solid fa-utensils text-amber-500"></i> <?php echo htmlspecialchars($item['specialty']); ?>
                                </p>

                                <p class="text-xs text-slate-400 leading-relaxed line-clamp-2">
                                    <?php echo htmlspecialchars($item['description']); ?>
                                </p>
                            </div>

                            <div class="border-t border-slate-800 pt-4 space-y-2">
                                <p class="text-xs text-slate-400 flex items-start gap-2">
                                    <i class="fa-solid fa-location-dot text-amber-500 mt-0.5 shrink-0"></i>
                                    <span><?php echo htmlspecialchars($item['location']); ?></span>
                                </p>

                                <p class="text-xs text-slate-400 flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-amber-500 shrink-0"></i>
                                    <span><?php echo htmlspecialchars($item['hours']); ?></span>
                                </p>

                                <!-- Botões de Ação de 1 Clique -->
                                <div class="pt-3 flex items-center gap-2 border-t border-slate-800/80 mt-3">
                                    <a href="restaurante.php?id=<?php echo $item['id']; ?>" class="flex-1 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-slate-950 font-black py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 transition shadow-md uppercase tracking-wider">
                                        <i class="fa-solid fa-circle-info text-xs"></i> Ver Detalhes
                                    </a>
                                    <a href="<?php echo $waUrl; ?>" target="_blank" onclick="event.stopPropagation()" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-1.5 transition shadow-md border border-emerald-400/30">
                                        <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Banner do Cadastre Seu Restaurante -->
            <div class="woodcut-border mt-16 p-8 bg-slate-900 rounded-3xl shadow-2xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-slate-950 flex items-center justify-center text-2xl shrink-0 shadow-lg border border-amber-400/40">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div>
                        <h3 class="font-bold font-cinzel text-white text-xl">Seu estabelecimento ainda não está no Conexão Cânions?</h3>
                        <p class="text-xs text-slate-400 mt-1 max-w-xl">
                            Divulgue seu restaurante, petiscaria ou lanchonete em Canindé de São Francisco ou Piranhas para milhares de turistas.
                        </p>
                    </div>
                </div>

                <button onclick="toggleModal('register-restaurant-modal')" class="w-full md:w-auto bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-slate-950 font-black px-8 py-4 rounded-xl shadow-xl transition shrink-0 flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    <i class="fa-solid fa-plus-circle"></i> Cadastrar Meu Restaurante
                </button>
            </div>

            <!-- Botão Voltar ao Portal Principal -->
            <div class="mt-12 text-center">
                <a href="index.php" class="inline-flex items-center gap-2.5 text-amber-400 hover:text-amber-300 font-bold text-sm bg-slate-900/90 hover:bg-slate-800 px-6 py-3.5 rounded-2xl shadow-xl border border-slate-700/80 transition-all">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Voltar para o Conexão Cânions</span>
                </a>
            </div>

        </div>
    </section>

    <!-- RODAPÉ DA MARCA -->
    <footer class="bg-sertao-dark text-slate-400 border-t border-slate-800 py-12 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <img src="assets/images/logo_icon.png" alt="Conexão Cânions" class="w-10 h-10 object-contain shrink-0 drop-shadow-md">
                <div>
                    <span class="font-black font-cinzel text-white text-sm tracking-wide block">CONEXÃO <span class="text-amber-500">CÂNIONS</span></span>
                    <span class="text-slate-500">Conectando você ao melhor do Velho Chico • Canindé & Piranhas</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="index.php" class="hover:text-amber-400 transition">Portal Principal</a>
                <span>•</span>
                <a href="restaurantes.php" class="hover:text-amber-400 transition">Guia Gastronômico</a>
                <span>•</span>
                <a href="index.php#contato" class="hover:text-amber-400 transition">Contato</a>
            </div>
        </div>
    </footer>

    <!-- MODAL CADASTRE SEU RESTAURANTE -->
    <div id="register-restaurant-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-sertao-card rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-amber-500/30 relative my-8 text-slate-100 max-h-[90vh] overflow-y-auto">
            <button onclick="toggleModal('register-restaurant-modal')" class="absolute top-5 right-5 text-slate-400 hover:text-white text-xl w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="flex items-center gap-3 mb-5 border-b border-slate-800 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center text-xl font-bold shadow-md shrink-0">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div>
                    <h3 class="text-xl sm:text-2xl font-black font-cinzel text-white">Cadastrar Restaurante</h3>
                    <p class="text-xs text-amber-400 font-semibold">Conexão Cânions (Canindé de São Francisco & Piranhas)</p>
                </div>
            </div>

            <form onsubmit="handleRestaurantSubmit(event)" class="space-y-4 text-xs">
                <div>
                    <label class="block font-bold text-slate-300 mb-1">Nome do Estabelecimento *</label>
                    <input type="text" required placeholder="Ex: Restaurante Sabor do Velho Chico" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white focus:border-amber-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Cidade *</label>
                        <select required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white focus:border-amber-500 focus:outline-none">
                            <option value="Canindé de São Francisco">Canindé de São Francisco (SE)</option>
                            <option value="Piranhas">Piranhas (AL)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Categoria *</label>
                        <select required class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white focus:border-amber-500 focus:outline-none">
                            <option value="">Selecione Categoria</option>
                            <option>Peixes & Frutos do Rio</option>
                            <option>Comida Típica Sertaneja</option>
                            <option>Buffet & Self-Service</option>
                            <option>Lanchonete & Petiscaria</option>
                            <option>Pizzaria & Italiana</option>
                            <option>Doces & Sobremesas</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Telefone / WhatsApp *</label>
                        <input type="tel" required placeholder="(79) 99999-9999" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white focus:border-amber-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-300 mb-1">Prato Destaque *</label>
                        <input type="text" required placeholder="Ex: Tucunaré Frito com Pirão" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white focus:border-amber-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-300 mb-1">Endereço Completo *</label>
                    <input type="text" required placeholder="Ex: Orla Fluvial, nº 120 - Centro" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white focus:border-amber-500 focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-slate-300 mb-1">Descrição Curta *</label>
                    <textarea rows="3" required placeholder="Descreva os pratos principais, horários de funcionamento e atrativos do estabelecimento..." class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-white focus:border-amber-500 focus:outline-none resize-none"></textarea>
                </div>

                <div class="pt-2 flex flex-col sm:flex-row gap-3">
                    <button type="button" onclick="toggleModal('register-restaurant-modal')" class="w-full sm:w-1/3 bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold py-3 rounded-xl transition">
                        Cancelar
                    </button>
                    <button type="submit" class="w-full sm:w-2/3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-slate-950 font-black py-3 rounded-xl shadow-lg transition flex items-center justify-center gap-2 uppercase tracking-wider">
                        <i class="fa-solid fa-paper-plane"></i> Enviar Cadastro
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT DE MODAL E MANIPULAÇÃO -->
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.toggle('hidden');
        }

        function handleRestaurantSubmit(e) {
            e.preventDefault();
            alert('Cadastro enviado com sucesso! Seu cadastro passará por análise antes de ser exibido no Conexão Cânions.');
            toggleModal('register-restaurant-modal');
            e.target.reset();
        }
    </script>
</body>
</html>
