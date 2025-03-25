<?php

namespace App\Validation;

use App\Traits\CPFValidationTrait;

class StudentValidation
{
    use CPFValidationTrait;

    public function getRules(?int $id = null): array
    {

        return [
            'id' => [

                'rules' => 'permit_empty|is_natural_no_zero'
            ],

            'name' => [

                'rules' => "required|max_length[128]",
                'errors' => [
                    'required' => 'Informe o nome completo',
                    'max_length' => 'O Nome não pode ter mais de 128 caracteres',
                ],
            ],

            'cpf' => [

                'rules' => "required|exact_length[14]|validaCPF|is_unique[students.cpf,id,{$id}]", // VALIDAR CPF
                'errors' => [
                    'required' => 'Informe o CPF válido',
                    'exact_length' => 'O CPF precisa ter exatamente 14 caracteres',
                    'is_unique' => 'Este CPF já existe',
                ],
            ],

            'email' => [

                'rules' => "required|max_length[128]|valid_email|is_unique[students.email,id,{$id}]",
                'errors' => [
                    'required' => 'Informe o email',
                ],
            ],

            'phone' => [

                'rules' => "required|max_length[128]|is_unique[students.phone,id,{$id}]",
                'errors' => [
                    'required' => 'Informe o telefone',
                ],
            ],
        ];
    }
}
