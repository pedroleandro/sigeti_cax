<?php $this->layout('admin/app', ['title' => $title]) ?>

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
                     style="min-height: 300px;"></div>

                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Editar Chamado</h1>
                        </div>

                        <?= flash_message() ?>

                        <!-- Informações somente leitura -->
                        <div class="form-group">
                            <label class="font-weight-bold">Título</label>
                            <p class="form-control-plaintext border-bottom"><?= $ticket->getTitle() ?></p>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Descrição</label>
                            <p class="form-control-plaintext border-bottom"><?= $ticket->getDescription() ?></p>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Escola</label>
                            <p class="form-control-plaintext border-bottom"><?= $ticket->school()?->getName() ?? '—' ?></p>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Professor</label>
                            <p class="form-control-plaintext border-bottom"><?= $ticket->openedBy()?->getName() ?? '—' ?></p>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Categoria</label>
                            <p class="form-control-plaintext border-bottom"><?= $ticket->category()?->getName() ?? '—' ?></p>
                        </div>

                        <!-- Campos editáveis -->
                        <form action="<?= url('/admin/chamados/update') ?>" method="post">
                            <?= csrf_input() ?>
                            <input type="hidden" name="id" value="<?= $ticket->getId() ?>">

                            <div class="form-group">
                                <label class="font-weight-bold">Prioridade</label>
                                <select class="form-control" name="priority">
                                    <option value="baixa" <?= $ticket->getPriority() === 'baixa' ? 'selected' : '' ?>>
                                        Baixa
                                    </option>
                                    <option value="media" <?= $ticket->getPriority() === 'media' ? 'selected' : '' ?>>
                                        Média
                                    </option>
                                    <option value="alta" <?= $ticket->getPriority() === 'alta' ? 'selected' : '' ?>>
                                        Alta
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Status</label>
                                <select class="form-control" name="status">
                                    <option value="aberto" <?= $ticket->getStatus() === 'aberto' ? 'selected' : '' ?>>
                                        Aberto
                                    </option>
                                    <option value="em_andamento" <?= $ticket->getStatus() === 'em_andamento' ? 'selected' : '' ?>>
                                        Em Andamento
                                    </option>
                                    <option value="aguardando" <?= $ticket->getStatus() === 'aguardando' ? 'selected' : '' ?>>
                                        Aguardando
                                    </option>
                                    <option value="resolvido" <?= $ticket->getStatus() === 'resolvido' ? 'selected' : '' ?>>
                                        Resolvido
                                    </option>
                                    <option value="finalizado" <?= $ticket->getStatus() === 'finalizado' ? 'selected' : '' ?>>
                                        Finalizado
                                    </option>
                                    <option value="arquivado" <?= $ticket->getStatus() === 'arquivado' ? 'selected' : '' ?>>
                                        Arquivado
                                    </option>
                                </select>
                            </div>

                            <div class="d-flex">
                                <a href="<?= url('/admin/chamados') ?>" class="btn btn-danger w-50 mr-3">Voltar</a>
                                <button type="submit" class="btn btn-primary w-50">Atualizar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>