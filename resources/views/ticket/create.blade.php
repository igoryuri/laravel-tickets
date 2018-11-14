@extends('layouts.app')

@section('styles')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="cell flex-align-self-center">
                <div class="card">
                    <div class="card-header">
                        <h4>Chamados</h4>
                    </div>

                    <div class="card-content p-2">
                        <form action="{{ route('tickets.store')}}" method="post" class="custom-validation"
                              enctype="multipart/form-data">
                            @include('ticket._form')
                            <button type="submit" class="button success">Salvar</button>
                            <a class="button" href="{{ url()->previous() }}">Voltar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if(session('alert'))
        <script>
            $(document).ready(function () {
                Metro.toast.create("{{ session('alert') }}", null, 5000, "alert");
            })
        </script>
    @endif
@endsection