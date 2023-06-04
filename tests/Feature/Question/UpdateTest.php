<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able to updated questions', function () {
    $user = User::factory()->create();

    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route(
        'question.update',
        $question
    ), [
        'question' => 'Update Question?',
    ]);

    $question->refresh();

    expect($question)
        ->question->toBe('Update Question?');
});
