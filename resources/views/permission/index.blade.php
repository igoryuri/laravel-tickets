@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="cell flex-align-self-center">
                <div class="card">
                    <div class="card-header">
                        <h4>Permissões</h4>
                        <div id="progress" style="position: absolute; right: 10px; top: 10px;" hidden>
                            <div data-role="activity" data-type="square" data-style="dark"></div>
                        </div>
                    </div>
                    <div class="card-content p-2" style="overflow-x: auto">
                        <div class="row mb-2">
                            <div class="cell-md-6 my-search-wrapper"></div>
                            <div class="cell-md-5 my-rows-wrapper"></div>
                            <div class="cell-md-1">
                                <a href="{{ route('permissions.create') }}" class="button secondary rounded float-right">Criar Permissão</a>
                            </div>
                        </div>
                        <table id="table" class="table striped row-hover row-border table-border cell-border compact"
                               data-role="table"
                               data-rows="-1"
                               data-rows-steps="-1, 5, 10, 50"
                               data-show-activity="true"
                               data-search-wrapper=".my-search-wrapper"
                               data-rows-wrapper=".my-rows-wrapper"
                               data-table-search-title="Quick search:"
                               data-pagination-wrapper=".my-pagination-wrapper"
                               data-info-wrapper=".my-info-wrapper">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nome da rota</th>
                                    <th>Departamento</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="row-hover">
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{$permission->id}}</td>
                                        <td>{{$permission->route_name}}</td>
                                        <td>{{$permission->name}}</td>
                                        <td>
                                            <div>
                                                {{old('active',$permission->active) === 1 ?'Ativado': 'Desativado'}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="text-center my-info-wrapper"></p>
                        <div class="d-flex flex-justify-center my-pagination-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection