<x-layouts.main-content title="Settings"
                        heading="List of settings"
                        subheading="Manage the settings of the institution">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl ">
        <div class="flex justify-start ">
            <div class="my-4 p-6 ">
                <div class="flex items-center gap-4 mb-4">
                    <flux:button variant="primary" href="{{ route('settings.create') }}">Create a new Setting</flux:button>
                </div>
                <div class="my-4 font-base text-sm text-gray-700 dark:text-gray-300">
                    <x-settings.table :settings="$settings"
                    />
                </div>
                <div class="mt-4">
                    {{ $settings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.main-content>
