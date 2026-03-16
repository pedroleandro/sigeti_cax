<?php $this->layout('teacher/app', [
        'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Abrir Novo Chamado</h1>
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
                            <h1 class="h4 text-gray-900 mb-4">Novo Chamado</h1>
                        </div>

                        <?= flash_message() ?>

                        <form class="user" action="<?= url('/professor/chamados/store') ?>" method="post">

                            <?= csrf_input() ?>

                            <div class="form-group">
                                <input type="text"
                                       class="form-control"
                                       name="title"
                                       placeholder="Título do Chamado" required>
                            </div>

                            <div class="form-group">
                                <textarea
                                        class="form-control"
                                        name="description"
                                        placeholder="Descrição do problema"
                                        rows="4" required></textarea>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="category_id" required>

                                    <option value="">Selecione a categoria</option>

                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category->getId() ?>">
                                            <?= $category->getName() ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                Enviar Chamado
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


