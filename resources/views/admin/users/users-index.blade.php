@extends('layouts.coreui.admin')

@section('app-body-main-content')

    <div id="app">


        <user-s-p-a :user-id={{ Auth::user()->id_users }}></user-s-p-a>

    </div>

    <script type="application/javascript">
    var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        // console.log('Laravel = ' + Laravel['csrfToken'])
    </script>
@endsection
