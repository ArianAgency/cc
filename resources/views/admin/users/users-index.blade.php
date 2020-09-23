@extends('layouts.coreui.admin')

@section('app-body-main-content')

    <div id="app">


{{--        <user-table-component></user-table-component>--}}

{{--        <new-user-creation-form></new-user-creation-form>--}}


        <user-s-p-a></user-s-p-a>

    </div>

    <script>
        var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        console.log('Laravel = ' + Laravel['csrfToken'])
    </script>
@endsection
