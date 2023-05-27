<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\{RedirectResponse, Request, Response};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {
        request()->validate(
            [
                'question' => ['required', 'min:10', 'ends_with:?'],
            ]
        );
        Question::query()->create([
            'question' => request('question'),
            'draft'    => true,
        ]);

        return to_route('dashboard');
    }
}
