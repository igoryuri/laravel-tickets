@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="cell flex-align-self-center">
                <div class="card">
                    <div class="card-header">
                        <h4>Permissões departamento - {{$department->name}}</h4>
                    </div>
                    <div class="card-content p-4 bg-grayWhite">
                        <div data-role="accordion"
                             data-one-frame="false"
                             data-show-active="true"
                             data-material="true"
                             data-active-heading-class="bg-lightCyan fg-white"
                             data-active-content-class="bg-white">
                            @php $exist = array(); @endphp
                            @foreach($routes as $route)

                                @php
                                    $array = array('login', 'getajaxData', 'home', 'logout', 'register');
                                            if (in_array($route->route_name, $array)){
                                                $route_name = 'home.'.$route->route_name;
                                                $route_name_exist = strstr($route_name, '.', true);
                                            }else{
                                                $route_name_exist = strstr($route->route_name, '.', true);
                                            }

                                    if(!in_array($route_name_exist, $exist)){
                                @endphp

                                <div class="frame">
                                    <div class="heading text-cap">{{$route_name_exist}}</div>
                                    <div class="content">
                                        <div class="p-5">
                                            <div class="row">
                                                <div class="cell">
                                                    <div class="row">
                                                        @php
                                                            foreach($permissions as $permission){

                                                                $array = array('login', 'getajaxData', 'home', 'logout', 'register');
                                                                if (in_array($permission->route_name, $array)){
                                                                    $permission_name = 'home.'.$route->route_name;
                                                                    $route_name = 'home.'.$route->route_name;
                                                                }
                                                                $permission_name = strstr($permission->route_name, '.', true);
                                                                $route_name = strstr($route->route_name, '.', true);

                                                                if($permission_name == $route_name){
                                                        @endphp
                                                        <div class="cell">
                                                            <p>{{$permission->route_name}}
                                                                <span class="mif-info"
                                                                      data-role="hint"
                                                                      data-hint-text="{{$permission->description}}"
                                                                      data-cls-hint="bg-cyan fg-white drop-shadow">

                                                                </span>
                                                            </p>
                                                            <input type='checkbox' data-role='switch'
                                                                   name='active' class='mt-2'
                                                                   onchange="var active = $(this).is(':checked') ? 'on' : 'off'; roleUpdate(active,'{{$permission->id}}', '{{csrf_token()}}', '{{$permission->route_id}}', '{{$permission->department_id}}')"
                                                                    {{old('active',$permission->active) === 1 ?'checked': ''}}>
                                                        </div>
                                                        @php
                                                            }
                                                        }
                                                        @endphp
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    }
                                    array_push($exist, $route_name_exist);

                                @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        function roleUpdate(active, id, token, route_id, department_id) {
            $.ajax({
                url: '/bioclin/permissions/' + id,
                type: 'PUT',
                dataType: 'json',
                data: {
                    'active': active,
                    '_token': token,
                    'route_id': route_id,
                    'department_id': department_id
                },
                success: function (data) {
                    console.info(data)
                },
            });

        }
    </script>
@endsection