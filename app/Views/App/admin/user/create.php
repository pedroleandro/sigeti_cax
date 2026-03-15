<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cadastrar Novo Usuário</h1>
    </div>

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center"
                     style="min-height: 300px;">
                </div>
                <div class="col-lg-7">
                    <div class="p-5">

                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Novo Usuário</h1>
                        </div>

                        <?= flash_message() ?>

                        <form class="user" action="<?= url('/admin/usuarios/store') ?>" method="post">

                            <?= csrf_input() ?>

                            <div class="form-group">
                                <select name="school" id="school" class="custom-select">
                                    <option selected disabled>Selecione a Escola</option>
                                    <?php foreach ($schools as $school) : ?>
                                        <option value="<?= $school->getId()?>"><?= $school->getName() ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="Nome Completo" required>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" name="email"
                                       id="exampleInputEmail"
                                       placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control"
                                       name="password" id="examplePassword" placeholder="Senha" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="document" id="document"
                                       placeholder="Documento">
                            </div>

                            <div class="form-group">
                                <select name="role" id="role" class="custom-select">
                                    <option selected disabled>Selecione o Perfil</option>
                                    <option value="professor">Professor</option>
                                    <option value="tecnico">Técnico</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="status" id="status" class="custom-select">
                                    <option selected disabled>Selecione o Status</option>
                                    <option value="registrado">Registrado</option>
                                    <option value="ativo">Ativo</option>
                                    <option value="inativo">Inativo</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


