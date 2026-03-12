<?php $this->layout('admin/app', [
    'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Escolas Cadastradas</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Escolas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Escola</th>
                        <th>Código</th>
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
                            <td>Editar | Deletar</td>
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
