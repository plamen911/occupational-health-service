<div class="px-4">

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
                        wire:click.prevent="addWorker({{ $firm->id }})"
                        wire:loading.attr="disabled"
                        class="w-full"
                >
                    Добави работещ
                </x-primary-button>
            </div>
        </div>
    </div>

    <div class="inline-block overflow-hidden min-w-full rounded-lg shadow">
        <x-app.table>
            <x-slot:header>
                <x-app.table-th>
                    <div class="flex items-center">
                        <a href="#" wire:click.prevent="sortBy('workers.first_name')">
                            Имена
                        </a>
                        <x-app.sort-icon
                                sortField="workers.first_name"
                                :sort-by="$sortBy"
                                :sort-asc="$sortAsc"
                        />
                    </div>
                </x-app.table-th>
                <x-app.table-th>
                    <div class="flex items-center">
                        <a href="#" wire:click.prevent="sortBy('workers.id_number')">
                            ЕГН
                        </a>
                        <x-app.sort-icon
                                sortField="workers.id_number"
                                :sort-by="$sortBy"
                                :sort-asc="$sortAsc"
                        />
                    </div>
                </x-app.table-th>
                <x-app.table-th>
                    <div class="flex items-center">
                        <a href="#" wire:click.prevent="sortBy('workers.firm_position_name')">
                            Длъжност
                        </a>
                        <x-app.sort-icon
                                sortField="workers.firm_position_name"
                                :sort-by="$sortBy"
                                :sort-asc="$sortAsc"
                        />
                    </div>
                </x-app.table-th>
                <x-app.table-th>
                    Профилакт. <br/>прегледи
                </x-app.table-th>
                <x-app.table-th>
                    Бол- <br/>нични
                </x-app.table-th>
                <x-app.table-th>
                    &nbsp;
                </x-app.table-th>
            </x-slot:header>
            @foreach($workers as $worker)
                <tr>
                    <x-app.table-column>
                        <x-app.link href="{{ route('firms.workers.edit', ['firm' => $worker->firm_id, 'worker' => $worker->id]) }}">
                            {{ $worker->first_name }} {{ $worker->second_name }} {{ $worker->last_name }}
                        </x-app.link>
                    </x-app.table-column>
                    <x-app.table-column>
                        {{ $worker->id_number }}
                    </x-app.table-column>
                    <x-app.table-column>
                        {{ $worker->firmStructure->firmPosition->name ?? '' }}
                    </x-app.table-column>
                    <x-app.table-column class="text-center">
                        <x-app.link href="{{ route('prophylactic-checkups.index', ['firm' => $worker->firm_id, 'worker' => $worker->id]) }}">
                            <x-app.badge>
                                {{ $worker->prophylactic_checkups_count }}
                            </x-app.badge>
                        </x-app.link>
                    </x-app.table-column>
                    <x-app.table-column class="text-center">
                        <x-app.link href="{{ route('patient-charts.index', ['firm' => $worker->firm_id, 'worker' => $worker->id]) }}">
                            <x-app.badge>
                                {{ $worker->patient_charts_count }}
                            </x-app.badge>
                        </x-app.link>
                    </x-app.table-column>

                    <x-app.table-column class="px-0 py-0">
                        <button type="submit"
                                wire:click="confirmDelete({{ $worker->id }})"
                                wire:loading.attr="disabled"
                                class="text-red-600">
                            <x-app.icon-delete/>
                        </button>
                    </x-app.table-column>
                </tr>
            @endforeach
        </x-app.table>

        @if($workers->hasMorePages())
            <div class="flex flex-col items-center px-5 py-5 bg-white border-t xs:flex-row xs:justify-between">
                {{ $workers->links() }}
            </div>
        @endif
    </div>
</div>
