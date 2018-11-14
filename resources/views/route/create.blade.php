@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="cell flex-align-self-center">
                <div class="card">
                    <div class="card-header">
                        <h4>Rotas</h4>
                    </div>

                    <div class="card-content p-2">
                        <form action="{{ route('routes.store')}}" method="post" class="custom-validation"
                              enctype="multipart/form-data">
                            @include('route._form')
                            <button type="submit" class="button success">Salvar</button>
                            <a class="button" href="{{ route('routes.index') }}">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection