<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editando Categoria <?= $category->getName() ?></h1>
    </div>

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">

                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Editar Escola: </h1>
                        </div>

                        <?= flash_message() ?>

                        <form class="user" action="<?= url('/admin/categorias/update') ?>" method="post">

                            <?= csrf_input() ?>

                            <input type="hidden" name="id" value="<?= $category->getId() ?>">

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="name" id="name"
                                       value="<?= $category->getName() ?>" placeholder="Nome da Categoria" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="description"
                                       id="description"
                                       value="<?= $category->getDescription() ?>" placeholder="Descrição da Categoria"
                                       required>
                            </div>

                            <div class="d-flex">
                                <a href="<?= url('/admin/categorias') ?>" class="btn btn-danger w-50">
                                    Voltar
                                </a>
                                <button type="submit" class="btn btn-primary btn-user w-50">Atualizar</button>
                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


