<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?= $title ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="<?= assets_flex_start('/assets/img/favicon.png') ?>" rel="icon">
    <link href="<?= assets_flex_start('/assets/img/apple-touch-icon.png') ?>" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= assets_flex_start('/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/vendor/aos/aos.css') ?>" rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
    <link href="<?= assets_flex_start('/assets/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">
    <link href="<?= assets('/css/custom.css') ?>" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="<?= assets_flex_start('/assets/css/main.css') ?>" rel="stylesheet">

    <!-- =======================================================
    * Template Name: FlexStart
    * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
    * Updated: Nov 01 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body class="index-page">

<div id="sigeti-topbar" role="banner" aria-label="Barra de informações">
    <div class="tb-inner">

        <!-- ── Esquerda: anúncio + contatos ── -->
        <div class="tb-left">
            <div class="tb-ann">
                <span class="tb-pulse" aria-hidden="true"></span>
                SIGETI v2.0 —&nbsp;<strong>Novos relatórios de SLA disponíveis</strong>
            </div>

            <span class="tb-vline" aria-hidden="true"></span>

            <a href="tel:+559999999999" class="tb-contact" aria-label="Telefone">
                <i class="bi bi-telephone"></i>
                (99) 9 9999-9999
            </a>

            <span class="tb-vline" aria-hidden="true"></span>

            <a href="mailto:contato@sigeti.com.br" class="tb-contact" aria-label="E-mail">
                <i class="bi bi-envelope"></i>
                contato@sigeti.com.br
            </a>
        </div>

        <!-- ── Direita: redes sociais + login ── -->
        <div class="tb-right">

            <nav class="tb-socs" aria-label="Redes sociais">
                <!-- WhatsApp -->
                <a href="https://wa.me/5599999999999"
                   class="tb-si tb-si-wa"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="WhatsApp">
                    <i class="bi bi-whatsapp"></i>
                </a>
                <!-- E-mail -->
                <a href="mailto:contato@sigeti.com.br"
                   class="tb-si tb-si-em"
                   aria-label="E-mail">
                    <i class="bi bi-envelope-fill"></i>
                </a>
                <!-- Instagram -->
                <a href="https://instagram.com/sigeti"
                   class="tb-si tb-si-ig"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="Instagram">
                    <i class="bi bi-instagram"></i>
                </a>
                <!-- LinkedIn -->
                <a href="https://linkedin.com/company/sigeti"
                   class="tb-si tb-si-li"
                   target="_blank" rel="noopener noreferrer"
                   aria-label="LinkedIn">
                    <i class="bi bi-linkedin"></i>
                </a>
            </nav>

            <span class="tb-divider" aria-hidden="true"></span>
            <a href="<?= url('/login') ?>" class="tb-login">Entrar</a>

        </div>
    </div>
</div>

<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a href="<?= url('/') ?>" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="<?= assets_flex_start('/assets/img/logo.png') ?>" alt="">
            <h1 class="sitename">SIGETI</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="" class="active">Home<br></a></li>
                <li><a href="<?= url('/') ?>#about">Sobre</a></li>
                <li><a href="<?= url('/') ?>#services">Serviços</a></li>
                <li><a href="<?= url('/') ?>#team">Time</a></li>
                <li><a href="<?= url('/') ?>#contact">Contato</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="btn-getstarted flex-md-shrink-0" href="">Teste Grátis</a>

    </div>
</header>

<main class="main">

    <?= $this->section('content') ?>

</main>

