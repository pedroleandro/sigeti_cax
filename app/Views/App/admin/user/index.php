<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Usuários Cadastrados</h1>

        <a href="<?= url('/admin/usuarios/cadastrar') ?>" class="btn btn-primary btn-sm">
            Novo Usuário
        </a>
    </div>

    <?= flash_message() ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Usuários</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-responsive-sm table-res" id="dataTable">
                    <thead>
                    <tr>
                        <th>Escola</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Documento</th>
                        <th>Perfil</th>
                        <th>Status</th>
                        <th>Último Acesso</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user->school()?->getName() ?? " - " ?></td>
                            <td><?= $user->getName() ?></td>
                            <td><?= $user->getEmail() ?></td>
                            <td><?= $user->getDocument() ?></td>
                            <td><?= $user->getRole() ?></td>
                            <td><?= $user->getStatus() ?></td>
                            <td><?= $user->getLastLogin() ?></td>
                            <td>
                                <a href="<?= url('/admin/usuarios/editar/' . $user->getId()) ?>"
                                   class="btn btn-sm btn-primary">
                                    Editar
                                </a>

                                <a href="<?= url('/admin/escolas/deletar/' . $user->getId()) ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Tem certeza que deseja deletar esta escola?')">
                                    Deletar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    <?= $paginator->render() ?>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
