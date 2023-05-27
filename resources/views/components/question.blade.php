@props(['question'])
<div class="rounded dark:text-gray-400 text-lg shadow dark:shadow-blue-800 p-3 flex justify-between items-center">
    <span>{{ $question->question }}</span>

    <div class="flex flex-col">
        <x-form :action="route('question.like', $question)">
            <button class="flex">
                <x-icons.thumbs-up class="w-5 m-1 text-green-500 fill-green-500 hover:fill-green-300" />
                <span class=" text-green-500">{{ $question->votes_sum_like ?? 0 }}</span>
            </button>
        </x-form>
        <x-form :action="route('question.unlike', $question)" class="flex flex-row">
            <button class="flex">
                <x-icons.thumbs-down class="w-5 m-1 text-red-500 fill-red-500 hover:fill-red-300" />
                <span class="text-red-500">{{ $question->votes_sum_unlike ?? 0 }}</span>
            </button>
        </x-form>
    </div>
</div>
