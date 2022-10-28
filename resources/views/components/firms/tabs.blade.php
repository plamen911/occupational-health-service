<div class="bg-white rounded-t">
    <div class="px-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <x-shared.tab-item :href="route('firms.index')">
                    <x-app.icon-back/> Списък фирми
                </x-shared.tab-item>
                @if(0 === $firmId)
                    <x-shared.tab-item
                            :href="route('firms.create')"
                            :is_active="\Illuminate\Support\Facades\Route::currentRouteName() === 'firms.create'"
                    >
                        Нова фирма
                    </x-shared.tab-item>
                @else
                    <x-shared.tab-item
                            :href="route('firms.edit', ['firm' => $firmId])"
                            :is_active="\Illuminate\Support\Facades\Route::currentRouteName() === 'firms.edit'"
                    >
                        Информация за фирмата
                    </x-shared.tab-item>
                    <x-shared.tab-item
                            :href="route('firms.workers.index', ['firm' => $firmId])"
                            :is_active="\Illuminate\Support\Facades\Route::currentRouteName() === 'firms.workers.index'"
                    >
                        Работещи
                    </x-shared.tab-item>
                @endif
            </nav>
        </div>
    </div>
    {{ $slot }}
</div>
