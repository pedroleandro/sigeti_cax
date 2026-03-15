<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Escolas Cadastradas</h1>

        <a href="<?= url('/admin/escolas/cadastrar') ?>" class="btn btn-primary btn-sm">
            Nova Escola
        </a>
    </div>

    <?= flash_message() ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Escolas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Escola</th>
                        <th>Endereço</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($schools as $school): ?>
                        <tr>
                            <td><?= $school->getCode() ?></td>
                            <td><?= $school->getName() ?></td>
                            <td><?= $school->getAddress() ?></td>
                            <td>
                                <a href="<?= url('/admin/escolas/editar/' . $school->getId()) ?>"
                                   class="btn btn-sm btn-primary">
                                    Editar
                                </a>

                                <a href="<?= url('/admin/escolas/deletar/' . $school->getId()) ?>"
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
