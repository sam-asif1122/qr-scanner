<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-500 leading-tight">
            {{ __('Submissions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-2 px-6">
                    <form action="{{  route('scan-qr') }}" method="get">
                        @csrf
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
                </div>
                
                <div class="p-6 bg-white dark:bg-gray-700 border-b border-gray-200">
                
                    <div class="flex flex-col">
                    
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-center font-medium text-gray-500 dark:text-black uppercase tracking-wider">
                                                ID
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center font-medium text-gray-500 dark:text-black uppercase tracking-wider">
                                                Document Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center font-medium text-gray-500 dark:text-black uppercase tracking-wider">
                                                Code
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center font-medium text-gray-500 dark:text-black uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-center font-medium text-gray-500 dark:text-black uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-400">
                                        @if ($submissions->count() == 0)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-400 font-medium" colspan="5">No submissions by this user.</td>
                                            </tr>
                                        @endif
                                        @foreach ($submissions as $submission)
                                            <tr class="border-b border-gray-200 dark:border-gray-600">
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-400 font-medium">
                                                    {{ $submission->id }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                                                    {{ $submission->document?->document_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                                                    {{ $submission->code }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                                                    {{ $submission->status->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                                                <a class="text-green-600 hover:text-green-100" href="{{ route('submission.show', $submission) }}">View</a>
                                                    <a class="text-indigo-600 hover:text-indigo-100 ml-2" href="{{ route('submission.edit', $submission) }}">Edit</a>
                                                    <form action="{{ route('submission.destroy', $submission) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-100 ml-2">Delete</button>
                                                    </form>
                                                </td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                        {{ $submissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
