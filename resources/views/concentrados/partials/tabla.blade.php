<table class="w-full border text-sm">
<thead class="bg-gray-200">
<tr>
    <th>Temporalidad</th>
    <th>Indicador</th>
    <th>Nivel</th>
    <th>Componente / Sub</th>
    <th>Total</th>
    <th>Acciones</th>
</tr>
</thead>

@foreach($concentrados as $temporalidad => $niveles)
<tr class="bg-gray-100 font-bold">
    <td colspan="6">{{ $temporalidad }}</td>
</tr>

@foreach($niveles as $nivel => $items)
<tr class="bg-gray-50">
    <td colspan="6">Nivel detalle: {{ $nivel }}</td>
</tr>

@foreach($items as $row)
<tr>
    <td>{{ $row->temporalidad }}</td>
    <td>{{ $row->id_indicador }}</td>
    <td>{{ $row->id_detalle }}</td>
    <td>
        {{ $row->id_componente }}
        @if($row->subcomponente)
            <div class="text-xs text-gray-500">{{ $row->subcomponente }}</div>
        @endif
    </td>
    <td>{{ $row->total }}</td>
    <td class="flex gap-2">
        @can('update',$row)
            <a href="#" class="text-blue-600">Editar</a>
        @endcan
        @can('delete',$row)
            <form method="POST" action="{{ route('concentrados.destroy',$row) }}">
                @csrf @method('DELETE')
                <button class="text-red-600">Eliminar</button>
            </form>
        @endcan
    </td>
</tr>
@endforeach
@endforeach
@endforeach
</table>
