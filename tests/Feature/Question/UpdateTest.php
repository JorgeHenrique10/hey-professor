<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

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

it('should make sure that only wuestion with status DRAFT can be updated', function () {
    $user = User::factory()->create();

    $questionNotDraft = Question::factory()->for($user, 'createdBy')->create(['draft' => false]);
    $questionDraft    = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    put(route('question.update', $questionNotDraft), ['question' => 'New Question?'])->assertForbidden();
    put(route('question.update', $questionDraft), ['question' => 'New Question?'])->assertRedirect();
});

it('should make sure that only the person who has created the question can update the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    put(route('question.update', $question), ['question' => 'New Question?'])->assertForbidden();

    actingAs($rightUser);
    put(route('question.update', $question), ['question' => 'New Question?'])->assertRedirect();
});
it('should be able to update a new question bigger than 255 characters', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('should check if ends with question mark ?', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 10),
    ]);

    $request->assertSessionHasErrors(['question' => __('validation.ends_with', ['values' => '?', 'attribute' => 'question'])]);

    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});

it('should have at least 10 characters', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});
