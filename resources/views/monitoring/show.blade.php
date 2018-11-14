@extends('layouts.app')

@section('styles')
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
@endsection

@section('content')
    <a href="{{ url()->previous() }}" class="action-button button" style="position: absolute; right: 20px; top: 10px;"
       data-role="hint"
       data-hint-text="voltar"
       data-cls-hint="bg-cyan fg-white drop-shadow">
        <span class="icon"><span class="mif-arrow-left"></span></span>
    </a>
    @php
        $status = ['null', 'Aberto', 'Processando', 'Pendente Fornecedor', 'Pendente Cliente', 'Fechado']
    @endphp
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row flex-align-center">
                    <div class="cell-md-8">
                        @if(!empty($solution))
                            <a class="button bg-darkBlue text-white" id="collapse_toggle_2">{{ $ticket->id }} - {{ $ticket->name }} - {{$status[$ticket->status]}}
                            </a>
                        @else
                            <a class="button" id="collapse_toggle_2">{{ $ticket->id }} - {{ $ticket->name }} - {{$status[$ticket->status]}}
                            </a>
                        @endif
                        <div class="pos-relative">
                            <div class="bg-dark fg-white" data-role="collapse"
                                 data-toggle-element="#collapse_toggle_2" data-collapsed="true">
                                <p class="p-2">
                                    {{$ticket->description}}
                                </p>
                                @if(!empty($solution))
                                    <p class="p-2 bg-darkBlue">
                                        {{$solution->description}}
                                    </p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="cell-md-4">
                        <div class="place-right">
                            @if(empty($assign))
                                <form action="{{ route('assigns.store') }}" method="post"
                                      id="formAssign">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                </form>
                                @if($ticket->user_id !== Auth::id())
                                    <button class="button small" type="submit"
                                            form="formAssign">
                                        <span class="mif-user-plus"></span> Atribuir
                                    </button>
                                @endif
                            @else
                                <span> <b>Responsável: </b> {{$assign['name']}}</span>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div id="app">
                <monitoring
                        ticket-id="{{ $ticket->id }}"
                        ticket-name="{{$ticket->name}}"
                        ticket-description="{{$ticket->description}}"
                        ticket-created="{{$ticket->created_at}}"
                        user-id="{{Auth::id()}}"
                >
                </monitoring>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('js/monitoring.js')}}"></script>
@endsection