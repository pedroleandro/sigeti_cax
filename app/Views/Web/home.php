<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title><?= $title ?? "Home | SIGETI" ?></title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="<?= assets('/images/favicon.ico') ?>"/>
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic"
          rel="stylesheet" type="text/css"/>
    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?= assets('/css/styles-creative.css') ?>" rel="stylesheet"/>
</head>
<body id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="<?= url() ?>">SIGETI CAX</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto my-2 my-lg-0">
                <li class="nav-item"><a class="nav-link" href="#about">Sobre</a></li>
                <li class="nav-item"><a class="nav-link" href="#services">Serviços</a></li>
                <li class="nav-item"><a class="nav-link" href="#portfolio">Atendimentos</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contato</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('/entrar') ?>">Entrar</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Masthead-->
<header class="masthead">
    <div class="container px-4 px-lg-5 h-100">
        <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end">
                <h1 class="text-white font-weight-bold">Gestão Inteligente de Chamados em TI</h1>
                <hr class="divider"/>
            </div>
            <div class="col-lg-8 align-self-baseline">
                <p class="text-white-75 mb-5">Organize solicitações, acompanhe atendimentos e modernize o suporte
                    técnico da sua instituição com uma plataforma eficiente e adaptável ao setor público.</p>
                <a class="btn btn-primary btn-xl" href="#about">Sobre nós</a>
            </div>
        </div>
    </div>
</header>
<!-- About-->
<section class="page-section bg-primary" id="about">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="text-white mt-0">Uma solução completa para suporte público</h2>
                <hr class="divider divider-light"/>
                <p class="text-white-75 mb-4">O sistema permite
                    registrar, acompanhar e gerenciar chamados com organização e transparência. Ideal para secretarias e
                    órgãos que buscam eficiência e modernização.</p>
                <a class="btn btn-light btn-xl" href="#services">Veja nossos serviços</a>
            </div>
        </div>
    </div>
</section>
<!-- Services-->
<section class="page-section" id="services">
    <div class="container px-4 px-lg-5">
        <h2 class="text-center mt-0">Nossos serviços</h2>
        <hr class="divider"/>
        <div class="row gx-4 gx-lg-5">
            <div class="col-lg-3 col-md-6 text-center">
                <div class="mt-5">
                    <div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div>
                    <h3 class="h4 mb-2">Abertura de Chamados</h3>
                    <p class="text-muted mb-0">Registre solicitações de suporte de forma simples e acompanhe o status do
                        atendimento em tempo real.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="mt-5">
                    <div class="mb-2"><i class="bi-laptop fs-1 text-primary"></i></div>
                    <h3 class="h4 mb-2">Gestão de Usuários</h3>
                    <p class="text-muted mb-0">Controle perfis de acesso, permissões e cadastros de forma segura,
                        organizando usuários por setor ou unidade.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="mt-5">
                    <div class="mb-2"><i class="bi-globe fs-1 text-primary"></i></div>
                    <h3 class="h4 mb-2">Dashboard Gerencial</h3>
                    <p class="text-muted mb-0">Visualize chamados atendidos no mês, em aberto, últimos registros e
                        indicadores organizados por unidade ou escola.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <div class="mt-5">
                    <div class="mb-2"><i class="bi-heart fs-1 text-primary"></i></div>
                    <h3 class="h4 mb-2">Solução Escalável</h3>
                    <p class="text-muted mb-0">Desenvolvido para secretarias e órgãos públicos que desejam modernizar e
                        profissionalizar o suporte técnico.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Portfolio-->
<div id="portfolio">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="<?= assets('/images/portfolio/fullsize/1.jpg') ?>" title="Project Name">
                    <img class="img-fluid" src="<?= assets('/images/portfolio/thumbnails/1.jpg') ?>" alt="..."/>
                    <div class="portfolio-box-caption">
                        <div class="project-category text-white-50">Usuário</div>
                        <div class="project-name">Abertura de Chamados</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="<?= assets('/images/portfolio/fullsize/2.jpg') ?>" title="Project Name">
                    <img class="img-fluid" src="<?= assets('/images/portfolio/thumbnails/2.jpg') ?>" alt="..."/>
                    <div class="portfolio-box-caption">
                        <div class="project-category text-white-50">Atendimento</div>
                        <div class="project-name">Gerenciamento de Chamados</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="<?= assets('/images/portfolio/fullsize/3.jpg') ?>" title="Project Name">
                    <img class="img-fluid" src="<?= assets('/images/portfolio/thumbnails/3.jpg') ?>" alt="..."/>
                    <div class="portfolio-box-caption">
                        <div class="project-category text-white-50">Gestão</div>
                        <div class="project-name">Dashboard de Indicadores</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="<?= assets('/images/portfolio/fullsize/4.jpg') ?>" title="Project Name">
                    <img class="img-fluid" src="<?= assets('/images/portfolio/thumbnails/4.jpg') ?>" alt="..."/>
                    <div class="portfolio-box-caption">
                        <div class="project-category text-white-50">Administração</div>
                        <div class="project-name">Controle de Usuários</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="<?= assets('/images/portfolio/fullsize/5.jpg') ?>" title="Project Name">
                    <img class="img-fluid" src="<?= assets('/images/portfolio/thumbnails/5.jpg') ?>" alt="..."/>
                    <div class="portfolio-box-caption">
                        <div class="project-category text-white-50">Monitoramento</div>
                        <div class="project-name">Histórico e Acompanhamento</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-sm-6">
                <a class="portfolio-box" href="<?= assets('/images/portfolio/fullsize/6.jpg') ?>" title="Project Name">
                    <img class="img-fluid" src="<?= assets('/images/portfolio/thumbnails/6.jpg') ?>" alt="..."/>
                    <div class="portfolio-box-caption p-3">
                        <div class="project-category text-white-50">Relatórios</div>
                        <div class="project-name">Relatórios e Estatísticas</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Call to action-->
