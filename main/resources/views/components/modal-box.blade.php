@props(['show' => false, 'name'])
{{-- {{ $attributes->get('name') }} --}}
<div x-data="{ show: @js($show) }" x-show="show" @close.stop="show = false"
    @open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    class="fixed z-50 px-4 py-6 inset-0 overflow-y-auto" style="display: {{ $show ? 'block' : 'none' }};">
    <div class="rounded-lg bg-white overflow-hidden shadow-xl sm:w-full max-w-2xl mx-auto">{{ $slot }}</div>
</div>
