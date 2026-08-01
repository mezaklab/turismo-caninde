<?php
header('Content-Type: text/html; charset=utf-8');

// 1. Validar ID recebido via GET
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if (!$id || $id <= 0) {
    header('Location: restaurantes.php');
    exit;
}

require_once __DIR__ . '/conexao.php';

$restaurante = null;

// 2. Buscar no MySQL na tabela 'restaurantes' pelo ID fornecido
try {
    $stmt = $pdo->prepare("SELECT * FROM restaurantes WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $restaurante = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $restaurante = null;
}

// Fallback: se a tabela MySQL estiver em modo alternativo ou registro no arquivo JSON
if (!$restaurante) {
    $jsonPath = __DIR__ . '/data/restaurants.json';
    if (file_exists($jsonPath)) {
        $jsonContent = file_get_contents($jsonPath);
        $jsonRestaurants = json_decode($jsonContent, true) ?? [];
        foreach ($jsonRestaurants as $r) {
            if (isset($r['id']) && (int)$r['id'] === $id) {
                $restaurante = $r;
                break;
            }
        }
    }
}

// Se não existir ou não estiver aprovado, redirecionar para restaurantes.php
if (!$restaurante || (isset($restaurante['status']) && strtolower($restaurante['status']) !== 'aprovado')) {
    header('Location: restaurantes.php');
    exit;
}

// Normalização dos dados para exibição
$nome = htmlspecialchars($restaurante['nome'] ?? $restaurante['name'] ?? 'Restaurante Sem Nome');
$categoria = htmlspecialchars($restaurante['categoria'] ?? $restaurante['category'] ?? 'Gastronomia Local');
$pratoDestaque = htmlspecialchars($restaurante['prato_destaque'] ?? $restaurante['specialty'] ?? 'Prato Especial da Casa');
$endereco = htmlspecialchars($restaurante['endereco'] ?? $restaurante['location'] ?? 'Canindé de São Francisco - SE');
$telefone = htmlspecialchars($restaurante['telefone'] ?? $restaurante['phone'] ?? '(79) 99844-3311');
$imagem = !empty($restaurante['imagem']) ? $restaurante['imagem'] : (!empty($restaurante['image']) ? $restaurante['image'] : 'assets/images/canions_xingo.jpg');
$tag = htmlspecialchars($restaurante['tag'] ?? 'Verificado');
$cidade = htmlspecialchars($restaurante['cidade'] ?? 'Canindé de São Francisco');
$horario = htmlspecialchars($restaurante['horario_funcionamento'] ?? $restaurante['hours'] ?? 'Segunda a Domingo: 10:00 às 22:00');

$descricao = htmlspecialchars(
    $restaurante['descricao'] ?? 
    $restaurante['description'] ?? 
    'Localizado em ' . $cidade . ', o ' . $nome . ' oferece uma autêntica imersão nos sabores sertanejos e na gastronomia do Velho Chico. Com atendimento acolhedor e ingredientes locais selecionados, é parada obrigatória para turistas e moradores.'
);

// Formatação do link direto do WhatsApp com mensagem personalizada
$phoneClean = preg_replace('/\D/', '', $telefone);
if (empty($phoneClean)) {
    $phoneClean = '79998443311';
}
$waMessage = urlencode("Olá! Encontrei o " . $nome . " (" . $cidade . ") no portal Conexão Cânions e gostaria de consultar informações e cardápio.");
$whatsappUrl = "https://wa.me/55" . $phoneClean . "?text=" . $waMessage;

// Link para Rota de 1 clique no Google Maps
$mapsUrl = "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($nome . " " . $endereco . " " . $cidade);

// Redes sociais simuladas/dinâmicas
$instagramUser = !empty($restaurante['instagram']) ? $restaurante['instagram'] : '@' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $nome));
$instagramUrl = "https://instagram.com/" . ltrim($instagramUser, '@');

