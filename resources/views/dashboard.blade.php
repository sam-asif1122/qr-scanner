<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="bg-white shadow-lg p-4 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800">Total Submissions</h3>
                        <p class="text-3xl font-bold text-blue-600">{{ $total_submissions }}</p>
                    </div>

                    <div class="bg-white shadow-lg p-4 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800">Processed</h3>
                        <p class="text-3xl font-bold text-green-600">{{ $processed_submissions }}</p>
                    </div>

                    <div class="bg-white shadow-lg p-4 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800">Processing</h3>
                        <p class="text-3xl font-bold text-yellow-600">{{ $processing_submissions }}</p>
                    </div>

                    <div class="bg-white shadow-lg p-4 rounded-lg">
                        <h3 class="text-xl font-semibold text-gray-800">Error</h3>
                        <p class="text-3xl font-bold text-red-600">{{ $error_submissions }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
