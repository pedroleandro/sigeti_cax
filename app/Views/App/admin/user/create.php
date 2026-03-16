<?php $this->layout('admin/app', ['title' => $title]) ?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cadastrar Novo Usuário</h1>
    </div>

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center"
                     style="min-height: 300px;"></div>

                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Novo Usuário</h1>
                        </div>

                        <?= flash_message() ?>

                        <form action="<?= url('/admin/usuarios/store') ?>" method="post">
                            <?= csrf_input() ?>

                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Nome Completo" required>
                            </div>

                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Senha" required>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="document" placeholder="CPF (somente números)">
                            </div>

                            <div class="form-group">
                                <select name="role" id="role" class="custom-select">
                                    <option selected disabled>Selecione o Perfil</option>
                                    <option value="professor">Professor</option>
                                    <option value="tecnico">Técnico</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <select name="status" class="custom-select">
                                    <option selected disabled>Selecione o Status</option>
                                    <option value="registrado">Registrado</option>
                                    <option value="ativo">Ativo</option>
                                    <option value="inativo">Inativo</option>
                                </select>
                            </div>

                            <!-- Bloco de vínculos escola+turno (visível apenas para professor) -->
                            <div id="schoolLinks" style="display:none;">
                                <hr>
                                <p class="font-weight-bold">Escolas e Turnos</p>

                                <div id="schoolLinksList">
                                    <div class="school-link-row row mb-2">
                                        <div class="col-7">
                                            <select name="schools[0][school_id]" class="custom-select">
                                                <option value="">Selecione a escola</option>
                                                <?php foreach ($schools as $school): ?>
                                                    <option value="<?= $school->getId() ?>">
                                                        <?= $school->getName() ?>
                                                    </option>
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
                                </div>

                                <button type="button" class="btn btn-sm btn-secondary mb-3" id="addSchoolLink">
                                    + Adicionar outra escola
                                </button>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
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
    let rowIndex = 1;

    const schoolOptions = `<?php foreach ($schools as $school): ?><option value='<?= $school->getId() ?>'><?= $school->getName() ?></option><?php endforeach; ?>`;

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
</script>