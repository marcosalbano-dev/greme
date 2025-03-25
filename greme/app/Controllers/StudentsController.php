<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Student;
use App\Models\ParentModel;
use App\Models\StudentModel;
use App\Validation\StudentValidation;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class StudentsController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Students/';

    private StudentModel $studentModel;

    public function __construct()
    {
        $this->studentModel = model(StudentModel::class);
    }

    public function index(): string
    {
        $this->dataToView['title'] = 'Gerenciar os alunos';
        $this->dataToView['students'] = $this->studentModel->orderBy('name', 'ASC')->findAll();

        //dd($this->dataToView['parents']);

        return view(self::VIEWS_DIRECTORY . 'index', $this->dataToView);
    }

    public function new(): string
    {

        $parentCode = esc($this->request->getGet('parent_code'));

        // Buscamos o responsável
        $parent = model(ParentModel::class)->getByCode(code: $parentCode);

        $this->dataToView['title'] = 'Novo aluno';
        $this->dataToView['student'] = new Student([
            'parent' => $parent
        ]);

        return view(self::VIEWS_DIRECTORY . 'new', $this->dataToView);
    }

    public function create(): RedirectResponse
    {
        // Validar os dados do aluno
        $rules = (new StudentValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }


        // Recuperamos o campo escondido do form referente ao código do responsável
        $parentCode = $this->request->getPost('parent_code');

        // Buscamos o responsável
        $parent = model(ParentModel::class)->getByCode(code: $parentCode);

        // Instanciamos o aluno com os dados validados
        $student = new Student($this->validator->getValidated());
        $student->parent_id = $parent->id;

        $success = $this->studentModel->save($student);

        if (!$success) {

            return redirect()
                ->back()
                ->with('danger', 'Ocorreu um erro na criação do aluno');
        }

        $createdStudent = $this->studentModel->find($this->studentModel->getInsertID());

        return redirect()->route('students.show', [$createdStudent->code])->with('success', 'Sucesso!');
    }

    public function show(string $code)
    {

        // Buscamos o aluno com o responsável
        $student = $this->studentModel->getByCode(code: $code, withParent: true);

        $this->dataToView['title'] = 'Detalhes do aluno';
        $this->dataToView['student'] = $student;

        return view(self::VIEWS_DIRECTORY . 'show', $this->dataToView);
    }

    public function edit(string $code)
    {

        // Buscamos o aluno com o responsável
        $student = $this->studentModel->getByCode(code: $code, withParent: true);

        $this->dataToView['title'] = 'Editar o aluno';
        $this->dataToView['student'] = $student;

        return view(self::VIEWS_DIRECTORY . 'edit', $this->dataToView);
    }

    public function update(string $code): RedirectResponse
    {

        $student = $this->studentModel->getByCode(code: $code);

        // Validar os dados do aluno
        $rules = (new StudentValidation)->getRules($student->id);

        if (!$this->validate($rules)) {

            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Populamos as propriedades do aluno com os dados validados
        $student->fill($this->validator->getValidated());

        $success = $this->studentModel->save($student);

        if (!$success) {

            return redirect()->back()->with('danger', 'Ocorreu um erro na atualização do aluno');
        }

        return redirect()->route('students.show', [$student->code])->with('success', 'Sucesso!');
    }

    public function destroy(string $code): RedirectResponse
    {

        $student = $this->studentModel->getByCode(code: $code);

        $success = $this->studentModel->delete($student);

        return redirect()->route('students')->with('success', 'Sucesso!');
    }
}
