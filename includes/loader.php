<?php
// Componente Page Loader - Conexão Cânions (Ritmo do Forró)
?>
<!-- PAGE LOADER (#page-loader) -->
<div id="page-loader" class="fixed inset-0 z-[9999] bg-[#0F172A] flex flex-col items-center justify-center transition-opacity duration-500 ease-out">
    <style>
        /* Animação do Trio de Forró (Balanço Rítmico da Sanfona, Zabumba e Triângulo) */
        @keyframes forroRhythm {
            0%, 100% {
                transform: rotate(0deg) scale(1) translateY(0);
            }
            25% {
                transform: rotate(-2.5deg) scale(1.03) translateY(-6px);
            }
            50% {
                transform: rotate(0deg) scale(0.97) translateY(0);
            }
            75% {
                transform: rotate(2.5deg) scale(1.03) translateY(-6px);
            }
        }

        /* Animação das Notas Musicais Flutuantes */
        @keyframes floatMusicNote {
            0% {
                opacity: 0;
                transform: translateY(12px) scale(0.6) rotate(-12deg);
            }
            50% {
                opacity: 1;
                transform: translateY(-20px) scale(1.15) rotate(12deg);
            }
            100% {
                opacity: 0;
                transform: translateY(-40px) scale(0.8) rotate(-15deg);
            }
        }

        .forro-img-loader {
            animation: forroRhythm 1.1s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
            transform-origin: center bottom;
            will-change: transform;
        }

        .forro-note {
            display: inline-block;
            animation: floatMusicNote 1.8s ease-in-out infinite;
            filter: drop-shadow(0 0 8px rgba(245, 158, 11, 0.6));
        }

        .forro-note-1 { animation-delay: 0s; }
        .forro-note-2 { animation-delay: 0.35s; }
        .forro-note-3 { animation-delay: 0.7s; }
        .forro-note-4 { animation-delay: 1.05s; }
        .forro-note-5 { animation-delay: 1.4s; }

        /* Travar scroll enquanto o loader está ativo */
        body.loader-active {
            overflow: hidden !important;
        }
    </style>

    <div class="relative flex flex-col items-center justify-center p-6 text-center select-none">

        <!-- Notas Musicais Flutuando -->
        <div class="absolute -top-14 inset-x-0 h-16 pointer-events-none flex justify-center items-center gap-5 overflow-visible">
            <span class="forro-note forro-note-1 text-amber-400 text-2xl sm:text-3xl">♪</span>
            <span class="forro-note forro-note-2 text-orange-500 text-3xl sm:text-4xl">♫</span>
            <span class="forro-note forro-note-3 text-yellow-400 text-xl sm:text-2xl">♬</span>
            <span class="forro-note forro-note-4 text-amber-500 text-2xl sm:text-3xl">♩</span>
            <span class="forro-note forro-note-5 text-orange-400 text-3xl sm:text-4xl">♫</span>
        </div>

        <!-- Ilustração dos Instrumentos de Forró -->
        <div class="relative my-2">
            <img src="assets/images/loader-forro.png" alt="Conectando ao Velho Chico" class="forro-img-loader w-72 sm:w-80 md:w-96 max-w-[85vw] h-auto object-contain drop-shadow-[0_12px_30px_rgba(245,158,11,0.25)]">
        </div>

        <!-- Texto Amarelo-Ouro (#F59E0B) -->
        <div class="mt-4 flex flex-col items-center gap-2">
            <span class="text-[#F59E0B] font-extrabold font-cinzel text-lg sm:text-xl tracking-wider animate-pulse drop-shadow-md">
                Conectando ao Velho Chico...
            </span>

            <!-- Indicador Rítmico Sertanejo -->
            <div class="flex items-center gap-2 mt-1">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-orange-500 animate-ping" style="animation-delay: 150ms;"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping" style="animation-delay: 300ms;"></span>
            </div>
        </div>

    </div>
</div>

<script>
    (function() {
        const loader = document.getElementById('page-loader');
        if (!loader) return;

        // Adiciona classe de trava de scroll
        document.body.classList.add('loader-active');

        // Função de ocultar suavemente (fade-out)
        function hideLoader() {
            if (loader.classList.contains('opacity-0')) return;
            loader.classList.add('opacity-0');
            setTimeout(function() {
                loader.style.display = 'none';
                document.body.classList.remove('loader-active');
            }, 500);
        }

        // 1. Ocultar quando a página carregar completamente
        if (document.readyState === 'complete') {
            setTimeout(hideLoader, 400);
        } else {
            window.addEventListener('load', function() {
                setTimeout(hideLoader, 400);
            });
        }

        // Fallback de segurança (máximo 2.5s)
        setTimeout(hideLoader, 2500);

        // 2. Exibir loader ao clicar em links internos de navegação
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (!link) return;
            const href = link.getAttribute('href');

            // Ignorar âncoras locais, javascript:, tel:, mailto:, wa.me, _blank
            if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('tel:') || href.startsWith('mailto:') || href.includes('wa.me') || link.getAttribute('target') === '_blank') {
                return;
            }

            // Ativar loader para transição de página suave
            loader.style.display = 'flex';
            setTimeout(function() {
                loader.classList.remove('opacity-0');
            }, 10);
        });
    })();
</script>
