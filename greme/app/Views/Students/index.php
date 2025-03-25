<?= $this->extend('Layouts/main') ?>

<?= $this->section('title') ?>
<?php echo $title ?>
<?= $this->endSection() ?>

<?= $this->section('css') ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/bootstrap-table.min.css">

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6><?php echo $title ?></h6>

                <div class="row">
                    <div class="col-md-10">
                        <div class="form-floating mb-3">
                            <input type="cpf" class="form-control cpf" placeholder="CPF do Responsável" name="cpf" id="cpf">
                            <label for="cpf">CPF do Responsável para incluir um novo aluno</label>
                        </div>
                    </div>
                    <div class="d-grid gap-2 col-md-2">
                        <button type="button" id="btnSearchParent" class="btn bg-gradient-dark">Buscar Responsável</button>
                    </div>
                    <div id="boxBtnNewParent" class="d-grid gap-2 col-md-2 d-none">
                        <a href="<?php echo route_to('parents.new') ?>" id="btnNewParent" class="btn btn-success">Cadastrar Responsável</a>
                    </div>
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive">
                    <table id="table" class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-secondary text-xxs font-weight-bolder opacity-7">Ações</th>
                                <th class="text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nome</th>
                                <th class="text-secondary text-xxs font-weight-bolder opacity-7 ps-2">E-mail</th>
                                <th class="text-secondary text-xxs font-weight-bolder opacity-7 ps-2">CPF</th>
                                <th class="text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Telefone</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td class="align-middle pb-0">
                                        <a class="btn btn-sm bg-gradient-info" href="<?php echo route_to('students.show', $student->code); ?>">Detelhes</a>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-0" text-sm><?php echo $student->name; ?></h6>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-0" text-sm><?php echo $student->email; ?></h6>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-0" text-sm><?php echo $student->cpf; ?></h6>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-0" text-sm><?php echo $student->phone; ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>

<script>
    // buscamos o responsável quando preenchido o campo de cpf e renderizamos a view para criação de novo aluno
    document.addEventListener("DOMContentLoaded", function() {
        const cpfInput = document.getElementById("cpf");
        const btnSearchParent = document.getElementById("btnSearchParent");
        const boxBtnNewParent = document.getElementById("boxBtnNewParent");

        btnSearchParent.addEventListener("click", function() {

            // ocultamos o botão para criar o responsável
            boxBtnNewParent.className = 'd-none';

            const cpf = cpfInput.value;

            if (!cpf) {

                return;
            }

            btnSearchParent.disabled = true;
            btnSearchParent.textContent = "Aguarde...";

            // podemos buscar o responsável...

            const url = `<?php echo route_to('api.fetch.parent.by.cpf') ?>?cpf=${cpf}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {

                    btnSearchParent.disabled = false;
                    btnSearchParent.textContent = "Buscar Responsável";

                    if (data.parent === null) {

                        // exibimos o botão para criar o responsável
                        boxBtnNewParent.className = 'd-block';

                        Toastify({
                            text: "Responsável não encontrado",
                            duration: 10000,
                            close: true,
                            gravity: "top",
                            position: "left",
                        }).showToast();

                        return;

                    }

                    const parentCode = data.parent.code;

                    window.location.href = '<?php echo route_to('students.new'); ?>?parent_code=' + parentCode;
                })
                .catch(error => {
                    console.error('Erro ao enviar requisição:', error);

                    Toastify({
                        text: "Erro ao buscar responsável",
                        duration: 10000, // um pouco maior a duração
                        close: true,
                        gravity: "bottom",
                        position: "right",
                        backgroundColor: "#dc3545",
                    }).showToast();
                });
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>

<script src="<?php echo base_url('assets/mask/jquery.mask.min.js') ?>"></script>
<script src="<?php echo base_url('assets/mask/app.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/bootstrap-table.min.js"></script>

<script>
    $('#table').bootstrapTable({
        search: true,
        pagination: true,
        pageSize: 20,
        paginationHAlign: 'left',
        paginationParts: ['pageList'],
        columns: [{
                field: 'actions',
                title: 'Ações',
                sortable: false,

            },
            {
                field: 'name',
                title: 'Nome',
                sortable: true,

            },
            {
                field: 'email',
                title: 'E-mail',
                sortable: true,
            },
            {
                field: 'cpf',
                title: 'CPF',
                sortable: true,
            },
            {
                field: 'phone',
                title: 'Telefone',
                sortable: true,
            },



        ]
    })
</script>

<?= $this->endSection() ?>