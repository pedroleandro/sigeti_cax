<?php $this->layout('admin/app', [
        'title' => $title,
]) ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <!--        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i-->
        <!--                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
    </div>

    <?= flash_message() ?>

    <!-- Content Row -->
    <div class="row">

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Chamados Abertos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $ticketsOpen ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Chamados Em Atendimento
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $ticketsInProgress ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Chamados Resolvidos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $ticketsResolved ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fire fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Chamados Finalizados
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $ticketsCompleted ?? 0 ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Chamados -->
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
                                        'fechado' => 'badge-dark',
                                        'arquivado' => 'badge-secondary',
                                        default => 'badge-secondary'
                                    };
                                    ?>

                                    <span class="badge <?= $badge ?>">
                                        <?= str_replace("_", " ", ucfirst($status)) ?>
                                    </span>

                                </td>

                                <td>

                                    <a href="<?= url('/admin/chamados/editar/' . $ticket->getId()) ?>"
                                       class="btn btn-sm btn-primary">
                                        Editar
                                    </a>

                                    <a href="<?= url('/admin/chamados/editar/' . $ticket->getId()) . '/comentarios' ?>"
                                       class="btn btn-sm btn-info">
                                        Comentar
                                    </a>

                                    <a class="btn btn-sm btn-danger"
                                       href="#"
                                       data-toggle="modal"
                                       data-target="#deleteModal<?= $ticket->getId() ?>">
                                        Deletar
                                    </a>

                                    <div class="modal fade" id="deleteModal<?= $ticket->getId() ?>" tabindex="-1"
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

                                                    <form action="<?= url('/admin/chamados/delete/' . $ticket->getId()) ?>"
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
<!-- /.container-fluid -->
