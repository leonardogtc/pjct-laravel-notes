<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // Load user's notes (Pega as notas do usuário)
        $id = session('user.id');

        /*
            Foi inserida a instrução ->whereNull('deleted_at') para que o sistema selecione
            somente as notas que não tiverem uma data de deleção preenchida.
            Essa alteração foi feita após inserir no método "deleteNoteConfirm" a técnica para
            soft delete (incluindo a data de deleção no banco de dados).
            Equivalência: SELECT * FROM notes WHERE deleted_at IS NULL;
        */
        $notes = User::find($id)->notes()->whereNull('deleted_at')->get()->toArray();

        // Mostrar a view 'home'
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {
        // Validar requisição
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            [
                'text_title.required' => 'O título da nota é obrigatório',
                'text_title.min' => 'O título deve ter no mínimo :min caracteres',
                'text_title.max' => 'O título pode ter no máximo :max caracteres',

                'text_note.required' => 'A descrição da nota é obrigatória',
                'text_note.min' => 'A nota deve ter no mínimo :min caracteres',
                'text_note.max' => 'A nota pode ter no máximo :max caracteres'

            ]
        );
        // Capturar o ID so usuário
        $id = session('user.id');

        // Criar uma nova nota
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // Redirecionar para home
        return redirect()->route('home');
    }

    public function editNote($id)
    {
        $id = Operations::decryptID($id);

        if($id === null) {
            return redirect()->route('home');
        }

        // Load Note (Ler os dados da nota)
        $note = Note::find($id);

        // Show edit note view (Mostrar nota editada)
        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        // Validate Request
        $request->validate(
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            [
                'text_title.required' => 'O título da nota é obrigatório',
                'text_title.min' => 'O título deve ter no mínimo :min caracteres',
                'text_title.max' => 'O título pode ter no máximo :max caracteres',

                'text_note.required' => 'A descrição da nota é obrigatória',
                'text_note.min' => 'A nota deve ter no mínimo :min caracteres',
                'text_note.max' => 'A nota pode ter no máximo :max caracteres'

            ]
        );

        // Check if note_id exists
        if ($request->note_id == null) {
            return redirect()->route('home');
        }

        // Decrypt note_id
        $id = Operations::decryptID($request->note_id);

        if($id === null) {
            return redirect()->route('home');
        }

        // load note
        $note = Note::find($id);

        // update note
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // Redirect to home
        return redirect()->route('home');
    }

    public function deleteNote($id)
    {
        $id = Operations::decryptID($id);

        if($id === null) {
            return redirect()->route('home');
        }

        // load note
        $note = Note::find($id);

        // Show delete note confirmation
        return view('delete_note', ['note' => $note]);
    }

    public function deleteNoteConfirm($id)
    {
        $id = Operations::decryptID($id);

        if($id === null) {
            return redirect()->route('home');
        }

        // Ler a nota
        $note = Note::find($id);

        // 1. Hard Delete (Remove o registro fisicamente do banco de dados)
        // $note->delete();

        // 2. Soft delete (Marca o regitro como deletado da base e o mantém)
        // $note->deleted_at = date('Y-m-d H:i:s');
        // $note->save();

        /*
            3. Soft delete com a chamada da classe SoftDeletes no model do Note
            Dessa forma ao executar o delete simplesmente atual como um softdelete.
        */

        // $note->delete();

        /*
            4. É possível remover a nota mesmo estando com Softdelete ativado, usando
            para isso forceDelete
        */

        $note->forceDelete();

        return redirect()->route('home');
    }
}
