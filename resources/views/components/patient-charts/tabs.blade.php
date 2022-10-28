<div class="bg-white rounded-t">
    <div class="px-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <x-shared.tab-item :href="route('firms.workers.index', ['firm' => $firmId])">
                    <x-app.icon-back/> Назад
                </x-shared.tab-item>
                <x-shared.tab-item
                        :href="route('patient-charts.index', ['firm' => $firmId, 'worker' => $workerId])"
                        :is_active="\Illuminate\Support\Facades\Route::currentRouteName() === 'patient-charts.index'"
                >
                    Болнични листове
                </x-shared.tab-item>
            </nav>
        </div>
    </div>
    {{ $slot }}
</div>
