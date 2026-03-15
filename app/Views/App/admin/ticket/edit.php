<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Editando Chamado: <strong>#<?= $ticket->getTitle() ?></strong>
        </h1>
    </div>

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">

            <div class="row">

                <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center"
                     style="min-height: 300px;">
                </div>

                <div class="col-lg-7">
                    <div class="p-5">

                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Editar Chamado</h1>
                        </div>

                        <?= flash_message() ?>

                        <form class="user" action="<?= url('/admin/chamados/update') ?>" method="post">

                            <?= csrf_input() ?>

                            <input type="hidden" name="id" value="<?= $ticket->getId() ?>">

                            <div class="form-group">
                                <input
                                        type="text"
                                        class="form-control"
                                        name="title"
                                        value="<?= $ticket->getTitle() ?>"
                                        placeholder="Título do Chamado"
                                        required>
                            </div>

                            <div class="form-group">
                                <textarea
                                        class="form-control"
                                        name="description"
                                        rows="4"
                                        placeholder="Descrição do Chamado"
                                        required><?= $ticket->getDescription() ?></textarea>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="category_id" required>

                                    <option value="">Selecione a categoria</option>

                                    <?php foreach ($categories as $category): ?>

                                        <option
                                                value="<?= $category->getId() ?>"
                                                <?= $ticket->getCategoryId() == $category->getId() ? 'selected' : '' ?>>

                                            <?= $category->getName() ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="school_id" required>

                                    <option value="">Selecione a escola</option>

                                    <?php foreach ($schools as $school): ?>

                                        <option
                                                value="<?= $school->getId() ?>"
                                                <?= $ticket->getSchoolId() == $school->getId() ? 'selected' : '' ?>>

                                            <?= $school->getName() ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="opened_by" required>

                                    <option value="">Selecione o professor</option>

                                    <?php foreach ($teachers as $teacher): ?>

                                        <option
                                                value="<?= $teacher->getId() ?>"
                                                <?= $ticket->getOpenedBy() == $teacher->getId() ? 'selected' : '' ?>>

                                            <?= $teacher->getName() ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="priority">

                                    <option value="baixa" <?= $ticket->getPriority() === 'baixa' ? 'selected' : '' ?>>Baixa</option>
                                    <option value="media" <?= $ticket->getPriority() === 'media' ? 'selected' : '' ?>>Média</option>
                                    <option value="alta" <?= $ticket->getPriority() === 'alta' ? 'selected' : '' ?>>Alta</option>
                                    <option value="critica" <?= $ticket->getPriority() === 'critica' ? 'selected' : '' ?>>Crítica</option>

                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="status">

                                    <option value="aberto" <?= $ticket->getStatus() === 'aberto' ? 'selected' : '' ?>>Aberto</option>
                                    <option value="em_andamento" <?= $ticket->getStatus() === 'em_andamento' ? 'selected' : '' ?>>Em Andamento</option>
                                    <option value="resolvido" <?= $ticket->getStatus() === 'resolvido' ? 'selected' : '' ?>>Resolvido</option>

                                </select>
                            </div>

                            <div class="d-flex">

                                <a href="<?= url('/admin/chamados') ?>" class="btn btn-danger w-50 mr-3">
                                    Voltar
                                </a>

                                <button type="submit" class="btn btn-primary w-50">
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