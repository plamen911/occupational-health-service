<x-app-layout>
    <x-slot name="header">
        {{ __('My profile') }}
    </x-slot>

    <x-app.flash-success/>

    <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                    <div>
                        <x-input-label for="first_name" :value="__('First Name')"/>
                        <x-text-input type="text"
                                 name="first_name"
                                 id="first_name"
                                 value="{{ old('first_name', auth()->user()->first_name) }}"
                                 placeholder="{{ __('First Name') }}"
                                 required
                        />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')"/>
                        <x-text-input type="text"
                                 name="last_name"
                                 id="last_name"
                                 value="{{ old('last_name', auth()->user()->last_name) }}"
                                 placeholder="{{ __('Last Name') }}"
                        />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="username" :value="__('Username')"/>
                        <x-text-input type="text"
                                 name="username"
                                 id="username"
                                 value="{{ old('username', auth()->user()->username) }}"
                                 placeholder="{{ __('Username') }}"
                                 required
                        />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="email" :value="__('Email')"/>
                        <x-text-input type="email"
                                 name="email"
                                 id="email"
                                 value="{{ old('email', auth()->user()->email) }}"
                                 placeholder="{{ __('Email') }}"
                                 required
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')"/>
                        <x-text-input type="password"
                                 name="password"
                                 id="password"
                                 placeholder="{{ __('Password') }}"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>
                        <x-text-input type="password"
                                 name="password_confirmation"
                                 id="password_confirmation"
                                 placeholder="{{ __('Confirm Password') }}"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button>
                        {{ __('Submit') }}
                    </x-primary-button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
