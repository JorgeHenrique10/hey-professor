<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $questions = Question::query()
            ->when($request->has('search'), function (Builder $query) use ($request) {
                $query->where('question', 'like', "%$request->search%");
            })
            ->withSum('votes', 'like')
            ->withSum('votes', 'unlike')
            ->orderByRaw('case when votes_sum_like is null then 0 else votes_sum_like end desc,
                          case when votes_sum_unlike is null then 0 else votes_sum_unlike end asc')
            ->paginate(5)
            ->withQueryString();

        return view('dashboard', [
            'questions' => $questions,
        ]);
    }
}
