<?= $this->layout('auth/app', [
        'title' => $title ?? ""
]) ?>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center"
                             style="min-height: 300px;">
                        </div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Esqueceu a senha?</h1>
                                    <p class="mb-4">Entendemos, imprevistos acontecem. Basta inserir seu endereço de
                                        e-mail abaixo
                                        e enviaremos um link para redefinir sua senha.!</p>
                                </div>

                                <?= flash_message() ?>

                                <form class="user" action="<?= url('/auth/send-link') ?>" method="post">

                                    <?= csrf_input() ?>

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                               name="email" id="exampleInputEmail" aria-describedby="emailHelp"
                                               placeholder="E-mail" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Recuperar Senha
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= url('/registrar') ?>">Criar uma conta!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= url('/entrar') ?>">Ja tem uma conta? Entrar!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>