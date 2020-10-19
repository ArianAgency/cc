@extends('layouts.coreui.admin')

@section('app-body-main-content')
    <div id="app">


        <services-xsense-junction-s-p-a :user-id={{ Auth::user()->id_users }}></services-xsense-junction-s-p-a>

    </div>

    <script type="application/javascript">
        var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        // console.log('Laravel = ' + Laravel['csrfToken'])

    </script>

@endsection
