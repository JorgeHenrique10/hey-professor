<x-app-layout>

    <x-header> {{ __('Dashboard') }}</x-header>

    <x-container>
        <x-form post :action="route('question.store')">

            <x-inputs.textarea label='Question' name='question' />

            <x-btn.primary type='submit'> Enviar </x-btn.primary>
            <x-btn.alternative type='reset'> Cancel </x-btn.alternative>

        </x-form>
    </x-container>
</x-app-layout>
