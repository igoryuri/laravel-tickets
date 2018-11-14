{!! csrf_field() !!}
<div class="row mb-2">
    <div class="cell-md-12">
        <label for="route_name">Nome da rota</label>
        <input type="text" name="route_name" id="route_name" placeholder="Entre com o nome" value="{{ old('route_name', $route->route_name) }}"
               required autofocus/>
    </div>
</div>
<div class="row mb-2">
    <div class="cell-md-12">
        <label for="description">Descrição</label>
        <textarea name="description" id="description" placeholder="Entre com a descrição"
                  data-role="textarea"
                  data-auto-size="true"
                  data-max-height="400">{{ old('description', $route->description) }}</textarea>
    </div>
</div>
