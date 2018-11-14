@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/dialogs.css') }}" rel="stylesheet">
    <link href="{{ asset('css/hint-animation.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-justify-center">
            <div id="activity" data-role="activity" data-type="cycle" data-style="color" style="display: none"></div>
        </div>
        <div class="row">
            <div class="cell-md-12 flex-align-self-center">
                <div class="card">
                    <div class="card-header">
                        <div class="row flex-align-center">
                            <div class="cell-md-6">
                                <h4>Dashboard - Chamado Concluídos</h4>
                            </div>
                            <div class="cell-md-6">

                                <p class="place-right"><a class="button flat-button" href="{{ url()->previous() }}">Voltar</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="card-content p-2" style="overflow-x: auto">
                        <div id="table_refresh">
                            <div class="row mb-2">
                                <div class="cell-md-8 my-search-wrapper"></div>
                                <div class="cell-md-4 my-rows-wrapper"></div>
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
                                        <th data-sortable="true">Descrição</th>
                                        <th data-sortable="true">Urgência</th>
                                        <th data-sortable="true">Impacto</th>
                                        <th data-sortable="true">Requerente</th>
                                        <th>Imagem</th>
                                        <th data-sortable="true">Status</th>
                                        <th class="text-center">Atribuído</th>
                                        <th class="text-center">Ação</th>
                                    </tr>
                                </thead>
                                <script>
                                    var hintRoutines = {
                                        showHint: function (hint, element) {
                                            hint.addClass("showHint");
                                            setTimeout(function () {
                                                hint.removeClass("showHint");
                                            }, 500)
                                        },

                                        hideHint: function (hint, element) {
                                            hint.addClass("hideHint");
                                        }
                                    }
                                </script>
                                <tbody class="row-hover" id="messages">
                                    @foreach( $ticketsOpen as $ticketOpen)
                                        <tr>
                                            <td>
                                                <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                                                    {{ $ticketOpen->id }}
                                                </div>
                                            </td>
                                            <td>
                                                <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                                                    {{ $ticketOpen->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                                                    {{ substr($ticketOpen->description, 0, 30) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                                                    @switch($ticketOpen->urgency)
                                                        @case(1)
                                                        Baixa
                                                        @break

                                                        @case(2)
                                                        Média
                                                        @break

                                                        @case(3)
                                                        Alta
                                                        @break
                                                    @endswitch
                                                </div>
                                            </td>
                                            <td>
                                                <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                                                    @switch($ticketOpen->impact)
                                                        @case(1)
                                                        Baixo
                                                        @break

                                                        @case(2)
                                                        Médio
                                                        @break

                                                        @case(3)
                                                        Alto
                                                        @break
                                                    @endswitch
                                                </div>
                                            </td>
                                            <td>
                                                <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                                                    {{ $ticketOpen->ticketUserName }}
                                                </div>
                                            </td>
                                            <td>
                                                <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                                                    {{ $ticketOpen->image }}
                                                </div>
                                            </td>
                                            <td>
                                                <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                                                    @switch($ticketOpen->status)
                                                        @case(1)
                                                        Aberto
                                                        @break

                                                        @case(2)
                                                        Processando
                                                        @break

                                                        @case(3)
                                                        Pendente Fornecedor
                                                        @break

                                                        @case(4)
                                                        Pendente Cliente
                                                        @break

                                                        @case(5)
                                                        Fechado
                                                        @break
                                                    @endswitch
                                                </div>
                                            </td>
                                            <td>
                                                <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                                                    <div class="d-flex flex-justify-center">
                                                        {{ $ticketOpen->userName }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('timeline.show', ['id' => $ticketOpen->id]) }}"
                                                   class="button small d-flex flex-justify-center secondary">
                                                    <span class="mif-history mr-1"></span> Histórico
                                                </a>
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
    </div>
@endsection

@section('scripts')

    @if(session('login'))
        <script>
            $(document).ready(function () {
                var notify = Metro.notify;
                notify.setup({
                    width: 300,
                    duration: 1000
                });
                notify.create("{{ session('login') }}");
                notify.reset();
            })
        </script>
    @endif
    @if(session('success'))
        <script>
            $(document).ready(function () {
                Metro.toast.create("{{ session('success') }}", null, 5000, "success");
            })
        </script>
    @endif

@endsection
