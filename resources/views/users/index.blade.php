<x-app-layout>
    <x-slot name="header">
        {{ __('Users') }}
    </x-slot>

    <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
        <x-app.table>
            <x-slot:header>
                <x-app.table-th>
                    {{ __('Name') }}
                </x-app.table-th>
                <x-app.table-th>
                    {{ __('Email') }}
                </x-app.table-th>
            </x-slot:header>
            @foreach($users as $user)
                <tr>
                    <x-app.table-column>
                        <p class="text-gray-900 whitespace-no-wrap">{{ $user->name }}</p>
                    </x-app.table-column>
                    <x-app.table-column>
                        <p class="text-gray-900 whitespace-no-wrap">{{ $user->email }}</p>
                    </x-app.table-column>
                </tr>
            @endforeach
        </x-app.table>

        @if($users->hasMorePages())
            <div class="flex flex-col items-center px-5 py-5 bg-white border-t xs:flex-row xs:justify-between">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</x-app-layout>
