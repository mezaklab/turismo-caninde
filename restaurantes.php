<?php
// Prefeitura de Canindé de São Francisco - Sergipe
// Portal de Turismo Oficial - Guia Gastronômico Completo
$currentYear = date('Y');

// Lista Completa de Restaurantes e Estabelecimentos
$allRestaurants = [
    [
        'id' => 1,
        'name' => 'Restaurante Karrancas',
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
        'category' => 'Petiscaria & Frutos do Rio',
        'category_slug' => 'peixes',
        'specialty' => 'Caldinho de Peixe & Caipirinhas da Caatinga',
        'location' => 'Orla Fluvial - Canindé de São Francisco',
        'phone' => '(79) 99888-5544',
        'hours' => 'Qua a Dom: 10:00 às 23:00',
        'tag' => 'Beira-Rio',
        'image' => 'assets/images/hero_canyons.jpg'
    ],
    [
        'id' => 6,
        'name' => 'Mirante Xingó Gastrobar',
        'category' => 'Culinária Variada',
        'category_slug' => 'variada',
        'specialty' => 'Filé de Tilápia Grelhado & Drinks Tropicais',
        'location' => 'Mirante da Seabra - Ponto Mais Alto',
        'phone' => '(79) 99777-3322',
        'hours' => 'Qui a Dom: 16:00 às 00:00',
        'tag' => 'Pôr do Sol',
        'image' => 'assets/images/mirante_seabra.jpg'
    ],
    [
        'id' => 7,
        'name' => 'Pizzaria & Forno a Lenha Sertão',
        'category' => 'Pizzaria & Italiana',
        'category_slug' => 'variada',
        'specialty' => 'Pizzas Artesanais com Queijo Coalho & Carne de Sol',
        'location' => 'Rua Ananias Fernandes, Centro',
        'phone' => '(79) 99666-4411',
        'hours' => 'Seg a Dom: 18:00 às 23:30',
        'tag' => 'Forno a Lenha',
        'image' => 'assets/images/cordel_art.jpg'
    ],
    [
        'id' => 8,
        'name' => 'Doceria & Cafezal do Velho Chico',
        'category' => 'Doces & Cafés',
        'category_slug' => 'variada',
        'specialty' => 'Cartola Sertaneja, Doce de Leite & Café Raiz',
        'location' => 'Praça Matriz - Centro',
        'phone' => '(79) 99555-8822',
        'hours' => 'Ter a Dom: 14:00 às 21:00',
        'tag' => 'Doces Caseiros',
        'image' => 'assets/images/rota_cangaco.jpg'
    ]
];
?>
<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onde Comer em Canindé de São Francisco - SE | Guia Gastronômico</title>
    <meta name="description" content="Guia completo de restaurantes, bares, petiscarias e culinária sertaneja em Canindé de São Francisco, Sergipe. Onde comer nos Cânions do Xingó.">
    
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
                            bg: '#f8fafc',
                            dark: '#0f172a'
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
        .cordel-border {
            border: 2px dashed #b45309;
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
        }
        .card-hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-caninde-bg text-slate-800 font-sans antialiased">

    <!-- TOP HEADER -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-location-dot text-caninde-gold mr-1"></i> Estado de Sergipe | Região do São Francisco</span>
                <span class="hidden md:inline"><i class="fa-solid fa-utensils text-amber-400 mr-1"></i> Guia Gastronômico Oficial</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="index.php#contato" class="hover:text-caninde-gold transition"><i class="fa-solid fa-phone text-caninde-gold mr-1"></i> (79) 3346-1200</a>
            </div>
        </div>
    </div>

    <!-- CABEÇALHO (NAVBAR) -->
    <header class="sticky top-0 z-50 glass-nav border-b border-slate-700/50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo -->
                <a href="index.php" class="flex items-center gap-3 group">
                    <img src="assets/images/brasao_oficial.png" alt="Brasão Oficial de Canindé de São Francisco" class="h-16 w-auto object-contain drop-shadow-md group-hover:scale-105 transition-transform">
                    <div class="flex flex-col">
                        <span class="text-xs tracking-widest text-amber-400 font-bold uppercase">Prefeitura de</span>
                        <span class="text-lg font-extrabold tracking-tight text-white group-hover:text-amber-300 transition-colors">
                            CANINDÉ <span class="text-caninde-gold font-serif italic text-base font-semibold">de São Francisco</span>
                        </span>
                    </div>
                </a>

                <!-- Navigation Links -->
                <nav class="hidden lg:flex items-center gap-7">
                    <a href="index.php" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Início</a>
                    <a href="index.php#nossa-cidade" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Nossa Cidade</a>
                    <a href="index.php#turismo" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Turismo</a>
                    <a href="index.php#cordel-cangaco" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Rota do Cangaço</a>
                    <a href="restaurantes.php" class="text-sm font-semibold text-white hover:text-caninde-gold transition-colors relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-caninde-gold">Onde Comer</a>
                    <a href="index.php#eventos" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Eventos</a>
                    <a href="index.php#contato" class="text-sm font-medium text-slate-300 hover:text-caninde-gold transition-colors">Contato</a>
                </nav>

                <!-- Action Button -->
                <div class="flex items-center gap-3">
                    <button onclick="toggleModal('register-restaurant-modal')" class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold px-5 py-2.5 rounded-xl shadow-lg transition text-xs flex items-center gap-2">
                        <i class="fa-solid fa-plus-circle"></i>
                        <span>Cadastrar Restaurante</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO COMPACTO DA PÁGINA DE RESTAURANTES -->
    <section class="bg-slate-900 text-white py-14 relative overflow-hidden border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <!-- Breadcrumbs e Botão Voltar no Topo -->
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                <nav class="flex items-center gap-2 text-xs text-amber-400 font-semibold">
                    <a href="index.php" class="hover:underline flex items-center gap-1"><i class="fa-solid fa-house"></i> Início</a>
                    <span>/</span>
                    <span class="text-slate-300">Gastronomia & Onde Comer</span>
                </nav>

                <a href="index.php" class="inline-flex items-center gap-2 text-xs font-bold text-amber-400 hover:text-amber-300 bg-slate-800/90 hover:bg-slate-800 px-4 py-2 rounded-xl border border-slate-700 transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Voltar para a Página Inicial</span>
                </a>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight">
                        Guia Gastronômico de <span class="text-amber-400 font-serif italic">Canindé de São Francisco</span>
                    </h1>
                    <p class="text-slate-300 text-base sm:text-lg mt-3 max-w-2xl font-light">
                        Descubra a rica culinária sertaneja, peixes frescos do Rio São Francisco, carne de sol, petiscarias beira-rio e doces artesanais.
                    </p>
                </div>

                <div class="bg-slate-800/90 border border-slate-700 p-5 rounded-2xl shrink-0 text-center sm:text-left">
                    <span class="block text-2xl font-extrabold text-amber-400"><?php echo count($allRestaurants); ?> Estabelecimentos</span>
                    <span class="text-xs text-slate-400">Cadastrados no Portal Oficial</span>
                </div>
            </div>

        </div>
    </section>

    <!-- ÁREA DE FILTROS E BUSCA -->
    <section class="py-8 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Abas de Categoria -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-none">
                    <button onclick="filterCategory('all')" class="cat-btn active-cat bg-amber-500 text-slate-950 font-bold px-4 py-2 rounded-xl text-xs whitespace-nowrap shadow-sm">
                        Todos (<?php echo count($allRestaurants); ?>)
                    </button>
                    <button onclick="filterCategory('peixes')" class="cat-btn bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs whitespace-nowrap">
                        Peixes & Frutos do Rio
                    </button>
                    <button onclick="filterCategory('sertaneja')" class="cat-btn bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs whitespace-nowrap">
                        Comida Sertaneja
                    </button>
                    <button onclick="filterCategory('churrasco')" class="cat-btn bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs whitespace-nowrap">
                        Churrasco & Bode Assado
                    </button>
                    <button onclick="filterCategory('variada')" class="cat-btn bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs whitespace-nowrap">
                        Lanches, Pizzas & Doces
                    </button>
                </div>

                <!-- Campo de Busca em Tempo Real -->
                <div class="relative w-full md:w-80">
                    <input type="text" id="restaurant-search" onkeyup="filterRestaurants()" placeholder="Buscar restaurante, prato..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-xs">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </div>

            </div>
        </div>
    </section>

    <!-- GRID DE RESTAURANTES -->
    <section class="py-16 bg-caninde-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div id="restaurants-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($allRestaurants as $item): ?>
                    <div class="restaurant-card bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-md card-hover-lift flex flex-col group" data-category="<?php echo $item['category_slug']; ?>" data-name="<?php echo strtolower($item['name'] . ' ' . $item['specialty'] . ' ' . $item['location']); ?>">
                        
                        <div class="relative h-52 overflow-hidden">
                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4 bg-amber-500 text-slate-950 font-extrabold text-xs px-3 py-1.5 rounded-lg shadow-md uppercase tracking-wider">
                                <?php echo $item['category']; ?>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-xl font-bold text-slate-900 group-hover:text-amber-600 transition-colors">
                                        <?php echo $item['name']; ?>
                                    </h3>
                                    <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded">
                                        <?php echo $item['tag']; ?>
                                    </span>
                                </div>

                                <p class="text-xs font-bold text-amber-700 mb-3 flex items-center gap-1.5">
                                    <i class="fa-solid fa-utensils"></i> <?php echo $item['specialty']; ?>
                                </p>

                                <p class="text-xs text-slate-600 leading-relaxed mb-4">
                                    <?php echo $item['description']; ?>
                                </p>
                            </div>

                            <div class="border-t border-slate-100 pt-4 space-y-2">
                                <p class="text-xs text-slate-500 flex items-start gap-2">
                                    <i class="fa-solid fa-location-dot text-amber-500 mt-0.5 shrink-0"></i>
                                    <span><?php echo $item['location']; ?></span>
                                </p>

                                <p class="text-xs text-slate-500 flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-amber-500 shrink-0"></i>
                                    <span><?php echo $item['hours']; ?></span>
                                </p>

                                <div class="pt-3 flex items-center justify-between gap-3 border-t border-slate-100 mt-3">
                                    <a href="https://wa.me/55<?php echo preg_replace('/\D/', '', $item['phone']); ?>" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl text-xs flex items-center justify-center gap-2 transition">
                                        <i class="fa-brands fa-whatsapp text-sm"></i> Entrar em Contato (WhatsApp)
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Banner Inferior de Cadastro de Proprietários -->
            <div class="cordel-border mt-16 p-8 bg-white rounded-3xl shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border-2 border-amber-900/20">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center text-2xl shrink-0 shadow-lg">
                        <i class="fa-solid fa-store"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-900 text-xl">Seu estabelecimento ainda não está listado?</h3>
                        <p class="text-xs text-slate-600 mt-1 max-w-xl">
                            Cadastre seu restaurante, petiscaria ou lanchonete gratuitamente no portal oficial da Prefeitura de Canindé de São Francisco.
                        </p>
                    </div>
                </div>

                <button onclick="toggleModal('register-restaurant-modal')" class="w-full md:w-auto bg-amber-500 hover:bg-amber-400 text-slate-950 font-extrabold px-8 py-4 rounded-xl shadow-lg transition shrink-0 flex items-center justify-center gap-2 text-sm">
                    <i class="fa-solid fa-plus-circle"></i> Cadastrar Meu Restaurante
                </button>
            </div>

            <!-- Botão Voltar para a Página Inicial no Final -->
            <div class="mt-12 text-center">
                <a href="index.php" class="inline-flex items-center gap-2.5 text-slate-700 hover:text-slate-950 font-extrabold text-sm bg-white hover:bg-slate-100 px-6 py-3.5 rounded-2xl shadow-md border border-slate-200 transition-all">
                    <i class="fa-solid fa-arrow-left text-amber-500"></i>
                    <span>Voltar para a Página Inicial</span>
                </a>
            </div>

        </div>
    </section>

    <!-- RODAPÉ (FOOTER) -->
    <footer class="bg-slate-950 text-slate-300 border-t-4 border-amber-500 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6 text-xs text-slate-400">
            <div class="flex items-center gap-3">
                <img src="assets/images/brasao_oficial.png" alt="Brasão Oficial de Canindé" class="h-12 w-auto object-contain">
                <div>
                    <span class="block font-bold text-white">Prefeitura Municipal de Canindé de São Francisco</span>
                    <span>Secretaria de Turismo e Cultura - Sergipe</span>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="index.php" class="hover:text-amber-400">Voltar à Página Inicial</a>
                <span>•</span>
                <a href="index.php#contato" class="hover:text-amber-400">Fale Conosco</a>
            </div>
        </div>
    </footer>

    <!-- MODAL CADASTRE SEU RESTAURANTE -->
    <div id="register-restaurant-modal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 relative my-8 animate-fade-in max-h-[90vh] overflow-y-auto">
            <button onclick="toggleModal('register-restaurant-modal')" class="absolute top-5 right-5 text-slate-400 hover:text-slate-700 text-xl w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center transition" aria-label="Fechar modal">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="flex items-center gap-3 mb-5 border-b border-slate-100 pb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center text-xl font-bold shadow-md shrink-0">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div>
                    <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">Cadastre seu Restaurante</h3>
                    <p class="text-xs text-amber-700 font-semibold">Portal Oficial de Turismo da Prefeitura de Canindé</p>
                </div>
            </div>

            <div class="bg-amber-50 border-l-4 border-amber-500 p-4 rounded-r-xl mb-6">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-amber-600 text-base mt-0.5 shrink-0"></i>
                    <p class="text-xs text-amber-950 font-medium leading-relaxed">
                        <strong>Nota importante:</strong> Seu cadastro será enviado para análise da administração da Prefeitura antes de ser exibido no site.
                    </p>
                </div>
            </div>

            <form onsubmit="handleRestaurantSubmit(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nome do Estabelecimento *</label>
                    <input type="text" required placeholder="Ex: Restaurante Sabor do Velho Chico" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Categoria / Tipo de Culinária *</label>
                        <select required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm bg-white">
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
                        <input type="tel" required placeholder="(79) 99999-9999" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Endereço / Localização *</label>
                    <input type="text" required placeholder="Ex: Av. Beira Rio, nº 120 - Centro, Canindé de São Francisco" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Descrição Curta *</label>
                    <textarea rows="3" required placeholder="Descreva os pratos principais, horários de funcionamento e atrativos do seu estabelecimento..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:outline-none text-sm resize-none"></textarea>
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

    <!-- JAVASCRIPT DE FILTROS E MODAL -->
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.classList.toggle('hidden');
        }

        function handleRestaurantSubmit(e) {
            e.preventDefault();
            alert('Cadastro enviado com sucesso! Seu cadastro será enviado para análise da administração da Prefeitura antes de ser exibido no site.');
            toggleModal('register-restaurant-modal');
            e.target.reset();
        }

        function filterCategory(catSlug) {
            const buttons = document.querySelectorAll('.cat-btn');
            buttons.forEach(btn => {
                btn.classList.remove('bg-amber-500', 'text-slate-950', 'shadow-sm');
                btn.classList.add('bg-slate-100', 'text-slate-700');
            });
            event.target.classList.remove('bg-slate-100', 'text-slate-700');
            event.target.classList.add('bg-amber-500', 'text-slate-950', 'shadow-sm');

            const cards = document.querySelectorAll('.restaurant-card');
            cards.forEach(card => {
                if (catSlug === 'all' || card.dataset.category === catSlug) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function filterRestaurants() {
            const query = document.getElementById('restaurant-search').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.restaurant-card');
            cards.forEach(card => {
                if (!query || card.dataset.name.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
