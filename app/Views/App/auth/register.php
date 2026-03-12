<?= $this->layout('auth/app', [
        'title' => $title ?? ""
]) ?>

<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Criar uma conta</h1>
                        </div>

                        <?= flash_message() ?>

                        <form class="user" action="<?= url('/auth/store') ?>" method="post">

                            <?= csrf_input() ?>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="name"
                                       id="exampleInputFullName"
                                       placeholder="Nome Completo" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" name="email"
                                       id="exampleInputEmail"
                                       placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user"
                                       name="password" id="examplePassword" placeholder="Senha" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Criar</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= url('/esqueceu-a-senha') ?>">Esqueceu a senha?</a>
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