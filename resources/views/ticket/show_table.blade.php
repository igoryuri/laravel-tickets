<div class="card-content p-2" style="overflow-x: auto">
    <div class="row mb-2">
        <div class="cell-md-6 my-search-wrapper"></div>
        <div class="cell-md-5 my-rows-wrapper"></div>
        <div class="cell-md-1">
            <a href="{{ route('tickets.create') }}" class="button secondary rounded float-right">Criar Chamado</a>
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
                <th>Descrição</th>
                <th data-sortable="true">Tipo</th>
                <th data-sortable="true">Urgência</th>
                <th data-sortable="true">Impacto</th>
                <th>Imagem</th>
                <th data-sortable="true">Status</th>
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
                            @if($status !== '5')
                                <a class="button small mr-1" href="{{ route('tickets.edit', ['id' => $ticket->id]) }}"><span
                                            class="mif-pencil"></span> Editar</a>
                                <button class="button small mr-1" type="submit" form="formDelete{{ $ticket->id }}"
                                        onclick="document.getElementById('progress').removeAttribute('hidden')" hidden>
                                    <span class="mif-bin"></span> Apagar
                                </button>
                                <a href="{{ route('monitoringTicket.show', ['monitoring' => $ticket->id]) }}"
                                   class="button small mr-1">
                                    <span class="mif-eye"></span> Acompanhar
                                </a>
                                <a href="{{ route('timeline.show', ['status' => $ticket->id]) }}"
                                   class="button small buttonTimeline" style="display: none;">
                                    <span class="mif-history"></span> Histórico
                                </a>
                            @else
                                <a href="{{ route('timeline.show', ['status' => $ticket->id]) }}"
                                   class="button small">
                                    <span class="mif-history"></span> Histórico
                                </a>
                            @endif
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