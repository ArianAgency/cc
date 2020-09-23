@extends('layouts.coreui.admin')

@section('app-body-main-content')

    <div id="app">


<customer-s-p-a></customer-s-p-a>

    </div>

    <script>
        var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        console.log('Laravel = ' + Laravel['csrfToken'])
    </script>
@endsection
