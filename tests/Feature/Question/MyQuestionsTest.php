<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('should be able to list only my questions', function () {
    $user = User::factory()->create();

    $question = Question::factory()
        ->for($user, 'createdBy')
        ->count(10)
        ->create();

    $wrongUser = User::factory()->create();
    $question2 = Question::factory()
        ->for($wrongUser, 'createdBy')
        ->count(10)
        ->create();

    actingAs($user);

    $response = get(route('question.index'));

    foreach ($question as $q) {
        $response->assertSee($q->question);
    }

    foreach ($question2 as $q) {
        $response->assertDontSee($q->question);
    }
});
