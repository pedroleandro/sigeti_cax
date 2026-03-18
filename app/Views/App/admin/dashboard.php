<?php $this->layout('admin/app', [
        'title' => $title,
        'user' => $user
]) ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <?= flash_message() ?>

    <!-- Cards de contagem -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Abertos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts['aberto'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-folder-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Em Andamento</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts['em_andamento'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Aguardando</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts['aguardando'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Resolvidos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $counts['resolvido'] ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de chamados que precisam de ação -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Chamados que precisam de atenção</h6>
            <small class="text-muted">Abertos, Em Andamento e Aguardando — ordenados por prioridade e data</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable">
                    <thead>
                    <tr>
                        <th>Título</th>
                        <th>Escola</th>
                        <th>Professor</th>
                        <th>Técnico</th>
                        <th>Prioridade</th>
                        <th>Status</th>
                        <th>Aberto em</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($tickets)): ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr>
                                <td><?= $ticket->getTitle() ?></td>
                                <td><?= $ticket->school()?->getName() ?? '—' ?></td>
                                <td><?= $ticket->openedBy()?->getName() ?? '—' ?></td>
                                <td><?= $ticket->getAssignedTo() ? $ticket->assignedTo()?->getName() : '—' ?></td>
                                <td>
                                    <?php
                                    $priority = $ticket->getPriority();
                                    $badge = match ($priority) {
                                        'baixa' => 'badge-secondary',
                                        'media' => 'badge-info',
                                        'alta'  => 'badge-danger',
                                        default => 'badge-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badge ?>">
                                            <?= ucfirst($priority) ?>
                                        </span>
                                </td>
                                <td>
                                    <?php
                                    $status = $ticket->getStatus();
                                    $badge = match ($status) {
                                        'aberto'       => 'badge-warning',
                                        'em_andamento' => 'badge-primary',
                                        'aguardando'   => 'badge-info',
                                        default        => 'badge-secondary'
                                    };
                                    ?>
                                    <span class="badge <?= $badge ?>">
                                            <?= str_replace('_', ' ', ucfirst($status)) ?>
                                        </span>
                                </td>
                                <td><?= $ticket->getOpenedAt() ?></td>
                                <td>
                                    <a href="<?= url('/admin/chamados/editar/' . $ticket->getId()) ?>"
                                       class="btn btn-sm btn-primary">Editar</a>
                                    <a href="<?= url('/admin/chamados/editar/' . $ticket->getId()) . '/comentarios' ?>"
                                       class="btn btn-sm btn-info">Comentar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Nenhum chamado pendente.</td>
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