@extends('layouts.coreui.admin')

@section('app-body-main-content')

    <div id="app">


        <customer-s-p-a user="{{Auth::user()}}" active-view="{{$activeView}}"></customer-s-p-a>

    </div>

    <script type="application/javascript">
        var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        }
        // console.log('Laravel = ' + Laravel['csrfToken'])
    </script>
@endsection
