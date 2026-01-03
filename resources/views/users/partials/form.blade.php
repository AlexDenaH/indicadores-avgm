<div class="space-y-4">

<input name="name" value="{{ old('name',$user->name ?? '') }}" placeholder="Nombre" class="w-full border p-2">

<input name="first_last_name" value="{{ old('first_last_name',$user->first_last_name ?? '') }}" placeholder="Apellido paterno" class="w-full border p-2">

<input name="second_last_name" value="{{ old('second_last_name',$user->second_last_name ?? '') }}" placeholder="Apellido materno" class="w-full border p-2">

<input name="email" value="{{ old('email',$user->email ?? '') }}" placeholder="Correo" class="w-full border p-2">

@if(!isset($user))
<input type="password" name="password" placeholder="Contraseña" class="w-full border p-2">
<input type="password" name="password_confirmation" placeholder="Confirmar contraseña" class="w-full border p-2">
@endif

<select name="id_dependencia" class="w-full border p-2">
    <option value="">Dependencia</option>
    @foreach($dependencias as $d)
        <option value="{{ $d->id }}" @selected(old('id_dependencia',$user->id_dependencia ?? '')==$d->id)>
            {{ $d->nombre }}
        </option>
    @endforeach
</select>

<select name="id_dep_area" class="w-full border p-2">
    <option value="">Área</option>
    @foreach($areas as $a)
        <option value="{{ $a->id }}" @selected(old('id_dep_area',$user->id_dep_area ?? '')==$a->id)>
            {{ $a->nombre }}
        </option>
    @endforeach
</select>

<select name="role" class="w-full border p-2">
@foreach($roles as $role)
    @if(
        auth()->user()->hasRole('super-admin') ||
        (auth()->user()->hasRole('administrador') &&
        in_array($role->name,['enlace-dependencia','capturista']))
    )
    <option value="{{ $role->name }}"
        {{ isset($user) && $user->hasRole($role->name) ? 'selected' : '' }}>
        {{ ucfirst($role->name) }}
    </option>
    @endif
@endforeach
</select>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    const dependenciaSelect = document.getElementById('id_dependencia');
    const areaSelect = document.getElementById('id_dep_area');
    const selectedArea = "{{ old('id_dep_area', $user->id_dep_area ?? '') }}";

    function cargarAreas(dependenciaId) {
        areaSelect.innerHTML = '<option value="">Cargando...</option>';

        fetch(`/dependencias/${dependenciaId}/areas`)
            .then(res => res.json())
            .then(data => {
                areaSelect.innerHTML = '<option value="">Seleccione área</option>';

                data.forEach(area => {
                    const option = document.createElement('option');
                    option.value = area.id;
                    option.textContent = area.nombre;

                    if (area.id == selectedArea) {
                        option.selected = true;
                    }

                    areaSelect.appendChild(option);
                });
            });
    }

    // Cambio de dependencia
    dependenciaSelect.addEventListener('change', function () {
        if (this.value) {
            cargarAreas(this.value);
        } else {
            areaSelect.innerHTML = '<option value="">Seleccione área</option>';
        }
    });

    // EDIT: cargar áreas automáticamente
    if (dependenciaSelect.value) {
        cargarAreas(dependenciaSelect.value);
    }
});
</script>
@endpush
