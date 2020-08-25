@extends('layouts/app')
@section('title','Businesses')
@section('content')

    <h1>Businesses</h1>


    {{--    @forelse($businesses as $business)--}}
    {{--        <p style="margin: 50px">{{$business->company_name}}</p>--}}
    {{--    @empty--}}
    {{--        <p>no business</p>--}}
    {{--    @endforelse--}}
    {{--    <p>dfnifgudiosjoLVUDBIDBYHSKOFBHDFSJK</p>--}}


    <table>
        <thead>
        <tr>
            <th> id</th>
            <th> نام شرکت</th>
            <th> تاریخ تاسیس</th>
            <th> email</th>
            <th> تلفن</th>
            <th> آدرس</th>
        </tr>  
        </thead>
        <tbody>
        @foreach($businesses as $business)
            <tr>
                <td> {{$business->id_businesses}} </td>
                <td> {{$business->brand_name}} </td>
                <td> {{$business->foundation_date}} </td>
                <td> {{$business->email}} </td>
                <td> {{$business->phone}} </td>
                <td> {{$business->address}} </td>

            </tr>
        @endforeach
        </tbody>
    </table>
@endsection