<section class="page-section bg-dark text-white">
    <div class="container px-4 px-lg-5 text-center">
        <h2 class="mb-4">Peça agora uma demonstração e seu orçamento!</h2>
        <a class="btn btn-light btn-xl" href="#contact">Solicitar Orçamento!</a>
    </div>
</section>
<!-- Contact-->
<section class="page-section" id="contact">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Entre em Contato!</h2>
                <hr class="divider"/>
                <p class="text-muted mb-5">Precisa de mais informações sobre o sistema ou deseja solicitar uma
                    demonstração?
                    Envie sua mensagem e nossa equipe retornará o mais breve possível!</p>
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
            <div class="col-lg-6">
                <!-- * * * * * * * * * * * * * * *-->
                <!-- * * SB Forms Contact Form * *-->
                <!-- * * * * * * * * * * * * * * *-->
                <!-- This form is pre-integrated with SB Forms.-->
                <!-- To make this form functional, sign up at-->
                <!-- https://startbootstrap.com/solution/contact-forms-->
                <!-- to get an API token!-->
                <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                    <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="name" type="text" placeholder="Informe seu nome..."
                               data-sb-validations="required"/>
                        <label for="name">Nome Completo</label>
                        <div class="invalid-feedback" data-sb-feedback="name:required">O nome é obrigatório</div>
                    </div>
                    <!-- Email address input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" type="email" placeholder="seumelhoremail@email.com"
                               data-sb-validations="required,email"/>
                        <label for="email">Email</label>
                        <div class="invalid-feedback" data-sb-feedback="email:required">O e-mail é obrigatório.</div>
                        <div class="invalid-feedback" data-sb-feedback="email:email">O e-mail não é válido.</div>
                    </div>
                    <!-- Phone number input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="phone" type="tel" placeholder="(99) 99456-7890"
                               data-sb-validations="required"/>
                        <label for="phone">Telefone</label>
                        <div class="invalid-feedback" data-sb-feedback="phone:required">O número de telefone é
                            obrigatório.
                        </div>
                    </div>
                    <!-- Message input-->
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="message" type="text"
                                  placeholder="Nos conte um pouco sobre o seu negócio..."
                                  style="height: 10rem" data-sb-validations="required"></textarea>
                        <label for="message">Mensagem</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                    </div>
                    <!-- Submit success message-->
                    <!---->
                    <!-- This is what your users will see when the form-->
                    <!-- has successfully submitted-->
                    <div class="d-none" id="submitSuccessMessage">
                        <div class="text-center mb-3">
                            <div class="fw-bolder">Formulário enviado com sucesso!</div>
                            Em breve entraremos em contato
                        </div>
                    </div>
                    <!-- Submit error message-->
                    <!---->
                    <!-- This is what your users will see when there is-->
                    <!-- an error submitting the form-->
                    <div class="d-none" id="submitErrorMessage">
                        <div class="text-center text-danger mb-3">Ops! Erro ao enviar formulário.</div>
                    </div>
                    <!-- Submit Button-->
                    <div class="d-grid">
                        <button class="btn btn-primary btn-xl disabled" id="submitButton" type="submit">Enviar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
<!-- Footer-->
<footer class="bg-light py-5">
    <div class="container px-4 px-lg-5">
        <div class="small text-center text-muted"><?= date("Y") . " | " . APP_NAME ?></div>
    </div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SimpleLightbox plugin JS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
<!-- Core theme JS-->
<script src="<?= assets('/js/scripts-creative.js') ?>"></script>
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<!-- * *                               SB Forms JS                               * *-->
<!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
