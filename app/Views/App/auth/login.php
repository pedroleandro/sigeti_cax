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
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Bem vindo de volta</h1>
                                </div>

                                <form class="user" action="<?= url('/auth') ?>" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                               name="email" id="exampleInputEmail" aria-describedby="emailHelp"
                                               placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                               name="password" id="exampleInputPassword" placeholder="Senha" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Lembrar de
                                                mim?</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">Entrar</button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= url('/esqueceu-a-senha') ?>">Esqueceu a senha?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?= url('/registrar') ?>">Criar uma conta!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>