<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editando Usuário: <strong>#<?= $user->getName() ?></strong></h1>
    </div>

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">

            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>

                <div class="col-lg-7">
                    <div class="p-5">

                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Editar Usuário</h1>
                        </div>

                        <?= flash_message() ?>

                        <form class="user" action="<?= url('/admin/usuarios/update') ?>" method="post">

                            <?= csrf_input() ?>

                            <input type="hidden" name="id" value="<?= $user->getId() ?>">

                            <!-- Escola -->
                            <div class="form-group">
                                <select class="form-control" name="school_id">

                                    <option value="">Selecione a escola</option>

                                    <?php foreach ($schools as $school): ?>

                                        <option
                                                value="<?= $school->getId() ?>"
                                                <?= $user->getSchoolId() == $school->getId() ? 'selected' : '' ?>>

                                            <?= $school->getName() ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <!-- Nome -->
                            <div class="form-group">
                                <input
                                        type="text"
                                        class="form-control"
                                        name="name"
                                        value="<?= $user->getName() ?>"
                                        required
                                >
                            </div>

                            <!-- Email -->
                            <div class="form-group">

                                <input
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        value="<?= $user->getEmail() ?>"
                                        required
                                >
                            </div>

                            <!-- Senha -->
                            <div class="form-group">

                                <input
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        placeholder="Digite apenas se quiser alterar"
                                >
                            </div>

                            <!-- Perfil -->
                            <div class="form-group">
                                <select name="role" class="custom-select">

                                    <option value="professor" <?= $user->getRole() == 'professor' ? 'selected' : '' ?>>
                                        Professor
                                    </option>

                                    <option value="tecnico" <?= $user->getRole() == 'tecnico' ? 'selected' : '' ?>>
                                        Técnico
                                    </option>

                                </select>
                            </div>

                            <!-- Status -->
                            <div class="form-group">

                                <select name="status" class="custom-select">

                                    <option value="registrado" <?= $user->getStatus() == 'registrado' ? 'selected' : '' ?>>
                                        Registrado
                                    </option>

                                    <option value="ativo" <?= $user->getStatus() == 'ativo' ? 'selected' : '' ?>>
                                        Ativo
                                    </option>

                                    <option value="inativo" <?= $user->getStatus() == 'inativo' ? 'selected' : '' ?>>
                                        Inativo
                                    </option>

                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="<?= url('/admin/usuarios') ?>" class="btn btn-danger btn-user w-50">
                                    Voltar
                                </a>

                                <button type="submit" class="btn btn-primary btn-user w-50">
                                    Atualizar
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>