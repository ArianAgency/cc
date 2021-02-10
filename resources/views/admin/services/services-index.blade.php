@extends('admin.master-admin-template')

@section('app-body-main-content')
    <div id="app">


        <service-s-p-a active-view="{{$activeView}}" :user-id={{ Auth::user()->id_users }} ></service-s-p-a>

    </div>

    <script type="application/javascript">
        var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        // console.log('Laravel = ' + Laravel['csrfToken'])

    </script>

@endsection

