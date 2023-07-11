<x-app-layout>

    <x-header> {{ __('Dashboard') }}</x-header>

    <x-container>

        <div class="flex w-full mb-10">
            <form method="get" :action="route('dashboard')" class="flex justify-center content-center w-full space-x-2">
                @csrf
                <x-text-input class=" border p-2" name="search" :value="request('search')" class="w-full border p-2" />
                <x-btn.primary type='submit'>Search</x-btn.primary>
            </form>
        </div>

        <x-form post :action="route('question.store')">

            <x-inputs.textarea label='Question' name='question' />

            <x-btn.primary type='submit'> Enviar </x-btn.primary>
            <x-btn.alternative type='reset'> Cancel </x-btn.alternative>

        </x-form>

        <hr class="border-gray-700 border-dashed my-4">

        {{-- Listagem --}}

        <div class=" space-y-3">
            <div class="dark:text-gray-400 text-xl font-bold uppercase">
                List Of Questions
            </div>

            @if ($questions->isEmpty())
                <div class="flex flex-col items-center justify-center">
                    <div class="dark:text-gray-300 font-bold text-xl">
                        Question not found!
                    </div>
                    <div class="flex w-96">
                        <x-draw.notFound></x-draw.notFound>
                    </div>
                </div>
            @else
                @foreach ($questions as $q)
                    <x-question :question="$q" />
                @endforeach
            @endif

            {{ $questions->links() }}
        </div>
        {{-- End Listagem --}}
    </x-container>
</x-app-layout>
