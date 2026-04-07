<x-app-layout>
    <x-slot name="title">
        {{ __('Данетки'). __('Редактирование профиля')}}
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

        <div class="mx-auto space-y-3 sm:space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-md">
                <div class="max-w-xl mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    {{-- Сайдбар --}}
    <x-slot:sidebar>
        @include('sidebars.profile')
    </x-slot:sidebar>
</x-app-layout>