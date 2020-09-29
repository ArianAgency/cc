@extends('layouts.coreui.admin')

@section('app-body-main-content')
    <div id="app">
        <business-s-p-a ></business-s-p-a>

        {{--        <businesses-table-component></businesses-table-component>--}}
        {{--        <new-business-creation-form></new-business-creation-form>--}}

    </div>

    <script type="application/javascript">
        var Laravel = {
            'csrfToken': '{{csrf_token()}}'
        };
        console.log('Laravel = ' + Laravel['csrfToken'])
    </script>

@endsection

