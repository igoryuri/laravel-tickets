@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="{{asset('css/timeline.css')}}">
@endsection
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row flex-align-center">
                <div class="cell-md-6">
                    <h4>Timeline - Chamado: {{$ticket[0]->id}}</h4>
                </div>
                <div class="cell-md-6">
                    <p class="place-right"><a class="button flat-button" href="{{ url()->previous() }}">Voltar</a></p>
                </div>
            </div>
        </div>
        <div class="card-content p-2" style="overflow-y: auto; height: 550px;">
            <div class="item">
                <div class="image">
                    <div>
                        <img src="{{asset('img/icons/open.png')}}"/>
                        <span>{{date('d.m.Y', strtotime($ticket[0]->created_at))}}</span>
                    </div>
                </div>
                <div class="details">
                    <div>
                        <h1>{{$ticket[0]->name}}</h1>
                        <p>{{$ticket[0]->description}}</p>
                        <span class="place-right text-small text-muted">Responsável: {{$ticket[0]->userName}}
                            - {{date('h:i:s', strtotime($ticket[0]->created_at))}}</span>
                    </div>
                </div>
            </div>

            @foreach($timelines as $timeline)
                @if($timeline->assign_id !== null)
                    <div class="item">
                        <div class="image">
                            <div>
                                <img src="{{asset('img/icons/assign.png')}}"/>
                                <span>{{date('d.m.Y', strtotime($timeline->tmCreated))}}</span>
                            </div>
                        </div>
                        <div class="details">
                            <div>
                                <h1>{{$timeline->tName}}</h1>
                                <p>{{$timeline->name}} assumiu o chamado.</p>
                                <span class="place-right text-small text-muted">Responsável: {{$timeline->aName}}
                                    - {{date('h:i:s', strtotime($timeline->tmCreated))}}</span>
                            </div>
                        </div>
                    </div>
                @elseif($timeline->monitorId !== null)
                    <div class="item">
                        <div class="image">
                            <div>
                                <img src="{{asset('img/icons/monitoring.png')}}"/>
                                <span>{{date('d.m.Y', strtotime($timeline->tmCreated))}}</span>
                            </div>
                        </div>
                        <div class="details">
                            <div>
                                <h1>{{$timeline->tName}}</h1>
                                <p>{{$timeline->mDescription}}</p>
                                <span class="place-right text-small text-muted">Responsável: {{$timeline->aName}}
                                    - {{date('h:i:s', strtotime($timeline->tmCreated))}}</span>
                            </div>
                        </div>
                    </div>
                @elseif($timeline->solutionId !== null)
                    <div class="item">
                        <div class="image">
                            <div>
                                <img src="{{asset('img/icons/solution.png')}}"/>
                                <span>{{date('d.m.Y', strtotime($timeline->tmCreated))}}</span>
                            </div>
                        </div>
                        <div class="details">
                            <div>
                                <h1>{{$timeline->tName}} - Encerrado</h1>
                                <p>{{$timeline->sDescription}}</p>
                                <span class="place-right text-small text-muted">Responsável: {{$timeline->aName}}
                                    - {{date('h:i:s', strtotime($timeline->tmCreated))}}</span>
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
    </div>

@endsection




