<div>

    <div class="my-4">
        <div class="flex justify-between">
            <div class="flex">
                <x-app.input
                        type="search"
                        wire:model.debounce.500ms="q"
                        class="ml-1 w-48"
                        placeholder="{{ __('Search') }}"
                />
                <span class="ml-3 mt-2" wire:loading.delay wire:target="q">
                <x-app.loading-indicator/>
            </span>
            </div>
            <div class="flex space-x-3 items-center">
                <x-app.select class="block w-24" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </x-app.select>
                <x-primary-button
                        wire:click.prevent="addFirm"
                        wire:loading.attr="disabled"
                        class="w-full"
                >
                    Добави фирма
                </x-primary-button>
            </div>
        </div>
    </div>

    <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
        <x-app.table>
            <x-slot:header>
                <x-app.table-th>
                    <div class="flex items-center">
                        <a href="#" wire:click.prevent="sortBy('firms.name')">
                            Наименование
                        </a>
                        <x-app.sort-icon
                                sortField="firms.name"
                                :sort-by="$sortBy"
                                :sort-asc="$sortAsc"
                        />
                    </div>
                </x-app.table-th>
                <x-app.table-th>
                    <div class="flex items-center">
                        <a href="#" wire:click.prevent="sortBy('firms.address')">
                            Адрес
                        </a>
                        <x-app.sort-icon
                                sortField="firms.address"
                                :sort-by="$sortBy"
                                :sort-asc="$sortAsc"
                        />
                    </div>
                </x-app.table-th>
                <x-app.table-th>
                    Брой работещи
                </x-app.table-th>
                <x-app.table-th>
                    Списък <br/>работещи
                </x-app.table-th>
                <x-app.table-th>
                    Анализ здравно <br/>състояние
                </x-app.table-th>
                <x-app.table-th>
                    &nbsp;
                </x-app.table-th>
            </x-slot:header>
            @foreach($firms as $firm)
                <tr>
                    <x-app.table-column>
                        <x-app.link href="{{ route('firms.workers.index', $firm->id) }}">
                            {{ $firm->name }}
                        </x-app.link>
                    </x-app.table-column>
                    <x-app.table-column>
                        {{ $firm->address }}
                    </x-app.table-column>
                    <x-app.table-column class="text-center">
                        <x-app.badge>
                            {{ $firm->workers_count }}
                        </x-app.badge>
                    </x-app.table-column>
                    <x-app.table-column>
                        ---
                    </x-app.table-column>
                    <x-app.table-column>
                        ---
                    </x-app.table-column>
                    <x-app.table-column class="px-0 py-0">
                        <button type="submit"
                                wire:click="confirmDelete({{ $firm->id }})"
                                wire:loading.attr="disabled"
                                class="text-red-600">
                            <x-app.icon-delete/>
                        </button>
                    </x-app.table-column>
                </tr>
            @endforeach
        </x-app.table>

        @if($firms->hasMorePages())
            <div class="flex flex-col items-center px-5 py-5 bg-white border-t xs:flex-row xs:justify-between">
                {{ $firms->links() }}
            </div>
        @endif
    </div>
</div>
