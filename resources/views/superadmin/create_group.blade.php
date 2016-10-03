@extends('layouts.admin_layout')

@section('title', 'Admin Panel - Role Groups')

@section('content')
    @parent
    <div class="container">
        <h3> Add Role Group </h3>
        <hr>
        <div class="row">
            {!! Form::open(['method' => 'post']) !!}
            <div class="text-center">
                <h6>Group Name</h6>
                {!! Form::text('name', '', array('placeholder'=>'Group Name', 'class' =>'form-control')) !!}
            </div>

            <div class="roles">
                @if(!empty($data['roles']))
                    @foreach($data['roles'] as $_group_name => $_role_group)
                        <div class="toggleBlock">
                            {!! Form::checkbox(null, 'value', null, ['class' => 'menuHandler']) !!}
                            <a href="#" class="toggleHeader" title="{{$data['roles_aliases']['titles'][$_group_name]['global']}}">{{$data['roles_aliases']['headers'][$_group_name]}}</a>
                            <ul class="toggle">
                            @foreach($_role_group as $_v => $_role)
                                <li class="toggleLi">
                                    {!! Form::checkbox('roles['.$_group_name.']['. $_v .']', $_role) !!}
                                    <a href="#" title="{{$data['roles_aliases']['titles'][$_group_name][$_v]}}">{{$_role}}</a>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="text-center">
                {!! Form::submit('Add Group', array('class' => 'btn brownBtn')) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('footer_scripts')
    <script src="/js/roles/addRoleGroup.js"></script>
@endsection