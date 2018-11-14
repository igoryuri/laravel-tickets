@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="cell flex-align-self-center">
                <div class="card bg-white">
                    <div class="card-header">
                        <div class="row flex-align-center">
                            <div class="cell-md-6">
                                <h4>Chamados</h4>
                            </div>
                            <div class="cell-md-3">
                                <input type="checkbox" data-role="checkbox" class="place-right" id="checkTimeline" onclick="$('.buttonTimeline').toggle()"
                                       data-caption="Mostrar/Ocultar histótico"
                                       data-caption-position="left">
                            </div>
                            <div class="cell-md-3">
                                <select data-role="select" data-cls-option="fg-cyan" id="status">
                                    <option value="0" selected>Não solucionado</option>
                                    <option value="1">Aberto</option>
                                    <option value="2">Processando</option>
                                    <option value="3">Pendente Fornecedor</option>
                                    <option value="4">Pendente Cliente</option>
                                    <option value="5">Fechado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="table_refresh">
                        <div class="card-content p-2 w-100" style="overflow-x: auto">
                            <div class="row mb-2">
                                <div class="cell-md-6 my-search-wrapper"></div>
                                <div class="cell-md-4 my-rows-wrapper"></div>
                                <div class="cell-md-2">
                                    <a href="{{ route('tickets.create') }}" class="button secondary rounded">Criar Chamado</a>
                                </div>
                            </div>
                            <table id="table" class="table striped row-hover row-border table-border cell-border compact"
                                    data-role="table"
                                    data-rows="10"
                                    data-rows-steps="5, 10, 50"
                                    data-search-wrapper=".my-search-wrapper"
                                    data-rows-wrapper=".my-rows-wrapper"
                                    data-table-search-title="Quick search:"
                                    data-pagination-wrapper=".my-pagination-wrapper"
                                    data-info-wrapper=".my-info-wrapper"
                            >
                                <thead>
                                    <tr>
                                        <th data-sortable="true" data-format="number">Id</th>
                                        <th data-sortable="true">Nome</th>
                                        <th>Descrição</th>
                                        <th data-sortable="true">Tipo</th>
                                        <th>Urgência</th>
                                        <th>Impacto</th>
                                        <th>Imagem</th>
                                        <th>Status</th>
                                        <th class="text-center" data-size="200">Ação</th>
                                    </tr>
                                </thead>
                                <tbody class="row-hover">
                                    @foreach( $tickets as $ticket)
                                        <tr>
                                            <td>
                                                {{ $ticket->id }}
                                            </td>
                                            <td>
                                                {{ substr($ticket->name, 0, 30) }}
                                            </td>
                                            <td>
                                                {{ substr($ticket->description, 0, 30) }}
                                            </td>
                                            <td>
                                                @switch($ticket->type)
                                                    @case(1)
                                                    Incidente
                                                    @break

                                                    @case(2)
                                                    Requisição
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($ticket->urgency)
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
                                            </td>
                                            <td>
                                                @switch($ticket->impact)
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
                                            </td>
                                            <td>
                                                {{ $ticket->image }}
                                            </td>
                                            <td>
                                                @switch($ticket->status)
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
                                            </td>
                                            <td>
                                                <form action="{{ route('tickets.destroy', ['id' => $ticket->id]) }}" method="post"
                                                      id="formDelete{{ $ticket->id }}">
                                                    @method('DELETE')
                                                    {!! csrf_field() !!}
                                                </form>
                                                <div class="d-flex flex-justify-center">
                                                    <a class="button small mr-1" href="{{ route('tickets.edit', ['id' => $ticket->id]) }}"><span
                                                                class="mif-pencil"></span> Editar</a>
                                                    <button class="button small mr-1" type="submit" form="formDelete{{ $ticket->id }}"
                                                            onclick="document.getElementById('progress').removeAttribute('hidden')" hidden>
                                                        <span class="mif-bin"></span> Apagar
                                                    </button>
                                                    <a href="{{ route('monitorings.showPage', ['monitoring' => $ticket->id]) }}"
                                                       class="button small mr-1">
                                                        <span class="mif-eye"></span> Acompanhar
                                                    </a>
                                                    <a href="{{ route('timeline.show', ['status' => $ticket->id]) }}"
                                                       class="button small buttonTimeline" style="display: none;">
                                                        <span class="mif-history"></span> Histórico
                                                    </a>
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
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(function () {
            $('#status').change(function () {
                var id = $(this).val();
                if (id !== '') {
                    var url = "{{ route('tickets.show',['status'=> 'status_id']) }}";
                    var res = url.replace("status_id", id);
                } else {
                    var url = "{{ route('tickets.show',['status'=> 'status_id']) }}";
                    var res = url.replace("status_id", id);
                }
                jQuery.ajax({
                    url: res,
                    type: "get",
                    success: function (data) {
                        $("#table_refresh").html(data);
                    }
                });
                return false;
            });
        });
    </script>

    @if(session('success'))
        <script>
            $(document).ready(function () {
                Metro.toast.create("{{ session('success') }}", null, 5000, "success");
            })
        </script>
    @endif
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
@endsection
