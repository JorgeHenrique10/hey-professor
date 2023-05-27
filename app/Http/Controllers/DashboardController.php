<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        $questions = Question::query()
            ->withSum('votes', 'like')
            ->withSum('votes', 'unlike')
            ->get();

        return view('dashboard', [
            'questions' => $questions,
        ]);
    }
}
