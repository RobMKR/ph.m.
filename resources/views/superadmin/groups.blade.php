@extends('layouts.admin_layout')

@section('title', 'Admin Panel - Role Groups')

@section('head_section')
    <script src="/js/jquery.magnific-popup.min.js"></script>
    <link href="/css/magnific-popup.css" rel="stylesheet">
@endsection

@section('content')
    @parent
    <div class="container">
        <h3> Groups </h3>
        <hr>
        @if(!empty($data['groups']))
            <ul class="list-group">
            @foreach($data['groups'] as $_group)
                <li class="userInfo list-group-item roles">
                    <span>
                        <strong>Group Name: </strong>{{$_group->name}}
                        <strong>Permissions: </strong><a href="#view-permissions" class="rolesExpand magnificPopup" data-permissions="{{$_group->options}}">View</a>
                        <strong>Created: </strong>{{$_group->created_at}}
                        <strong>Updated: </strong>{{$_group->updated_at}}

                    </span>
                    <a href="{{url('/admin/groups/edit/' . Hashids::encode($_group->id))}}" class="glyphicon glyphicon-pencil"></a>
                    <a href="{{url('/admin/groups/delete/' . Hashids::encode($_group->id))}}" class="glyphicon glyphicon-remove"></a>
                </li>
            @endforeach
            </ul>
        @endif
        <a href="{{url('/admin/groups/create')}}" class="btn btn-default">Create Role Group</a>
    </div>

    {{-- Permissions Popup --}}
    <div id="view-permissions" class="mgnPopup mfp-hide">
        <div class="permissionsPopup">

        </div>
    </div>
    <script>
        var roles = {!!$data['roles_aliases']!!};
    </script>
@endsection

@section('footer_scripts')
    <script src="/js/roles/roleGroups.js"></script>
@endsection