@php
$classes = [
    'success' => 'bg-green-100 border-green-500 text-green-800',
    'error'   => 'bg-red-100 border-red-500 text-red-800',
    'warning' => 'bg-yellow-100 border-yellow-500 text-yellow-800',
    'info'    => 'bg-blue-100 border-blue-500 text-blue-800',
];
$class = $classes[$type] ?? 'bg-gray-100 border-gray-500 text-gray-800';
@endphp

<div
    x-data="{ show: true }"
    x-init="setTimeout(() => show = false, 4000)"
    x-show="show"
    x-transition
    class="fixed top-5 right-5 border-l-4 p-4 rounded-lg shadow-lg z-50 !bg-green-100"
>
    <div class="flex items-center {{ $class }}">
        <span class="text-sm font-medium !bg-green-100">
            {{ $message }} 
        </span>
        <button @click="show = false" class="ml-4 font-bold">✕</button>
    </div>
</div>
