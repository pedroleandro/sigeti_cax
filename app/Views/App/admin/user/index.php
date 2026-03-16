<?php $this->layout('admin/app', ['title' => $title]) ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Usuários Cadastrados</h1>
        <a href="<?= url('/admin/usuarios/cadastrar') ?>" class="btn btn-primary btn-sm">Novo Usuário</a>
    </div>

    <?= flash_message() ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Usuários</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead>
                    <tr>
                        <th>Escolas</th>
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
                            <td>
                                <?php
                                $links = $user->schools();
                                if (empty($links)) {
                                    echo '—';
                                } else {
                                    $labels = [];
                                    foreach ($links as $link) {
                                        $school = $link->school();
                                        if ($school) {
                                            $shift = match($link->getShift()) {
                                                'manha'    => 'Manhã',
                                                'tarde'    => 'Tarde',
                                                'integral' => 'Integral',
                                                default    => $link->getShift()
                                            };
                                            $labels[] = $school->getName() . ' (' . $shift . ')';
                                        }
                                    }
                                    echo implode('<br>', $labels);
                                }
                                ?>
                            </td>
                            <td><?= $user->getName() ?></td>
                            <td><?= $user->getEmail() ?></td>
                            <td><?= $user->getDocument() ?? '—' ?></td>
                            <td><?= ucfirst($user->getRole()) ?></td>
                            <td><?= ucfirst($user->getStatus()) ?></td>
                            <td><?= $user->getLastLogin() ?? '—' ?></td>
                            <td>
                                <a href="<?= url('/admin/usuarios/editar/' . $user->getId()) ?>"
                                   class="btn btn-sm btn-primary">Editar</a>

                                <a class="btn btn-sm btn-danger" href="#"
                                   data-toggle="modal" data-target="#deleteModal<?= $user->getId() ?>">Deletar</a>

                                <div class="modal fade" id="deleteModal<?= $user->getId() ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirmar exclusão</h5>
                                                <button class="close" type="button" data-dismiss="modal"><span>×</span></button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza que deseja remover <strong><?= $user->getName() ?></strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                                                <form action="<?= url('/admin/usuarios/delete/' . $user->getId()) ?>" method="post">
                                                    <?= csrf_input() ?>
                                                    <button type="submit" class="btn btn-danger">Deletar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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