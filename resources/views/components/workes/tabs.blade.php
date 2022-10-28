<div class="bg-white rounded-t">
    <div class="px-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <x-shared.tab-item :href="route('firms.workers.index', ['firm' => $firmId])">
                    <x-app.icon-back/> Назад
                </x-shared.tab-item>
                @if(0 === $workerId)
                    <x-shared.tab-item
                            :href="route('firms.workers.create', ['firm' => $firmId])"
                            :is_active="\Illuminate\Support\Facades\Route::currentRouteName() === 'firms.workers.create'"
                    >
                        Нов работещ
                    </x-shared.tab-item>
                @else
                    <x-shared.tab-item
                            :href="route('firms.workers.edit', ['firm' => $firmId, 'worker' => $workerId])"
                            :is_active="\Illuminate\Support\Facades\Route::currentRouteName() === 'firms.workers.edit'"
                    >
                        Данни за работещия
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            href="#"
                            :is_active="false"
                    >
                        Професионален маршрут
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            href="#"
                            :is_active="false"
                    >
                        Трудоустрояване
                    </x-shared.tab-item>
                @endif
            </nav>
        </div>
    </div>
    {{ $slot }}
</div>
