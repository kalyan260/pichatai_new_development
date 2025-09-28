@extends('layouts.error')
@section('title',__('Access Denied').' : 403')
@section('error_code','403')
@section('error_details',__('You do not have permission to access this.'))
@section('custom-script')
<script>
    const myTimeout = setTimeout(myGreeting, 4000);
    function myGreeting() {
        window.location.href = '{{ route('unauthorized-login') }}';
    }
</script>
@endsection
