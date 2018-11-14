{!! csrf_field() !!}
<div class="row mb-2">
    <div class="cell-md-5">
        <label for="department_id">Departamento</label>
        <select name="department_id" id="department_id" value="{{$permission->department_id}}" data-role="select" required>
            <option value="">Selecione o departamento</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{old('department_id',$permission->department_id) == $department->id ?'selected="selected"': ''}}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="cell-md-5">
        <label for="department_id">Rota</label>
        <select name="route_id" id="route_id" value="{{$permission->route_id}}" data-role="select" required>
            <option value="">Selecione a rota</option>
            @foreach($routes as $route)
                <option value="{{ $route->id }}" {{old('route_id',$permission->route_id) == $route->id ?'selected="selected"': ''}}>
                    {{ $route->route_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="cell-md-1">
        <label for="active">Status</label>
        <input type="checkbox" data-role="switch" data-caption="Ativo" name="active" id="active" {{old('active',$permission->active) === 1 ?'checked': ''}}>
    </div>
</div>
