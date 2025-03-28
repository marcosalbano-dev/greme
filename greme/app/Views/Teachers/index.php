$teacher<?= $this->extend('Layouts/main') ?>

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
                <a href="<?php echo route_to('teachers.new') ?>" class="btn bg-gradient-dark mb-0"><i class="fas fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;Novo</a>
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

                            <?php foreach ($teachers as $teacher): ?>
                                <tr>
                                    <td class="align-middle pb-0">
                                        <a class="btn btn-sm bg-gradient-info" href="<?php echo route_to('teachers.show', $teacher->code); ?>">Detelhes</a>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-0"text-sm><?php echo $teacher->name; ?></h6>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-0"text-sm><?php echo $teacher->email; ?></h6>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-0"text-sm><?php echo $teacher->cpf; ?></h6>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex">
                                            <div>
                                                <h6 class="mb-0"text-sm><?php echo $teacher->phone; ?></h6>
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

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.24.1/dist/bootstrap-table.min.js"></script>

<script>
    $('#table').bootstrapTable({
        search: true,
        pagination: true,
        pageSize: 20,
        paginationHAlign: 'left',
        paginationParts: ['pageList'],
        columns: [
            {
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