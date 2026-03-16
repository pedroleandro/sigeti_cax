<?php $this->layout('admin/app', ['title' => $title]) ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editando Usuário: <strong>#<?= $user->getName() ?></strong></h1>
    </div>

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center"
                     style="min-height: 300px;"></div>

                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Editar Usuário</h1>
                        </div>

                        <?= flash_message() ?>

                        <form action="<?= url('/admin/usuarios/update') ?>" method="post">
                            <?= csrf_input() ?>
                            <input type="hidden" name="id" value="<?= $user->getId() ?>">

                            <div class="form-group">
                                <input type="text" class="form-control" name="name"
                                       value="<?= $user->getName() ?>" required>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" name="email"
                                       value="<?= $user->getEmail() ?>" required>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" name="password"
                                       placeholder="Digite apenas se quiser alterar">
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="document"
                                       value="<?= $user->getDocument() ?>" placeholder="CPF (somente números)">
                            </div>

                            <div class="form-group">
                                <select name="role" id="role" class="custom-select">
                                    <option value="professor" <?= $user->getRole() === 'professor' ? 'selected' : '' ?>>Professor</option>
                                    <option value="tecnico"   <?= $user->getRole() === 'tecnico'   ? 'selected' : '' ?>>Técnico</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="status" class="custom-select">
                                    <option value="registrado" <?= $user->getStatus() === 'registrado' ? 'selected' : '' ?>>Registrado</option>
                                    <option value="ativo"      <?= $user->getStatus() === 'ativo'      ? 'selected' : '' ?>>Ativo</option>
                                    <option value="inativo"    <?= $user->getStatus() === 'inativo'    ? 'selected' : '' ?>>Inativo</option>
                                </select>
                            </div>

                            <!-- Bloco de vínculos escola+turno -->
                            <div id="schoolLinks" style="display: <?= $user->getRole() === 'professor' ? 'block' : 'none' ?>;">
                                <hr>
                                <p class="font-weight-bold">Escolas e Turnos</p>

                                <div id="schoolLinksList">
                                    <?php if (!empty($userSchools)): ?>
                                        <?php foreach ($userSchools as $index => $link): ?>
                                            <div class="school-link-row row mb-2">
                                                <div class="col-7">
                                                    <select name="schools[<?= $index ?>][school_id]" class="custom-select">
                                                        <option value="">Selecione a escola</option>
                                                        <?php foreach ($schools as $school): ?>
                                                            <option value="<?= $school->getId() ?>"
                                                                    <?= $link->getSchoolId() == $school->getId() ? 'selected' : '' ?>>
                                                                <?= $school->getName() ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="schools[<?= $index ?>][shift]" class="custom-select">
                                                        <option value="manha"     <?= $link->getShift() === 'manha'     ? 'selected' : '' ?>>Manhã</option>
                                                        <option value="tarde"     <?= $link->getShift() === 'tarde'     ? 'selected' : '' ?>>Tarde</option>
                                                        <option value="integral"  <?= $link->getShift() === 'integral'  ? 'selected' : '' ?>>Integral</option>
                                                    </select>
                                                </div>
                                                <?php if ($index > 0): ?>
                                                    <div class="col-1 d-flex align-items-center">
                                                        <button type="button" class="btn btn-sm btn-danger remove-row">×</button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="school-link-row row mb-2">
                                            <div class="col-7">
                                                <select name="schools[0][school_id]" class="custom-select">
                                                    <option value="">Selecione a escola</option>
                                                    <?php foreach ($schools as $school): ?>
                                                        <option value="<?= $school->getId() ?>"><?= $school->getName() ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select name="schools[0][shift]" class="custom-select">
                                                    <option value="manha">Manhã</option>
                                                    <option value="tarde">Tarde</option>
                                                    <option value="integral">Integral</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <button type="button" class="btn btn-sm btn-secondary mb-3" id="addSchoolLink">
                                    + Adicionar outra escola
                                </button>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="<?= url('/admin/usuarios') ?>" class="btn btn-danger w-50 mr-3">Voltar</a>
                                <button type="submit" class="btn btn-primary w-50">Atualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const roleSelect = document.getElementById('role');
    const schoolLinks = document.getElementById('schoolLinks');
    const schoolLinksList = document.getElementById('schoolLinksList');
    let rowIndex = <?= max(count($userSchools), 1) ?>;

    const schoolOptions = `<?php foreach ($schools as $school): ?><option value="<?= $school->getId() ?>"><?= $school->getName() ?></option><?php endforeach; ?>`;

    roleSelect.addEventListener('change', function () {
        schoolLinks.style.display = this.value === 'professor' ? 'block' : 'none';
    });

    document.getElementById('addSchoolLink').addEventListener('click', function () {
        const row = document.createElement('div');
        row.className = 'school-link-row row mb-2';
        row.innerHTML = `
            <div class="col-7">
                <select name="schools[${rowIndex}][school_id]" class="custom-select">
                    <option value="">Selecione a escola</option>
                    ${schoolOptions}
                </select>
            </div>
            <div class="col-4">
                <select name="schools[${rowIndex}][shift]" class="custom-select">
                    <option value="manha">Manhã</option>
                    <option value="tarde">Tarde</option>
                    <option value="integral">Integral</option>
                </select>
            </div>
            <div class="col-1 d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-danger remove-row">×</button>
            </div>`;
        schoolLinksList.appendChild(row);
        rowIndex++;

        row.querySelector('.remove-row').addEventListener('click', () => row.remove());
    });

    document.querySelectorAll('.remove-row').forEach(btn => {
        btn.addEventListener('click', () => btn.closest('.school-link-row').remove());
    });
</script>