<footer id="footer" class="footer">

    <!-- ══ FAIXA PRINCIPAL ══ -->
    <div class="footer-main">
        <div class="container">
            <div class="row gy-5">

                <!-- ── Coluna Brand ── -->
                <div class="col-lg-4 col-md-12">
                    <a href="<?= url('/') ?>" class="ft-brand d-flex align-items-center gap-2 mb-3">
                        <div class="ft-logo-icon">
                            <span>SG</span>
                        </div>
                        <div>
                            <div class="ft-logo-name">SIGETI</div>
                            <div class="ft-logo-sub">Sistema de Gestão de Chamados de TI</div>
                        </div>
                    </a>

                    <p class="ft-desc">
                        Sistema inteligente de gestão de chamados de TI. Rastreabilidade total,
                        SLA automatizado e relatórios em tempo real para equipes de qualquer porte.
                    </p>

                    <!-- Contatos -->
                    <ul class="ft-contacts">
                        <li>
                            <i class="bi bi-geo-alt-fill"></i>
                            <span>Av. Luis Sales, nº 147, Ponte — Caxias, MA</span>
                        </li>
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <a href="tel:+559989995548">+55 (99) 9 8999-5548</a>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <a href="mailto:contato@sigeti.com.br">contato@sigeti.com.br</a>
                        </li>
                    </ul>

                    <!-- Redes sociais (botões com label igual ao topbar) -->
                    <nav class="ft-socs" aria-label="Redes sociais">
                        <a href="https://wa.me/5599989995548" class="ft-sb ft-sb-wa" target="_blank"
                           rel="noopener noreferrer">
                            <i class="bi bi-whatsapp"></i><span>WhatsApp</span>
                        </a>
                        <a href="mailto:contato@sigeti.com.br" class="ft-sb ft-sb-em">
                            <i class="bi bi-envelope-fill"></i><span>E-mail</span>
                        </a>
                        <a href="https://instagram.com/sigeti" class="ft-sb ft-sb-ig" target="_blank"
                           rel="noopener noreferrer">
                            <i class="bi bi-instagram"></i><span>Instagram</span>
                        </a>
                        <a href="https://linkedin.com/company/sigeti" class="ft-sb ft-sb-li" target="_blank"
                           rel="noopener noreferrer">
                            <i class="bi bi-linkedin"></i><span>LinkedIn</span>
                        </a>
                    </nav>
                </div>

                <!-- ── Coluna Links Úteis ── -->
                <div class="col-lg-2 col-md-4 col-6">
                    <h5 class="ft-col-title">Links Úteis</h5>
                    <ul class="ft-links">
                        <li><a href="<?= url('/') ?>">Home</a></li>
                        <li><a href="<?= url('/') ?>#about">Sobre nós</a></li>
                        <li><a href="<?= url('/') ?>#services">Serviços</a></li>
                        <li><a href="<?= url('/') ?>#team">Nossa equipe</a></li>
                        <li><a href="<?= url('/') ?>#contact">Contato</a></li>
                    </ul>
                </div>

                <!-- ── Coluna Serviços ── -->
                <div class="col-lg-2 col-md-4 col-6">
                    <h5 class="ft-col-title">Nossos Serviços</h5>
                    <ul class="ft-links">
                        <li><a href="">Abertura de Chamados</a></li>
                        <li><a href="">Gestão de Atendimentos</a></li>
                        <li><a href="">Atendimentos por Setores</a></li>
                        <li><a href="">Histórico de Chamados</a></li>
                        <li><a href="">Relatório e Indicadores</a></li>
                        <li><a href="">Controle de Acesso</a></li>
                    </ul>
                </div>

                <!-- ── Coluna Newsletter ── -->
                <div class="col-lg-4 col-md-4 col-12">
                    <h5 class="ft-col-title">Fique por dentro</h5>
                    <p class="ft-nl-desc">
                        Receba novidades, dicas de gestão de TI e atualizações do sistema direto no seu e-mail.
                    </p>
                    <form class="ft-nl-form" action="" method="post" aria-label="Newsletter">
                        <label for="ft-nl-email" class="visually-hidden">Seu e-mail</label>
                        <input
                                class="ft-nl-in"
                                type="email"
                                id="ft-nl-email"
                                name="email"
                                placeholder="seu@empresa.com"
                                required
                                autocomplete="email"
                        >
                        <button class="ft-nl-btn" type="submit">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                    <p class="ft-nl-note">
                        <i class="bi bi-shield-lock"></i>
                        Sem spam. Cancele quando quiser.
                    </p>

                    <!-- Status do sistema -->
                    <div class="ft-status">
                        <span class="ft-status-dot" aria-hidden="true"></span>
                        <span>Todos os sistemas operacionais</span>
                    </div>
                </div>

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.footer-main -->

    <!-- ══ FAIXA BOTTOM ══ -->
    <div class="footer-bottom">
        <div class="container">
            <div class="ft-bottom-inner">

                <p class="ft-copy">
                    © <?= date('Y') ?> <strong>SIGETI</strong> — Sistema Inteligente de Gestão de Chamados de TI.
                    Todos os direitos reservados.
                </p>

                <nav class="ft-legal" aria-label="Links legais">
                    <a href="">Privacidade</a>
                    <span aria-hidden="true">·</span>
                    <a href="">Termos de uso</a>
                    <span aria-hidden="true">·</span>
                    <a href="">LGPD</a>
                </nav>

                <!-- Mini ícones sociais -->
                <nav class="ft-minis" aria-label="Redes sociais">
                    <a href="https://wa.me/5599989995548" class="ft-mini ft-mi-wa" target="_blank"
                       rel="noopener noreferrer" aria-label="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="https://instagram.com/sigeti" class="ft-mini ft-mi-ig" target="_blank"
                       rel="noopener noreferrer" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://linkedin.com/company/sigeti" class="ft-mini ft-mi-li" target="_blank"
                       rel="noopener noreferrer" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="https://facebook.com/sigeti" class="ft-mini ft-mi-fb" target="_blank"
                       rel="noopener noreferrer" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                </nav>

            </div>
        </div>
    </div><!-- /.footer-bottom -->

</footer>

<!-- Scroll Top -->
<a href="" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?= assets_flex_start('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/php-email-form/validate.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/aos/aos.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/glightbox/js/glightbox.min.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/purecounter/purecounter_vanilla.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/isotope-layout/isotope.pkgd.min.js') ?>"></script>
<script src="<?= assets_flex_start('/assets/vendor/swiper/swiper-bundle.min.js') ?>"></script>

<!-- Main JS File -->
<script src="<?= assets_flex_start('/assets/js/main.js') ?>"></script>

<script>
    // ── Topbar: esconde ao rolar, fixa o header no topo ──
    (function () {
        const topbar = document.getElementById('sigeti-topbar');
        const header = document.getElementById('header');

        if (!topbar || !header) return;

        const topbarH = topbar.offsetHeight; // altura do topbar (geralmente 40px)

        window.addEventListener('scroll', function () {
            if (window.scrollY >= topbarH) {
                header.classList.add('header-fixed'); // gruda o header no topo
                topbar.classList.add('topbar-hidden'); // esconde o topbar
            } else {
                header.classList.remove('header-fixed');
                topbar.classList.remove('topbar-hidden');
            }
        }, {passive: true});
    })();
</script>

</body>

</html>
