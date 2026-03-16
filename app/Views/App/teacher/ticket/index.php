<?php $this->layout('teacher/app', [
        'title' => $title,
]) ?>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Meus Chamados</h1>

        <a href="<?= url('/professor/chamados/cadastrar') ?>" class="btn btn-primary btn-sm">
            Novo Chamado
        </a>
    </div>

    <?= flash_message() ?>

    <div class="card shadow mb-4">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Chamados</h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover table-responsive-sm table-responsive-md table-responsive-lg"
                       id="dataTable">

                    <thead>
                    <tr>
                        <th>Título</th>
                        <th>Escola</th>
                        <th>Professor</th>
                        <th>Técnico</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php if (!empty($tickets)): ?>

                        <?php foreach ($tickets as $ticket): ?>

                            <tr>

                                <td><?= $ticket->getTitle() ?></td>
                                <td><?= $ticket->school()->getName() ?></td>
                                <td><?= $ticket->openedBy()->getName() ?></td>
                                <td><?= $ticket->getAssignedTo() === null ? "" : $ticket->assignedTo()->getName() ?></td>

                                <td>
                                    <?php
                                    $priority = $ticket->getPriority();

                                    $badge = match ($priority) {
                                        'baixa' => 'badge-secondary',
                                        'media' => 'badge-info',
                                        'alta' => 'badge-danger'
                                    };
                                    ?>

                                    <span class="badge <?= $badge ?>">
                                        <?= str_replace("_", " ", ucfirst($priority)) ?>
                                    </span>
                                </td>

                                <td>

                                    <?php
                                    $status = $ticket->getStatus();

                                    $badge = match ($status) {
                                        'aberto' => 'badge-warning',
                                        'em_andamento' => 'badge-primary',
                                        'aguardando' => 'badge-info',
                                        'resolvido' => 'badge-success',
                                        'finalizado' => 'badge-dark',
                                        'arquivado' => 'badge-secondary',
                                        default => 'badge-secondary'
                                    };
                                    ?>

                                    <span class="badge <?= $badge ?>">
                                        <?= str_replace("_", " ", ucfirst($status)) ?>
                                    </span>

                                </td>

                                <td>

                                    <a href="<?= url('/professor/chamados/editar/' . $ticket->getId()) . '/comentarios' ?>"
                                       class="btn btn-sm btn-info">
                                        Comentar
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="5" class="text-center">
                                Nenhum chamado encontrado.
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

                <div class="d-flex justify-content-center mt-4">
                    <?= $paginator->render() ?>
                </div>

            </div>
        </div>
    </div>

</div>