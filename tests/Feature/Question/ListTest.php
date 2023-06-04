<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {

    $user = User::factory()->create();

    actingAs($user);

    $questions = Question::factory(10)->create();

    $response = get(route('dashboard'));

    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }
});
it('should list questions paginate', function () {

    $user = User::factory()->create();

    actingAs($user);

    $questions = Question::factory(20)->create();

    $response = get(route('dashboard'));

    $response->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);
});
