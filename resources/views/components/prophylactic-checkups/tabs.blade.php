<div>

    <div class="inline-block overflow-hidden min-w-full mt-2 px-2 bg-gray-300">
        <table class="min-w-full leading-normal">
            <tbody>
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-900">
                        ЕГН/ЛНЧ: {{ $worker->id_number }}
                    </td>
                    <td class="px-4 py-2 text-sm text-gray-900">
                        Възраст: {{ $worker->birth_date->age }} г. (в момента)
                    </td>
                    @if(0 < $prophylacticCheckupId)
                        <td class="px-4 py-2 text-sm text-gray-900">
                            Възраст: {{ $worker->birth_date->diffInYears($prophylacticCheckup->checkup_date) }} г.
                            (към датата на прегледа)
                        </td>
                    @endif
                    <td class="px-4 py-2 text-sm text-gray-900">
                        {{ $worker->firmStructure->firmPosition->name ?? '' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="px-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <x-shared.tab-item :href="route('firms.workers.index', ['firm' => $firmId])">
                    <x-app.icon-back/>
                    Назад
                </x-shared.tab-item>
                @if(0 === $prophylacticCheckupId)
                    <x-shared.tab-item
                            :href="route('prophylactic-checkups.create', ['firm' => $firmId, 'worker' => $workerId])"
                            :is_active="\Illuminate\Support\Facades\Route::currentRouteName() === 'prophylactic-checkups.create'"
                    >
                        Нов преглед
                    </x-shared.tab-item>
                @else
                    <x-shared.tab-item
                            :href="route('prophylactic-checkups.edit', ['firm' => $firmId, 'worker' => $workerId, 'prophylactic_checkup' => $prophylacticCheckupId])"
                            :is_active="'checkup1' === $tab"
                    >
                        1 - преглед
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            :href="route('prophylactic-checkups.edit', ['firm' => $firmId, 'worker' => $workerId, 'prophylactic_checkup' => $prophylacticCheckupId, 'tab' => 'checkup2'])"
                            :is_active="'checkup2' === $tab"
                    >
                        2 - преглед
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            :href="route('prophylactic-checkups.edit', ['firm' => $firmId, 'worker' => $workerId, 'prophylactic_checkup' => $prophylacticCheckupId, 'tab' => 'family-anamnesis'])"
                            :is_active="'family-anamnesis' === $tab"
                    >
                        фам. заб.
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            :href="route('prophylactic-checkups.edit', ['firm' => $firmId, 'worker' => $workerId, 'prophylactic_checkup' => $prophylacticCheckupId, 'tab' => 'anamnesis'])"
                            :is_active="'anamnesis' === $tab"
                    >
                        анамнеза
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            :href="route('prophylactic-checkups.edit', ['firm' => $firmId, 'worker' => $workerId, 'prophylactic_checkup' => $prophylacticCheckupId, 'tab' => 'laboratory-research'])"
                            :is_active="'laboratory-research' === $tab"
                    >
                        изследвания
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            :href="route('prophylactic-checkups.edit', ['firm' => $firmId, 'worker' => $workerId, 'prophylactic_checkup' => $prophylacticCheckupId, 'tab' => 'diagnoses'])"
                            :is_active="'diagnoses' === $tab"
                    >
                        диагнози
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            :href="route('prophylactic-checkups.edit', ['firm' => $firmId, 'worker' => $workerId, 'prophylactic_checkup' => $prophylacticCheckupId, 'tab' => 'medical-opinions'])"
                            :is_active="'medical-opinions' === $tab"
                    >
                        заключение
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            :href="route('prophylactic-checkups.edit', ['firm' => $firmId, 'worker' => $workerId, 'prophylactic_checkup' => $prophylacticCheckupId, 'tab' => 'ohs-conclusions'])"
                            :is_active="'ohs-conclusions' === $tab"
                    >
                        заключение на СТМ
                    </x-shared.tab-item>
                @endif
            </nav>
        </div>
    </div>

    {{ $slot }}

</div>
