@extends('layouts.coreui.admin')

@section('app-body-main-content')

    <div id="app">

                <customer-tag-s-p-a :user="{{Auth::user()}}" ></customer-tag-s-p-a>

    </div>

    <script type="application/javascript">
        var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        console.log('Laravel = ' + Laravel['csrfToken'])
    </script>
@endsection
