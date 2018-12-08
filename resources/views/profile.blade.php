@extends('layout_user.master')

@section('content')
    @include('layout_user.profile')
@endsection

@section('script')
    @if(session('payment'))
        <script>
            $(document).ready(function() {
                localStorage.clear();
            })
        </script>
    @endif
@endsection
