<x-app-layout>

    <x-header> {{ __('Edit Question' . '::' . $question->id) }}</x-header>

    <x-container>

        <x-form put :action="route('question.update', $question)">

            <x-inputs.textarea label='Question' name='question' :value="$question->question" />

            <x-btn.primary type='submit'> Enviar </x-btn.primary>
            <x-btn.alternative type='reset'> Cancel </x-btn.alternative>

        </x-form>
    </x-container>
</x-app-layout>
