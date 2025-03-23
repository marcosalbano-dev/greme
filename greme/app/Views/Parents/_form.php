<div class="row">

    <h6>Dados Pessoais</h6>

    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Nome" name="name" value="<?php echo old('name', $parent->name); ?>" id="name">
            <label for="name">Nome</label>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="email" class="form-control" placeholder="E-mail" name="email" value="<?php echo old('email', $parent->email); ?>" id="email">
            <label for="email">E-mail</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="tel" class="form-control phone" placeholder="Telefone" name="phone" value="<?php echo old('phone', $parent->phone); ?>" id="phone">
            <label for="phone">Telefone</label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="cpf" class="form-control cpf" placeholder="CPF" name="cpf" value="<?php echo old('cpf', $parent->cpf); ?>" id="cpf">
            <label for="cpf">CPF</label>
        </div>
    </div>
</div>

<div class="row mt-4">

    <h6>Dados de Endereço</h6>

    <div class="col-md-2">
        <div class="form-floating mb-3">
            <input type="text" class="form-control cep" placeholder="CEP" name="postalcode" value="<?php echo old('postalcode', $parent->address->postalcode); ?>" id="postalcode">
            <label for="postalcode">CEP</label>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Rua" name="street" value="<?php echo old('street', $parent->address->street); ?>" id="street">
            <label for="street">Rua</label>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Número" name="number" value="<?php echo old('number', $parent->address->number); ?>" id="number">
            <label for="number">Número</label>
        </div>
    </div>

    <div class="col-md">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Cidade" name="city" value="<?php echo old('city', $parent->address->city); ?>" id="city">
            <label for="city">Cidade</label>
        </div>
    </div>

    <div class="col-md">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Bairro" name="district" value="<?php echo old('district', $parent->address->district); ?>" id="district">
            <label for="district">Bairro</label>
        </div>
    </div>

    <div class="col-md">
        <div class="form-floating mb-3">
            <input type="text" class="form-control uf" placeholder="Estado" name="state" value="<?php echo old('state', $parent->address->state); ?>" id="state">
            <label for="state">Estado</label>
        </div>
    </div>

    <div class="row mt-3">

        <div class="col-md-12">

            <button type="submit" class="btn bg-gradient-dark">Salvar</button>

        </div>

    </div>

</div>



<?= $this->section('js') ?>

<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>


<script src="<?php echo base_url('assets/mask/jquery.mask.min.js') ?>"></script>
<script src="<?php echo base_url('assets/mask/app.js') ?>"></script>

<script>
    document.getElementById('postalcode').addEventListener('change', function() {

        const postalcode = this.value;

        fetch(`https://viacep.com.br/ws/${postalcode}/json/`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('street').value = data.logradouro ?? '';
                document.getElementById('district').value = data.bairro ?? '';
                document.getElementById('city').value = data.localidade ?? '';
                document.getElementById('state').value = data.uf ?? '';
            })
            .catch(error => {
                console.log(`Erro ao consultar o CEP: ${erro}`);
            });
    });
</script>

<?= $this->endSection() ?>