<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\SameQuestionRule;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    public function index(): View
    {
        return view(
            'question.index',
            [
                'questions'         => user()->questions,
                'questionsArchived' => user()->questions()->onlyTrashed()->get(),
            ]
        );
    }

    public function store(): RedirectResponse
    {
        request()->validate(
            [
                'question' => ['required', 'min:10', 'ends_with:?', new SameQuestionRule()],
            ]
        );
        Question::query()->create([
            'question'   => request('question'),
            'created_by' => user()->id,
            'draft'      => true,
        ]);

        return back();
    }

    public function edit(Question $question): View
    {
        $this->authorize('update', $question);

        return view('question.edit', compact('question'));
    }

    public function update(Question $question): RedirectResponse
    {
        $this->authorize('update', $question);

        request()->validate(
            [
                'question' => ['required', 'min:10', 'ends_with:?'],
            ]
        );

        $question->question = request()->question;
        $question->save();

        return to_route('question.index');
    }

    public function destroy(Question $question): RedirectResponse
    {

        $this->authorize('destroy', $question);

        $question->forceDelete();

        return back();
    }
    public function restore(int $id): RedirectResponse
    {
        $question = Question::withTrashed()->find($id);

        $this->authorize('restore', $question);

        $question->restore();

        return back();
    }

    public function archive(Question $question): RedirectResponse
    {
        $this->authorize('archive', $question);

        $question->delete();

        return back();
    }
}
