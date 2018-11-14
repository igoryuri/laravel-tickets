{!! csrf_field() !!}
<div class="row mb-2">
    <div class="cell-md-6">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" placeholder="Entre com o nome" value="{{ old('name', $category->name) }}" required autofocus/>
    </div>
    <div class="cell-md-6">
        @php
            $department_id = $category->department_id;
        @endphp
        <label for="department_id">Departamento</label>
        <select name="department_id" id="department_id" value="{{$department_id}}" data-role="select" required/>
        <option value="">Selecione o departamento</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{old('department_id',$department_id) == $department->id ?'selected="selected"': ''}}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
