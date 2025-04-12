<table class="table table-sm">
    @foreach ($centrosCustos as $centroCusto)
    <tr>
        <td> 
            <input type="checkbox" value="{{ $centroCusto->id }}" name="centros_custos[]" id="{{ $centroCusto->id . '_' . 'CC' }}" 
            class="form-check-input" 
            {{ ($user->centrosCustos()->where('id_centro_custo', $centroCusto->id)->get()->count()) ? 'checked' : '' }}>
            <label for="{{ $centroCusto->id . '_' . 'CC' }}"  class="mb-0 form-check-label" role="button">{{ $centroCusto->nome }}</label>
        </td>
    </tr>
    @endforeach
</table>
