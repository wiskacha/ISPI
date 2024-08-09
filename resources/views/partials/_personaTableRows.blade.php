@foreach ($personas as $index => $persona)
    <tr>
        <td class="text-center hide-on-small">{{ $index + 1 }}</td>
        <td class="fw-semibold">{{ $persona->NOMBRE }}</td>
        <td class="text-muted">{{ $persona->CARNET }}</td>
        <td class="text-muted">{{ $persona->CELULAR ?? 'N/A' }}</td>
    </tr>
@endforeach