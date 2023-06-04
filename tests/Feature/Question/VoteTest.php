<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

it('should be able to like a question', function () {

    $user = User::factory()->create();

    actingAs($user);

    $question = Question::factory()->create();

    $response = post(route('question.like', ['question' => $question]))
        ->assertRedirect();

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
        'user_id'     => $user->id,
    ]);
});

it('should not be able to like more than 1 time', function () {

    $user = User::factory()->create();

    actingAs($user);

    $question = Question::factory()->create();

    post(route('question.like', ['question' => $question]));
    post(route('question.like', ['question' => $question]));
    post(route('question.like', ['question' => $question]));
    post(route('question.like', ['question' => $question]));

    expect($user->votes()->where('question_id', $question->id)->get())
        ->toHaveCount(1);
});

it('should be able one unlike question', function () {
    $user = User::factory()->create();

    actingAs($user);

    $question = Question::factory()->create();

    post(route('question.unlike', ['question' => $question]))
        ->assertRedirect();

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 0,
        'unlike'      => 1,
        'user_id'     => $user->id,
    ]);
});

it('should be able to like a question twice', function () {
    $user = User::factory()->create();

    actingAs($user);

    $question = Question::factory()->create();

    $response = post(route('question.like', ['question' => $question]))
        ->assertRedirect();

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
        'user_id'     => $user->id,
    ]);

    $response = post(route('question.like', ['question' => $question]))
        ->assertRedirect();
});
