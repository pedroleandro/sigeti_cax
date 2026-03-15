<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cadastrar Nova Categoria</h1>
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
                            <h1 class="h4 text-gray-900 mb-4">Nova Categoria</h1>
                        </div>

                        <?= flash_message() ?>

                        <form class="user" action="<?= url('/admin/categorias/store') ?>" method="post">

                            <?= csrf_input() ?>

                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="Nome da Categoria" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="description" id="description"
                                       placeholder="Descrição da Categoria">
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


