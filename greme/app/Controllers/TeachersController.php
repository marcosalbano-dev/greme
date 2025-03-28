<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Address;
use App\Entities\Teacher;
use App\Models\TeacherModel;
use CodeIgniter\HTTP\RedirectResponse;
use App\Validation\AddressValidation;
use App\Validation\TeacherValidation;

class TeachersController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Teachers/';

    private TeacherModel $teacherModel;

    public function __construct()       
    {
        $this->teacherModel = model(TeacherModel::class);
    }

    public function index(): string
    {
        $this->dataToView['title'] = 'Gerenciar os professores';
        $this->dataToView['teachers'] = $this->teacherModel->orderBy('name', 'ASC')->findAll();

        return view(self::VIEWS_DIRECTORY . 'index', $this->dataToView);
    }

    public function new(): string
    {
        $this->dataToView['title'] = 'Novo professor';
        $this->dataToView['teacher'] = new Teacher([
            'address' => new Address()
        ]);

        return view(self::VIEWS_DIRECTORY . 'new', $this->dataToView);
    }

    public function create(): RedirectResponse
    {
        // Validar os dados do responsável
        $rules = (new TeacherValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Instanciamos o responsável com os dados validados
        $teacher = new Teacher($this->validator->getValidated());

        // Validar os dados do endereço
        $rules = (new AddressValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Instanciamos o endereço com os dados validados
        $address = new Address(($this->validator->getValidated()));


        $success = $this->teacherModel->store(teacher: $teacher, address: $address);

        if (!$success) {

            return redirect()
                ->back()
                ->with('danger', 'Ocorreu um erro na criação do responsável');
        }

        return redirect()->route('teachers')->with('success', 'Sucesso!');
    }

    public function show(string $code): string
    {
        $teacher = $this->teacherModel->getByCode(code: $code, withAddress: true);

        $this->dataToView['title'] = 'Detalhes do Professor';
        $this->dataToView['teacher'] = $teacher;

        return view(self::VIEWS_DIRECTORY . 'show', $this->dataToView);
    }

    public function edit(string $code): string
    {
        $teacher = $this->teacherModel->getByCode(code: $code, withAddress: true);

        $this->dataToView['title'] = 'Editar o Professor';
        $this->dataToView['teacher'] = $teacher;

        return view(self::VIEWS_DIRECTORY . 'edit', $this->dataToView);
    }

    public function update(string $code): RedirectResponse
    {

        $teacher = $this->teacherModel->getByCode(code: $code, withAddress: true);

        // Validar os dados do responsável
        $rules = (new TeacherValidation)->getRules($teacher->id);

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Instanciamos o professor com os dados validados
        $teacher->fill($this->validator->getValidated());

        // Validar os dados do endereço
        $rules = (new AddressValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Recuperamos o endereço associado
        $address = $teacher->address;

        $address->fill($this->validator->getValidated());

        $success = $this->teacherModel->store(teacher: $teacher, address: $address);

        if (!$success) {

            return redirect()
                ->back()
                ->with('danger', 'Ocorreu um erro na atualização do responsável');
        }

        return redirect()->route('teachers.show', [$teacher->code])->with('success', 'Sucesso!');
    }

    public function destroy(string $code): RedirectResponse
    {

        $teacher = $this->teacherModel->getByCode(code: $code);

        $success = $this->teacherModel->destroy($teacher);

        if (!$success) {

            return redirect()
                ->back()
                ->with('danger', 'Ocorreu um erro na exclusão do responsável');
        }

        return redirect()->route('teachers')->with('success', 'Sucesso!');
    }
}
