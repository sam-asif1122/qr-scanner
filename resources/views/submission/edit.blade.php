<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-500 leading-tight">
            {{ __('Submissions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="col text-right">
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-700 border-b border-gray-200">
                  <h2 class="font-semibold text-lg dark:text-gray-200 leading-tight mb-10">
                    {{ __('Edit Submission') }}
                  </h2>

                  <p class="mt-6 text-sm text-gray-700 dark:text-gray-500">
                       Previous file:
                    </p>
                   <p class="text-sm mb-5 text-white">
                        {{ $submission->document?->document_name }}
                   </p>

                  <form action="{{ route('submission.update', $submission) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="file" name="path" class="text-sm text-gray-600 dark:text-gray-400" >
                        <x-primary-button>{{ __('Scan QR') }}</x-primary-button>
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                                type="submit"
                            ></p>
                    </form>
                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <p class="text-red-500 text-sm mt-2">{{ $error }}</p>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