$currentYear = date('Y');
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
    <title><?php echo $nome; ?> (<?php echo $cidade; ?>) | CONEXÃO CÂNIONS</title>
    <meta name="description" content="Saiba mais sobre <?php echo $nome; ?> em <?php echo $cidade; ?>. Confira prato destaque, endereço, horário e WhatsApp no Conexão Cânions.">
    
    <!-- Google Fonts (Cinzel & Playfair Display para Neocordel + Plus Jakarta Sans) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Eczar:wght@600;800&family=Playfair+Display:ital,wght@0,600;0,700;0,900;1,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Swiper.js Carousel CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

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
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(16px);
        }
        .hero-gradient {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.3) 0%, rgba(15, 23, 42, 0.9) 75%, rgba(15, 23, 42, 1) 100%);
        }
        /* Custom Swiper Pagination */
        .swiper-pagination-bullet-active {
            background: #F59E0B !important;
            width: 24px !important;
            border-radius: 6px !important;
        }
        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.6);
        }
    </style>
</head>
<body class="bg-sertao-bg text-slate-100 font-sans antialiased min-h-screen flex flex-col">
    <?php include_once __DIR__ . '/includes/loader.php'; ?>

    <!-- BARRA SUPERIOR INSTITUCIONAL -->
    <div class="bg-sertao-dark text-slate-400 text-xs py-2 px-4 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-compass text-amber-500 mr-1"></i> Região dos Cânions do Xingó (Canindé & Piranhas)</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="restaurantes.php" class="text-amber-400 hover:text-amber-300 font-bold transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left text-xs"></i> Voltar para o Conexão Cânions
                </a>
            </div>
        </div>
    </div>

    <!-- CABEÇALHO PRINCIPAL (NAVBAR) -->
    <header class="sticky top-0 z-50 glass-nav border-b border-amber-900/30 shadow-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo CONEXÃO CÂNIONS -->
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

                <!-- Nav Links -->
                <nav class="hidden lg:flex items-center gap-5 xl:gap-7 whitespace-nowrap">
                    <a href="index.php" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Início</a>
                    <a href="index.php#nossa-cidade" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Região</a>
                    <a href="index.php#turismo" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Atrativos</a>
                    <a href="restaurantes.php" class="text-sm font-bold text-amber-400 relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-amber-400 whitespace-nowrap">Guia Gastronômico</a>
                    <a href="index.php#eventos" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors whitespace-nowrap">Eventos</a>
                </nav>

                <!-- Botão Voltar -->
                <div class="shrink-0">
                    <a href="restaurantes.php" class="bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-slate-950 font-black px-4 sm:px-5 py-2.5 rounded-xl shadow-lg transition text-xs flex items-center gap-2 uppercase tracking-wider whitespace-nowrap">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Voltar para o Conexão Cânions</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO DA PÁGINA DO RESTAURANTE -->
    <section class="relative min-h-[440px] flex items-end justify-center overflow-hidden border-b border-slate-800">
        
        <!-- Imagem de Fundo em Destaque -->
        <div class="absolute inset-0 z-0">
            <img src="<?php echo $imagem; ?>" alt="<?php echo $nome; ?>" class="w-full h-full object-cover object-center filter brightness-90">
            <div class="absolute inset-0 hero-gradient"></div>
        </div>

        <!-- Conteúdo do Hero -->
        <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12 relative z-10">
            
            <!-- Breadcrumbs e Botão Voltar -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <nav class="flex items-center gap-2 text-xs font-bold text-slate-400">
                    <a href="index.php" class="hover:text-amber-400 transition">Início</a>
                    <span>/</span>
                    <a href="restaurantes.php" class="hover:text-amber-400 transition">Guia Gastronômico</a>
                    <span>/</span>
                    <span class="text-amber-400"><?php echo $nome; ?></span>
                </nav>

                <a href="restaurantes.php" class="inline-flex items-center gap-2 text-xs font-bold bg-slate-950/80 hover:bg-slate-900 text-amber-400 hover:text-amber-300 px-4 py-2 rounded-xl border border-slate-700/80 backdrop-blur-md shadow-md transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Voltar para o Conexão Cânions</span>
                </a>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                
                <!-- Informações Principais -->
                <div class="max-w-3xl">
                    <div class="flex flex-wrap items-center gap-3 mb-3">
                        <!-- Badge de Cidade (Canindé de São Francisco / Piranhas) -->
                        <span class="bg-amber-500 text-slate-950 font-black text-xs px-3.5 py-1.5 rounded-lg shadow-md uppercase tracking-wider flex items-center gap-1.5">
                            <i class="fa-solid fa-location-dot"></i> <?php echo $cidade; ?>
                        </span>

                        <span class="bg-slate-800 text-slate-200 font-bold text-xs px-3.5 py-1.5 rounded-lg border border-slate-700 uppercase tracking-wider">
                            <i class="fa-solid fa-utensils mr-1 text-amber-400"></i> <?php echo $categoria; ?>
                        </span>

                        <!-- Badge de Status Aprovado -->
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-bold uppercase bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 shadow-sm backdrop-blur-md">
                            <i class="fa-solid fa-circle-check text-emerald-400"></i>
                            <span>Verificado</span>
                        </span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl font-black font-cinzel tracking-tight text-white drop-shadow-lg">
                        <?php echo $nome; ?>
                    </h1>

                    <p class="text-slate-300 text-sm sm:text-base mt-3 flex items-center gap-2 font-medium">
                        <i class="fa-solid fa-location-dot text-amber-400 shrink-0"></i>
                        <span><?php echo $endereco; ?></span>
                    </p>
                </div>

                <!-- Botões de Ação Rápida de 1-Clique no Hero -->
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Botão WhatsApp com mensagem pré-formatada -->
                    <a href="<?php echo $whatsappUrl; ?>" target="_blank" class="bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold px-6 py-3.5 rounded-xl shadow-xl transition flex items-center justify-center gap-2.5 text-sm border border-emerald-400/30">
                        <i class="fa-brands fa-whatsapp text-lg"></i>
                        <span>Falar no WhatsApp</span>
                    </a>

                    <!-- Botão Rota direta no Google Maps / Waze -->
                    <a href="<?php echo $mapsUrl; ?>" target="_blank" class="bg-sertao-blue hover:bg-sky-600 text-white font-extrabold px-5 py-3.5 rounded-xl shadow-xl transition text-sm flex items-center justify-center gap-2 border border-sky-400/30">
                        <i class="fa-solid fa-diamond-turn-right text-base"></i>
                        <span>Abrir Rota / Maps</span>
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- ÁREA PRINCIPAL DE CONTEÚDO -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

        <!-- 1. GRADE COM INFORMAÇÕES PRÁTICAS DE 1-CLIQUE -->
        <section>
            <div class="mb-6 flex items-center gap-3">
                <div class="w-1.5 h-7 bg-amber-400 rounded-full"></div>
                <h2 class="text-xl sm:text-2xl font-black font-cinzel text-white">Informações & Rota Direta</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card Endereço & Rota Waze/Maps -->
                <div class="woodcut-card rounded-2xl p-6 shadow-lg flex flex-col justify-between hover:border-amber-500/50 transition">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Endereço & Rota</h3>
                        <p class="text-sm font-semibold text-white mt-2 leading-relaxed">
                            <?php echo $endereco; ?>
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-800">
                        <a href="<?php echo $mapsUrl; ?>" target="_blank" class="w-full bg-sertao-blue hover:bg-sky-600 text-white font-bold py-2 rounded-xl text-xs flex items-center justify-center gap-2 transition shadow-md">
                            <i class="fa-solid fa-location-arrow"></i> Abrir Rota no Google Maps
                        </a>
                    </div>
                </div>

                <!-- Card Horário de Funcionamento -->
                <div class="woodcut-card rounded-2xl p-6 shadow-lg flex flex-col justify-between hover:border-amber-500/50 transition">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Horário de Funcionamento</h3>
                        <p class="text-sm font-semibold text-white mt-2 leading-relaxed">
                            <?php echo $horario; ?>
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-xs font-bold text-emerald-400">Atendimento Aberto</span>
                    </div>
                </div>

                <!-- Card Telefone & WhatsApp -->
                <div class="woodcut-card rounded-2xl p-6 shadow-lg flex flex-col justify-between hover:border-emerald-500/50 transition">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-xl mb-4">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Atendimento no WhatsApp</h3>
                        <p class="text-base font-black text-white mt-2 font-mono">
                            <?php echo $telefone; ?>
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-800">
                        <a href="<?php echo $whatsappUrl; ?>" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2 rounded-xl text-xs flex items-center justify-center gap-2 transition shadow-md">
                            <i class="fa-brands fa-whatsapp text-sm"></i> Enviar Mensagem
                        </a>
                    </div>
                </div>

                <!-- Card Redes Sociais -->
                <div class="woodcut-card rounded-2xl p-6 shadow-lg flex flex-col justify-between hover:border-amber-500/50 transition">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Redes Sociais</h3>
                        <p class="text-sm font-semibold text-white mt-2 flex items-center gap-2">
                            <i class="fa-brands fa-instagram text-amber-400 text-base"></i>
                            <span><?php echo $instagramUser; ?></span>
                        </p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-800">
                        <a href="<?php echo $instagramUrl; ?>" target="_blank" class="text-xs font-bold text-amber-400 hover:text-amber-300 flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i> Ver Instagram
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- 2. SEÇÃO COM CARROSSEL FLUIDO SWIPER.JS & DESCRIÇÃO -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Coluna Principal: Carrossel Swiper.js & Descrição Detalhada -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- CARROSSEL SWIPER.JS DE FOTOS DO RESTAURANTE & PRATOS -->
                <div class="woodcut-card rounded-3xl p-6 shadow-2xl overflow-hidden">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-black font-cinzel text-white flex items-center gap-2">
                            <i class="fa-solid fa-camera text-amber-400"></i> Galeria Interativa do Estabelecimento
                        </h3>
                        <span class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Deslize para ver <i class="fa-solid fa-arrows-left-right text-amber-500 ml-1"></i></span>
                    </div>

                    <!-- Elemento Swiper -->
                    <div class="swiper main-restaurant-swiper rounded-2xl h-80 sm:h-96 w-full border border-slate-800">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide relative">
                                <img src="<?php echo $imagem; ?>" alt="<?php echo $nome; ?>" class="w-full h-full object-cover">
                                <div class="absolute bottom-4 left-4 bg-slate-950/80 px-3 py-1.5 rounded-lg border border-slate-800 text-xs font-bold text-white backdrop-blur-md">
                                    Fachada & Ambiência
                                </div>
                            </div>
                            <div class="swiper-slide relative">
                                <img src="assets/images/canions_xingo.jpg" alt="Cânions do Xingó" class="w-full h-full object-cover">
                                <div class="absolute bottom-4 left-4 bg-slate-950/80 px-3 py-1.5 rounded-lg border border-slate-800 text-xs font-bold text-white backdrop-blur-md">
                                    Vista da Região dos Cânions
                                </div>
                            </div>
                            <div class="swiper-slide relative">
                                <img src="assets/images/bode_assado.jpg" alt="Pratos Típicos" class="w-full h-full object-cover">
                                <div class="absolute bottom-4 left-4 bg-slate-950/80 px-3 py-1.5 rounded-lg border border-slate-800 text-xs font-bold text-white backdrop-blur-md">
                                    Especialidades da Gastronomia Sertaneja
                                </div>
                            </div>
                        </div>
                        <!-- Paginação Swiper -->
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next text-amber-400 !w-10 !h-10 bg-slate-950/60 rounded-full border border-slate-700/60 after:!text-sm"></div>
                        <div class="swiper-button-prev text-amber-400 !w-10 !h-10 bg-slate-950/60 rounded-full border border-slate-700/60 after:!text-sm"></div>
                    </div>
                </div>

                <!-- Descrição Detalhada -->
                <div class="woodcut-card rounded-3xl p-8 shadow-xl">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center text-lg border border-amber-500/20">
                            <i class="fa-solid fa-align-left"></i>
                        </div>
                        <h2 class="text-2xl font-black font-cinzel text-white">Sobre o Estabelecimento</h2>
                    </div>

                    <p class="text-slate-300 text-base leading-relaxed font-light space-y-4">
                        <?php echo nl2br($descricao); ?>
                    </p>

                    <!-- Badges de Diferenciais -->
                    <div class="mt-8 pt-6 border-t border-slate-800 flex flex-wrap gap-2 text-xs font-semibold">
                        <span class="bg-slate-900 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-700">
                            <i class="fa-solid fa-fish text-amber-400 mr-1.5"></i> Peixes Frescos do São Francisco
                        </span>
                        <span class="bg-slate-900 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-700">
                            <i class="fa-solid fa-shield-check text-emerald-400 mr-1.5"></i> Atendimento Qualificado
                        </span>
                        <span class="bg-slate-900 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-700">
                            <i class="fa-solid fa-credit-card text-sky-400 mr-1.5"></i> Aceita Cartões & Pix
                        </span>
                        <span class="bg-slate-900 text-slate-300 px-3 py-1.5 rounded-lg border border-slate-700">
                            <i class="fa-solid fa-square-parking text-amber-400 mr-1.5"></i> Estacionamento Fácil
                        </span>
                    </div>
                </div>

            </div>

            <!-- Coluna Lateral: Card em Destaque do Prato Principal -->
            <div class="space-y-6">
                
                <!-- Card Prato Destaque Neocordel -->
                <div class="woodcut-border bg-gradient-to-b from-sertao-card to-sertao-dark rounded-3xl p-8 shadow-2xl relative overflow-hidden">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-slate-950 flex items-center justify-center text-2xl font-black shadow-lg border border-amber-400/40">
                            <i class="fa-solid fa-utensils"></i>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold tracking-widest text-amber-400">Especialidade da Casa</span>
                            <h3 class="text-xl font-black font-cinzel text-white">Prato Destaque</h3>
                        </div>
                    </div>

                    <div class="mt-4 p-5 bg-slate-950/90 rounded-2xl border border-amber-500/30">
                        <p class="text-lg font-black text-amber-400 leading-snug font-serif">
                            "<?php echo $pratoDestaque; ?>"
                        </p>
                        <p class="text-xs text-slate-300 mt-2 leading-relaxed">
                            Preparado com receitas tradicionais e ingredientes selecionados da Região dos Cânions.
                        </p>
                    </div>

                    <div class="mt-6">
                        <a href="<?php echo $whatsappUrl; ?>" target="_blank" class="w-full bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-slate-950 font-black py-3.5 rounded-xl shadow-lg transition text-xs flex items-center justify-center gap-2 uppercase tracking-wider">
                            <i class="fa-brands fa-whatsapp text-sm"></i> Peça ou Consulte Disponibilidade
                        </a>
                    </div>
                </div>

                <!-- Card Marca CONEXÃO CÂNIONS -->
                <div class="bg-sertao-card/80 border border-slate-800 rounded-3xl p-6 shadow-lg text-center flex flex-col items-center">
                    <img src="assets/images/logo_icon.png" alt="Conexão Cânions" class="w-12 h-12 object-contain mb-3 drop-shadow-md">
                    <h4 class="text-sm font-black font-cinzel text-white tracking-wide">CONEXÃO <span class="text-amber-500">CÂNIONS</span></h4>
                    <p class="text-xs text-amber-400 font-bold uppercase tracking-wider mt-0.5">
                        Conectando você ao melhor do Velho Chico
                    </p>
                </div>

            </div>

        </section>

        <!-- 3. BOTÃO VISÍVEL DE VOLTAR PARA O CONEXÃO CÂNIONS -->
        <section class="pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-black font-cinzel text-white">Deseja explorar mais opções na região?</h3>
                <p class="text-xs text-slate-400 mt-0.5">Confira a lista completa de restaurantes de Canindé de São Francisco e Piranhas.</p>
            </div>

            <a href="restaurantes.php" class="w-full sm:w-auto bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-slate-950 font-black px-8 py-4 rounded-xl shadow-xl transition text-xs flex items-center justify-center gap-2 uppercase tracking-wider">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Voltar para o Conexão Cânions</span>
            </a>
        </section>

    </main>

    <!-- RODAPÉ DA MARCA -->
    <footer class="bg-sertao-dark border-t border-slate-800 py-10 mt-16 text-slate-400 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
                <div class="flex items-center gap-3">
                    <img src="assets/images/logo_icon.png" alt="Conexão Cânions" class="w-9 h-9 object-contain shrink-0 drop-shadow-md">
                    <div>
                        <span class="font-black font-cinzel text-white text-sm tracking-wide block">CONEXÃO <span class="text-amber-500">CÂNIONS</span></span>
                        <span class="text-slate-500 text-[11px]">Conectando você ao melhor do Velho Chico • Canindé & Piranhas</span>
                    </div>
                </div>

                <div class="flex flex-wrap justify-center gap-6 text-slate-400">
                    <a href="index.php" class="hover:text-amber-400 transition">Início</a>
                    <a href="restaurantes.php" class="hover:text-amber-400 transition">Guia Gastronômico</a>
                    <a href="index.php#turismo" class="hover:text-amber-400 transition">Atrativos</a>
                </div>

                <div class="text-slate-500">
                    &copy; <?php echo $currentYear; ?> - Todos os direitos reservados.
                </div>
            </div>
        </div>
    </footer>

    <!-- INICIALIZAÇÃO DO CARROSSEL SWIPER.JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.main-restaurant-swiper', {
                loop: true,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>

</body>
</html>
