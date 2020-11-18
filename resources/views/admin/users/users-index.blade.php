@extends('layouts.coreui.admin')

@section('app-body-main-content')

    <div id="app">


        <user-s-p-a :user="{{Auth::user()}}" ></user-s-p-a>

    </div>

    <script type="application/javascript">
    var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        // console.log('Laravel = ' + Laravel['csrfToken'])

    </script>
@endsection
