<?php

use App\Models\{Question, User};
use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions', function () {

    $user = User::factory()->create();

    actingAs($user);

    $questions = Question::factory(5)->create();

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

it('should ensure that the questions are sorted in descending order by link and ascending order by unlike', function () {
    $user  = User::factory()->create();
    $user2 = User::factory()->create();

    $questions = Question::factory()->count(5)->create();

    actingAs($user);

    $monstLikedQuestion   = $questions->find(3);
    $monstUnlikedQuestion = $questions->find(5);

    $user->like($monstLikedQuestion);
    $user2->unlike($monstUnlikedQuestion);

    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) {

            expect($questions)
                ->first()->id->toBe(3)
                ->and($questions)
                ->last()->id->toBe(5);

            return true;
        });
});
