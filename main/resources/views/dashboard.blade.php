<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('user-deletion-status'))
                <div class="bg-white my-2 border-l-4 p-2 border-green-600">
                    {!! session('user-deletion-status') !!}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-5">
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        <table class="min-w-full border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    @foreach (['Name', 'Email', 'Number of posts', 'Email verified at', 'Created at', 'Updated at', ''] as $name)
                                        <th class="py-3.5 px-4 text-sm text-left text-gray-900 font-medium">
                                            {{ $name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100 border-t border-gray-100">
                                @foreach ($users as $user)
                                    <tr class="text-sm text-gray-500">
                                        @foreach ([$user->name, $user->email, $user->posts_count, $user->email_verified_at, $user->created_at, $user->updated_at] as $key => $value)
                                            <td class="p-4">{{ $key === 2 ? $value : ($value ?: '') }}</td>
                                        @endforeach

                                        <td class="p-4 flex items-center gap-2">
                                            @if ($user->trashed())
                                                <button class="cursor-pointer hover:text-blue-500" x-data
                                                    x-on:click="$dispatch('open-modal','confirm-user-restoration-{{ $user->id }}')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                    </svg>
                                                </button>
                                                <x-modal-box name="confirm-user-restoration-{{ $user->id }}">
                                                    <form method="POST" action="{{ route('restore', $user->id) }}"
                                                        class="p-6">
                                                        @csrf

                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            {{ __('Are you sure you want to restore account: :user?', ['user' => $user->name]) }}
                                                        </h2>

                                                        <div class="mt-6 flex justify-end">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                {{ __('Cancel') }}
                                                            </x-secondary-button>

                                                            <x-primary-button class="ml-3">
                                                                {{ __('Restore Account') }}
                                                            </x-primary-button>
                                                        </div>
                                                    </form>
                                                </x-modal-box>
                                            @else
                                                <a class="cursor-pointer hover:text-blue-500"
                                                    href="{{ route('user.edit', $user->id) }}"><svg
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </a>
                                                <button class="cursor-pointer hover:text-blue-500" x-data
                                                    x-on:click="$dispatch('open-modal','confirm-user-deletion-{{ $user->id }}')"><svg
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                                <x-modal-box name="confirm-user-deletion-{{ $user->id}}">
                                                    <form class="p-6"
                                                        action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')

                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            {{ __('Are you sure you want to delete account: :user?', ['user' => $user->name]) }}
                                                        </h2>

                                                        <div class="mt-6 flex justify-end">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                {{ __('Cancel') }}
                                                            </x-secondary-button>

                                                            <x-danger-button class="ml-3">
                                                                {{ __('Delete Account') }}
                                                            </x-danger-button>
                                                        </div>
                                                    </form>
                                                </x-modal-box>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $users->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
