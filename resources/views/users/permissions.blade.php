<x-app-layout>
<div class="max-w-4xl mx-auto py-8 px-4">

<div class="bg-white shadow rounded-lg p-6">
<h2 class="text-xl font-bold mb-4">
    🔐 Permisos de {{ $user->nombre_completo }}
</h2>

<form method="POST" action="{{ route('users.permissions.update',$user) }}">
@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-96 overflow-y-auto border p-4 rounded">
@foreach($permissions as $permission)
    <label class="flex items-center gap-2">
        <input type="checkbox" name="permissions[]"
               value="{{ $permission->name }}"
               @checked($user->hasPermissionTo($permission->name))>
        {{ $permission->name }}
    </label>
@endforeach
</div>

<div class="flex justify-end gap-3 mt-6">
    <a href="{{ route('users.index') }}" class="border px-4 py-2 rounded">
        Cancelar
    </a>
    <button class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">
        Guardar permisos
    </button>
</div>

</form>
</div>
</div>
</x-app-layout>
