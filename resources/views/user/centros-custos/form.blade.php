<table class="table table-striped table-hover">
    @foreach ($centrosCustos as $centroCusto)
    <tr>
        <td> 
            <input type="checkbox" value="{{ $centroCusto->id }}" name="centros_custos[]" id="{{ $centroCusto->id . '_' . 'CC' }}" {{ ($centrosCustosUser->where('id_centro_custo', $centroCusto->id)->get()->count() > 0) ? 'checked' : '' }}>
            <label for="{{ $centroCusto->id . '_' . 'CC' }}">{{ $centroCusto->nome }}</label>
        </td>
    </tr>
    @endforeach
</table>
