<div class="row mb-2">
    <div class="cell-md-12">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" placeholder="Entre com o nome" value="{{ $user->name }}" required/>
    </div>
</div>
<div class="row mb-2">
    <div class="cell-md-12">
        <label for="email">Email address</label>
        <input type="email" name="email" id="email" placeholder="Entre com endereço de e-mail"
               value="{{ $user->email }}"/>
    </div>
</div>
<div class="row">
    <div class="cell-md-4">
        @php
            $department_id = $user->department_id;
        @endphp
        <label for="department_id">Departamento</label>
        <select name="department_id" id="department_id" value="{{$department_id}}" data-role="select" required/>
            <option value="">Selecione o departamento</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}" {{old('department_id',$department_id) == $department->id ?'selected="selected"': ''}}>{{ $department->name }}</option>
        @endforeach

        </select>
    </div>
    <div class="cell-md-4">
        <label for="username">Nome de Usuário</label>
        <input type="text" name="username" id="username" placeholder="Entre com nome de usuário"
               value="{{ $user->username }}" required/>
    </div>
    <div class="cell-md-4">
        @php
            $access_level = $user->access_level;
        @endphp
        <label for="access_level">Nivel de Acesso</label>
        <select name="access_level" id="access_level" value="{{$access_level}}" data-role="select" required/>
        <option value="">Selecione o nível de acesso</option>
        <option value="1" {{old('access_level',$access_level) == 1 ?'selected="selected"': ''}}>Nível 1</option>
        <option value="2" {{old('access_level',$access_level) == 2 ?'selected="selected"': ''}}>Nível 2</option>
        <option value="3" {{old('access_level',$access_level) == 3 ?'selected="selected"': ''}}>Nível 3</option>
        <option value="4" {{old('access_level',$access_level) == 4 ?'selected="selected"': ''}}>Nível 4</option>
        <option value="5" {{old('access_level',$access_level) == 5 ?'selected="selected"': ''}}>Nível 5</option>
        <option value="6" {{old('access_level',$access_level) == 6 ?'selected="selected"': ''}}>Nível 6</option>
        <option value="7" {{old('access_level',$access_level) == 7 ?'selected="selected"': ''}}>Nível 7</option>
        <option value="8" {{old('access_level',$access_level) == 8 ?'selected="selected"': ''}}>Nível 8</option>
        <option value="9" {{old('access_level',$access_level) == 9 ?'selected="selected"': ''}}>Nível 9</option>
        <option value="10" {{old('access_level',$access_level) == 10 ?'selected="selected"': ''}}>Nível 10</option>
        </select>
    </div>
</div>
<div class="row mb-4">
    <div class="cell-md-12">
        <label for="groups">Nome do Grupo</label>
        <input type="text" name="groups" id="groups" placeholder="Entre com nome do grupo" value="{{ $user->groups }}"
               data-role="taginput"/>
    </div>
</div>