@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="cell flex-align-self-center">
                <div class="card">
                    <div class="card-header">
                        <h4>Categoria</h4>
                        <div id="progress" style="position: absolute; right: 10px; top: 10px;" hidden>
                            <div data-role="activity" data-type="square" data-style="dark"></div>
                        </div>
                    </div>
                    <div class="card-content p-2" style="overflow-x: auto">
                        <div class="row mb-2">
                            <div class="cell-md-6 my-search-wrapper"></div>
                            <div class="cell-md-5 my-rows-wrapper"></div>
                            <div class="cell-md-1">
                                <a href="{{ route('categories.create') }}" class="button secondary rounded float-right">Criar Categoria</a>
                            </div>
                        </div>
                        <table id="table" class="table striped row-hover row-border table-border cell-border compact"
                               data-role="table"
                               data-rows="10"
                               data-rows-steps="5, 10, 50"
                               data-show-activity="true"
                               data-search-wrapper=".my-search-wrapper"
                               data-rows-wrapper=".my-rows-wrapper"
                               data-table-search-title="Quick search:"
                               data-pagination-wrapper=".my-pagination-wrapper"
                               data-info-wrapper=".my-info-wrapper">
                            <thead>
                                <tr>
                                    <th data-sortable="true" data-format="number">Id</th>
                                    <th data-sortable="true">Nome</th>
                                    <th data-sortable="true">Departamento</th>
                                    <th class="text-center" data-size="200">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="row-hover">
                                @foreach( $categories as $category)
                                    <tr>
                                        <td>
                                            {{ $category->id }}
                                        </td>
                                        <td>
                                            {{ $category->name }}
                                        </td>
                                        <td>
                                            @foreach($departments as $department)
                                                @if($department->id == $category->department_id)
                                                    {{ $department->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <form action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="post"
                                                  id="formDelete{{ $category->id }}">
                                                @method('DELETE')
                                                {!! csrf_field() !!}
                                            </form>
                                            <div class="d-flex flex-justify-center">
                                                <a class="button small mr-1" href="{{ route('categories.edit', ['id' => $category->id]) }}"><span
                                                            class="mif-pencil"></span> Editar</a>
                                                <button class="button small" type="submit" form="formDelete{{ $category->id }}"
                                                        onclick="document.getElementById('progress').removeAttribute('hidden')">
                                                    <span class="mif-bin"></span> Apagar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="text-center my-info-wrapper"></p>
                        <div class="d-flex flex-justify-center my-pagination-wrapper"></div>
                        <div class="multi-action" style="position: absolute; right: 10px; bottom: 10px;">
                            <button class="action-button rotate-minus"
                                    onclick="$(this).toggleClass('active')">
                                <span class="icon"><span class="mif-more-horiz"></span></span>
                            </button>
                            <ul class="actions drop-left">

                                <li class="bg-orange">
                                    <a href="#" onclick="$('#table').data('table').export('CSV', 'all', 'export-all.csv')">
                                        <span class="mif-upload2 icon"></span></a>
                                </li>

                                <li class="bg-teal">
                                    <a href="#" onclick="$('#table').data('table').export('CSV', 'checked', 'export-checked.csv')"><span
                                                class="mif-checkmark icon"></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @if(session('success'))
        <script>
            $(document).ready(function () {
                Metro.toast.create("{{ session('success') }}", null, 5000, "success");
            })
        </script>
    @endif

@endsection
