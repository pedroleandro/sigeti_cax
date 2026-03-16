<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Categorias Cadastradas</h1>

        <a href="<?= url('/admin/categorias/cadastrar') ?>" class="btn btn-primary btn-sm">
            Nova Categoria
        </a>
    </div>

    <?= flash_message() ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Categorias</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-responsive-sm" id="dataTable" width="100%"
                       cellspacing="0">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category->getName() ?></td>
                            <td><?= $category->getDescription() ?></td>
                            <td>
                                <a href="<?= url('/admin/categorias/editar/' . $category->getId()) ?>"
                                   class="btn btn-sm btn-primary">
                                    Editar
                                </a>

                                <a class="btn btn-sm btn-danger"
                                   href="#"
                                   data-toggle="modal"
                                   data-target="#deleteModal<?= $category->getId() ?>">
                                    Deletar
                                </a>

                                <div class="modal fade" id="deleteModal<?= $category->getId() ?>" tabindex="-1"
                                     role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Tem certeza que deseja deletar o registro?</h5>
                                                <button class="close" type="button" data-dismiss="modal">
                                                    <span>×</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                Selecione "Deletar" abaixo para apagar o registro.
                                            </div>

                                            <div class="modal-footer">

                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                                    Cancelar
                                                </button>

                                                <form action="<?= url('/admin/categorias/delete/' . $category->getId()) ?>"
                                                      method="post">
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
<!-- /.container-fluid -->
