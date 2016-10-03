@extends('layouts.admin_layout')

@section('title', 'Admin Panel - Edit Group')

@section('content')
    @parent
    @if(!empty($data['group']))
        <div class="container">
            <h3> Edit Group </h3>
            <hr>
            <div class="row">
                {!! Form::open(['method' => 'post']) !!}
                <div class="text-center">
                    <h6>Group Name</h6>
                    {!! Form::text('name', $data['group']->name, array('placeholder'=>'Group Name', 'class' =>'form-control')) !!}
                </div>

                <div class="roles">
                    @if(!empty($data['roles']))
                        @foreach($data['roles'] as $_group_name => $_role_group)
                            <div class="toggleBlock">
                                @if(isset($data['options'][$_group_name]) && (count($data['options'][$_group_name]) === count($data['roles'][$_group_name])))
                                    {!! Form::checkbox(null, 'value', 'checked', ['class' => 'menuHandler']) !!}
                                @else
                                    {!! Form::checkbox(null, 'value', null, ['class' => 'menuHandler']) !!}
                                @endif
                                <a href="#" class="toggleHeader" title="{{$data['roles_aliases']['titles'][$_group_name]['global']}}">{{$data['roles_aliases']['headers'][$_group_name]}}</a>
                                <ul class="toggle visible">
                                    @foreach($_role_group as $_v => $_role)
                                        <li class="toggleLi">
                                            @if(isset($data['options'][$_group_name][$_v]))
                                                {!! Form::checkbox('roles['.$_group_name.']['. $_v .']', $_role, 'ckecked') !!}
                                            @else
                                                {!! Form::checkbox('roles['.$_group_name.']['. $_v .']', $_role) !!}
                                            @endif
                                            <a href="#" title="{{$data['roles_aliases']['titles'][$_group_name][$_v]}}">{{$_role}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="text-center">
                    {!! Form::submit('Edit Group', array('class' => 'btn brownBtn')) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    @endif
@endsection

@section('footer_scripts')
    <script src="/js/roles/addRoleGroup.js"></script>
@endsection