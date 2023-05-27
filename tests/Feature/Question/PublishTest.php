<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('should be able alter question draft to true', function () {
    $user = User::factory()->create();

    actingAs($user);

    $question = Question::factory()->create(['draft' => true]);

    $request = put(route('question.publish', $question))
        ->assertRedirect();

    $question->refresh();

    expect($question->draft)->toBeFalse();
});
