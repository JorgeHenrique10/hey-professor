<x-app-layout>

    <x-header> {{ 'My Questions' }}</x-header>

    <x-container>

        {{-- Listagem --}}

        <div class=" space-y-3">
            <div class="dark:text-gray-400 text-xl font-bold uppercase">
                List Of Questions
            </div>

            @foreach ($questions as $q)
                <x-question :question="$q" />
            @endforeach

        </div>

        {{-- End Listagem --}}
    </x-container>
</x-app-layout>
