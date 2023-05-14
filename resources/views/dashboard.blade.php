<x-app-layout>

    <x-header> {{ __('Dashboard') }}</x-header>

    <x-container>
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

            @foreach ($questions as $q)
                <x-question :question="$q->question" />
            @endforeach

        </div>

        {{-- End Listagem --}}
    </x-container>
</x-app-layout>
