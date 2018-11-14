@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="cell flex-align-self-center">
                <div class="card">
                    <div class="card-header">
                        <h4>Usuários</h4>
                    </div>

                    <div class="card-content p-2">
                        <form action="{{ route('users.update', ['id' => $user->id]) }}" method="post" class="custom-validation">
                            @method('PUT')
                            {!! csrf_field() !!}

                            @include('user._form')

                            <button type="submit" class="button success">Salvar</button>
                            <a class="button" href="{{ route('users.index') }}">Voltar</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
@endsection