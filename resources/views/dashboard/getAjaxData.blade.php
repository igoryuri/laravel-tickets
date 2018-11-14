<link href="{{ asset('css/hint-animation.css') }}" rel="stylesheet">

<div class="row mb-2">
    <div class="cell-md-7 my-search-wrapper"></div>
    <div class="cell-md-3 my-rows-wrapper"></div>
    <div>
        <a href="{{ route('tickets.create') }}" class="button secondary rounded place-right">
            Criar Chamado
        </a>
        <a href="#" id="edit-button" class="button secondary rounded place-right mr-1"
           onclick="editTicket()" style="display: none;">
            Editar
        </a>
    </div>
</div>
<table id="table" class="table striped row-hover row-border table-border cell-border compact"
       data-role="table"
       data-rows="10"
       data-rows-steps="-1, 5, 10, 50"
       data-show-activity="true"
       data-search-wrapper=".my-search-wrapper"
       data-rows-wrapper=".my-rows-wrapper"
       data-table-search-title="Quick search:"
       data-pagination-wrapper=".my-pagination-wrapper"
       data-info-wrapper=".my-info-wrapper"
       data-check="true"
       data-check-style="2"
       data-on-check-click="var check = $(this).is(':checked'); editButton(check)">
    <thead>
        <tr>
            <th data-sortable="true" data-format="number">Id</th>
            <th data-sortable="true">Nome</th>
            {{--<th data-sortable="true">Descrição</th>--}}
            <th>Urgência</th>
            <th>Impacto</th>
            <th data-sortable="true">Requerente</th>
            <th class="text-center">Imagem</th>
            <th data-sortable="true">Status</th>
            <th class="text-center">Atribuído</th>
            <th class="text-center" data-size="200">Ação</th>
        </tr>
    </thead>
    <tbody class="row-hover">
        @foreach( $ticketsOpen as $ticketOpen)
            <tr>
                <td>
                    {{ $ticketOpen->id }}
                </td>
                <td>
                    <div data-toggle='tooltip' title="{{$ticketOpen->description}}">
                        <a href="#"
                           onclick="dialogDetails('{{$ticketOpen->id}}', '{{$ticketOpen->name}}', '{{ $ticketOpen->ticketUserName }}',
                                   '{{ $ticketOpen->description }}', '{{ $ticketOpen->urgency }}', '{{ $ticketOpen->impact }}',
                                   '{{ $ticketOpen->status }}', '{{ $ticketOpen->type }}', '{{ $ticketOpen->image }}',
                                   '{{$ticketOpen->cName}}', '{{$ticketOpen->dName}}')">
                            {{ substr($ticketOpen->name, 0, 30) }}
                        </a>
                    </div>
                </td>
                {{--<td>--}}
                {{--<div data-toggle='tooltip' title="{{$ticketOpen->description}}">--}}
                {{--{{ substr($ticketOpen->description, 0, 30) }}--}}
                {{--</div>--}}
                {{--</td>--}}
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
                        @isset($ticketOpen->image)
                            <a data-fancybox href="{{asset('app/img/ticket/'.$ticketOpen->id.'/' .$ticketOpen->image)}}"
                               class="d-flex flex-justify-center">
                                <span class="mif-image mif-2x thumbnail"></span>
                            </a>
                        @endisset
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
                        @if(isset($ticketOpen->userAssign))
                            <div class="d-flex flex-justify-center">
                                {{ $ticketOpen->userName }}
                            </div>
                        @else
                            <form action="{{ route('assigns.store') }}" method="post"
                                  id="formAssign{{ $ticketOpen->id }}">
                                {!! csrf_field() !!}
                                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                <input type="hidden" name="ticket_id" value="{{ $ticketOpen->id }}">
                            </form>
                            <div class="d-flex flex-justify-center">
                                <button class="button small secondary" type="submit"
                                        form="formAssign{{ $ticketOpen->id }}"
                                        onclick="document.getElementById('progress').removeAttribute('hidden')">
                                    <span class="mif-user-plus"></span> Atribuir
                                </button>
                            </div>
                        @endif
                    </div>
                </td>
                <td>
                    <a href="{{ route('monitorings.showPage', ['monitoring' => $ticketOpen->id]) }}"
                       class="button small secondary">
                        <span class="mif-eye"></span>
                        Acompanhamento
                    </a>
                    <a href="{{ route('timeline.show', ['id' => $ticketOpen->id]) }}"
                       class="button small secondary buttonTimeline" style="display: none;">
                        <span class="mif-history mr-1"></span> Histórico
                    </a>
                    <button onclick="dialogSolution( '{{ $ticketOpen->id }}', '{{ $ticketOpen->name }}', '{{csrf_token()}}', '{{Auth::id()}}')"
                            class="button small secondary" {{ $ticketOpen->userAssign ? '' : 'disabled' }} >
                        <span class="mif-checkmark"></span>
                        Solução
                    </button>
                    <button class="button secondary square rounded small fg-white"
                            onclick=" solutionId({{$ticketOpen->id}}); $('#top-charms').data('charms').toggle();">
                        <span class="mif-question icon"></span>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<p class="text-center my-info-wrapper"></p>
<div class="d-flex flex-justify-center my-pagination-wrapper"></div>

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