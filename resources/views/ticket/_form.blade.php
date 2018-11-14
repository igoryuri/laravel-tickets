{!! csrf_field() !!}
<input type="hidden" name="location" value="{{$location}}">
<div class="row mb-2">
    <div class="cell-md-12">
        <label for="name">Título</label>
        <input type="text" name="name" id="name" placeholder="Entre com o nome" value="{{ old('name', $ticket->name) }}" required autofocus/>
    </div>
</div>
<div class="row mb-2">
    <div class="cell-md-12">
        <label for="description">Descrição</label>
        <textarea name="description" id="description" placeholder="Entre com a descrição" required
                  data-role="textarea"
                  data-auto-size="true"
                  data-max-height="400">{{ old('description', $ticket->description) }}</textarea>
    </div>
</div>

<div class="row mb-2">
    <div class="cell-md-3">
        @php
            if (isset($categories->department_id)){
            $department_id = $categories->department_id;
            }else{
                $department_id = null;
            }
        @endphp
        <label for="category_id">Departamento</label>
        <select name="department_id" id="department_id" value="{{$department_id}}" required>
            <option value="">Selecione o Departamento</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{old('category_id',$department_id) == $department->id ?'selected="selected"': ''}}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="cell-md-3">
        <label for="category_id">Categoria</label>
        <select name="category_id" id="category_id" required>
            <option value='{{old('category_id', $ticket->category_id)}}'>Selecione Categoria</option>
        </select>
    </div>
    <div class="cell-md-2">
        <label for="type">Tipo</label>
        <select name="type" id="type" value="{{old('type', $ticket->type)}}" required>
            <option value="">Selecione o tipo</option>
            <option value="2" {{old('type',$ticket->type) == 2 ?'selected="selected"': ''}}>Requisição</option>
            <option value="1" {{old('type',$ticket->type) == 1 ?'selected="selected"': ''}}>Incidente</option>
        </select>
    </div>
    <div class="cell-md-2">
        <label for="urgency">Urgência</label>
        <select name="urgency" id="urgency" value="{{old('urgency', $ticket->urgency)}}" required>
            <option value="1" {{old('urgency',$ticket->urgency) == 1 ?'selected="selected"': ''}}>Baixa</option>
            <option value="2" {{old('urgency',$ticket->urgency) == 2 ?'selected="selected"': ''}}>Média</option>
            <option value="3" {{old('urgency',$ticket->urgency) == 3 ?'selected="selected"': ''}}>Alta</option>
        </select>
    </div>
    <div class="cell-md-2">
        <label for="impact">Impacto</label>
        <select name="impact" id="impact" value="{{old('impact', $ticket->impact)}}" required>
            <option value="1" {{old('impact',$ticket->impact) == 1 ?'selected="selected"': ''}}>Baixo</option>
            <option value="2" {{old('impact',$ticket->impact) == 2 ?'selected="selected"': ''}}>Médio</option>
            <option value="3" {{old('impact',$ticket->impact) == 3 ?'selected="selected"': ''}}>Alto</option>
        </select>
    </div>
</div>

<div class="row mb-2">
    <div class="cell-md-12">
        <label for="type">Imagem</label>
        <input type="file" data-role="file" data-button-title="<span class='mif-folder'></span>" name="image">
        <small class="text-muted fg-red mr-1">
            Extensões permitidas .jpg, .jpeg, .png, .pdf
        </small>
        <small class="text-muted">
            @isset($ticket->image)
                Imagem Cadastrada: {{ old('image', $ticket->image) }}
            @endisset
        </small>
    </div>
</div>
@if(Auth::user()->department_id !== 1)

    <div class="row mb-2">
        <div class="cell-md-3">
            <label for="user_id">Requerente</label>
            <select name="user_id" id="user_id" value="{{old('user_id', $ticket->user_id)}}" data-role="select">
                <option value="{{ Auth::id() }}">{{ Auth::user()->username }}</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{old('user_id',$ticket->user_id) == $user->id ?'selected="selected"': ''}}>{{ $user->username }}</option>
                @endforeach
            </select>
        </div>
        <div class="cell-md-3">
            <label for="impact">Status</label>
            <select name="status" id="status" value="{{old('status', $ticket->status)}}" data-role="select">
                <option value="1" {{old('status',$ticket->status) == 1 ?'selected="selected"': ''}}>Aberto</option>
                <option value="2" {{old('status',$ticket->status) == 2 ?'selected="selected"': ''}}>Processando</option>
                <option value="3" {{old('status',$ticket->status) == 3 ?'selected="selected"': ''}}>Pendente Fornecedor</option>
                <option value="4" {{old('status',$ticket->status) == 4?'selected="selected"': ''}}>Pendente Cliente</option>
                <option value="5" {{old('status',$ticket->status) == 5 ?'selected="selected"': ''}}>Fechado</option>
            </select>
        </div>
        <div class="cell-md-1">
            <label for="change">Mudança</label>
            <input type="checkbox" data-role="switch" data-caption="Sim" name="change" id="change">
        </div>
    </div>
@else
    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
    <input type="hidden" name="status" id="status" value="{{ $ticket->status ?? '1' }}">
@endif

@section('scripts')
    <script src="{{asset('js/category-ajax.js')}}"></script>
@endsection