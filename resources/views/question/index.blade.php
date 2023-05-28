<x-app-layout>

    <x-header> {{ 'My Questions' }}</x-header>

    <x-container>

        <x-form post :action="route('question.store')">

            <x-inputs.textarea label='Question' name='question' />

            <x-btn.primary type='submit'> Enviar </x-btn.primary>
            <x-btn.alternative type='reset'> Cancel </x-btn.alternative>

        </x-form>
        {{-- Listagem --}}


        <div class=" space-y-3">

            <div>
                <div class="dark:border-gray-400 border border-dashed w-full mt-10 mb-4 "></div>
                <div class="dark:text-gray-400 uppercase font-bold text-xl">
                    Drafts
                </div>
                <x-table.table>
                    <x-table.thead>
                        <x-table.th>
                            Question
                        </x-table.th>
                        <x-table.th>
                            Actions
                        </x-table.th>
                    </x-table.thead>
                    <tbody>
                        @foreach ($questions->where('draft', true) as $q)
                            <x-table.tr>
                                <x-table.td>
                                    {{ $q->question }}
                                </x-table.td>
                                <x-table.td>
                                    <x-form put :action="route('question.publish', $q)">
                                        <button class=" text-blue-600 hover:underline" type="submit">
                                            Publicar
                                        </button>
                                    </x-form>
                                    <x-form delete :action="route('question.destroy', $q)">
                                        <button class=" text-blue-600 hover:underline hover:text-red-600" type="submit">
                                            Deletar
                                        </button>
                                    </x-form>
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </tbody>
                </x-table.table>
            </div>

            <div>
                <div class="dark:border-gray-400 border border-dashed w-full mt-10 mb-4 "></div>
                <div class="dark:text-gray-400 uppercase font-bold text-xl">
                    Questions
                </div>
                <x-table.table>
                    <x-table.thead>
                        <x-table.th>
                            Question
                        </x-table.th>
                        <x-table.th>
                            Actions
                        </x-table.th>
                    </x-table.thead>
                    <tbody>
                        @foreach ($questions->where('draft', false) as $q)
                            <x-table.tr>
                                <x-table.td>
                                    {{ $q->question }}
                                </x-table.td>
                                <x-table.td>
                                    <x-form delete :action="route('question.destroy', $q)">
                                        <button class=" text-blue-600 hover:underline hover:text-red-600" type="submit">
                                            Deletar
                                        </button>
                                    </x-form>
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </tbody>
                </x-table.table>
            </div>

        </div>

        {{-- End Listagem --}}
    </x-container>
</x-app-layout>
