@extends('admin.master-admin-template')

@section('app-body-main-content')
    <div id="app">


        <xsens-s-p-a :user="{{Auth::user()}}"></xsens-s-p-a>

    </div>

    <script type="application/javascript">
        var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        // console.log('Laravel = ' + Laravel['csrfToken'])

    </script>

@endsection

