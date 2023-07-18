<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('post-deletion-status'))
                <div class="bg-white my-2 border-l-4 p-2 border-green-600" x-data="{ show: true }" x-show="show"
                    x-transition x-init="setTimeout(() => show = false, 3000)">
                    {!! session('post-deletion-status') !!}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-5">
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        @if ($posts->total() < 1)
                            <p class="p-3 font-medium text-xl text-center">No posts yet</p>
                        @else
                            <table class="min-w-full border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach (['Title', 'Author', 'categories', 'Created at', 'Updated at', ''] as $name)
                                            <th class="py-3.5 px-4 text-sm text-left text-gray-900 font-medium">
                                                {{ $name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100 border-t border-gray-100">
                                    @foreach ($posts as $post)
                                        <tr class="text-sm text-gray-500">
                                            @php
                                                $categories = $post->categories
                                                    ->map(function ($category) {
                                                        return "<span class='px-2 py-1 inline-block rounded-sm bg-slate-200'>$category->name</span>";
                                                    })
                                                    ->toArray();
                                                
                                                $categories = '<div class="space-x-1">' . implode('', $categories) . '</div>';
                                            @endphp
                                            @foreach ([$post->title, $post->user->name, $categories, $post->created_at, $post->updated_at] as $value)
                                                <td class="p-4">{!! $value ?: '' !!}</td>
                                            @endforeach

                                            <td class="p-4 flex items-center gap-2">

                                                <a class="cursor-pointer hover:text-blue-500"
                                                    href="{{ route('post.edit', $post->id) }}"><svg
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </a>
                                                <button class="cursor-pointer hover:text-blue-500" x-data
                                                    x-on:click="$dispatch('open-modal','confirm-post-deletion-{{ $post->id }}')"><svg
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-6 h-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </button>
                                                <x-modal-box name="confirm-post-deletion-{{ $post->id }}">
                                                    <form class="p-6" action="{{ route('post.destroy', $post->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')

                                                        <h2 class="text-lg font-medium text-gray-900">
                                                            {{ __('Are you sure you want to delete post: :post?', ['post' => $post->title]) }}
                                                        </h2>

                                                        <div class="mt-6 flex justify-end">
                                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                                {{ __('Cancel') }}
                                                            </x-secondary-button>

                                                            <x-danger-button class="ml-3">
                                                                {{ __('Delete post') }}
                                                            </x-danger-button>
                                                        </div>
                                                    </form>
                                                </x-modal-box>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    {{ $posts->onEachSide(1)->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
