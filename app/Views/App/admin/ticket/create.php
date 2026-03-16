<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cadastrar Novo Chamado</h1>
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

                        <form class="user" action="<?= url('/admin/chamados/store') ?>" method="post">

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

                            <div class="form-group">
                                <select class="form-control" name="school_id" required>

                                    <option value="">Selecione a escola</option>

                                    <?php foreach ($schools as $school): ?>
                                        <option value="<?= $school->getId() ?>">
                                            <?= $school->getName() ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="opened_by" required>

                                    <option value="">Selecione o professor</option>

                                    <?php foreach ($teachers as $teacher): ?>
                                        <option value="<?= $teacher->getId() ?>">
                                            <?= $teacher->getName() ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="priority" required>
                                    <option value="baixa">Baixa</option>
                                    <option value="media" selected>Média</option>
                                    <option value="alta">Alta</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                Abrir Chamado
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->


