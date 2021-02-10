@extends('admin.master-admin-template')

@section('app-body-main-content')
    <div id="app">


        <purchase-history-table-component :user="{{ Auth::user() }}">

        </purchase-history-table-component>

    </div>

    <script type="application/javascript">
        var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        // console.log('Laravel = ' + Laravel['csrfToken'])

    </script>

@endsection
