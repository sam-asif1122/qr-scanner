<x-app-layout>
    <x-slot name="header">
       <a href= "{{ route('submission.index') }}">
            <h2 class="font-semibold text-xl dark:text-gray-500 leading-tight">
                {{ __('Submissions') }}
            </h2>
        </a>
    </x-slot>

    <div class="py-6">
        <div class="col text-right">
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-700 border-b border-gray-200">
                   <img src="{{ asset('uploads/'.$submission->document->document_name) }}" alt="Uploaded Image" width="300" height="200">
                   <p class="mt-8 text-md text-gray-700 dark:text-gray-500">
                       Content:
                    </p>
                   <p class="text-md text-white">
                        {{ $submission->content }}
                   </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
