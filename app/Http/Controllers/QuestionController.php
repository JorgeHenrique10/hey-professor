<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    public function index(): View
    {
        return view(
            'question.index',
            [
                'questions' => user()->questions,
            ]
        );
    }

    public function store(): RedirectResponse
    {
        request()->validate(
            [
                'question' => ['required', 'min:10', 'ends_with:?'],
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
        $question->question = request()->question;
        $question->save();

        return back();
    }

    public function destroy(Question $question): RedirectResponse
    {

        $this->authorize('destroy', $question);

        $question->delete();

        return back();
    }
}
