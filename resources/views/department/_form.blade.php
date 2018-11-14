{!! csrf_field() !!}
<div class="row mb-2">
    <div class="cell-md-12">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" placeholder="Entre com o nome" value="{{ old('name', $department->name) }}" required autofocus/>
    </div>
</div>
