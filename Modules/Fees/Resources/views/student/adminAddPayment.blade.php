@extends('backEnd.master')
@section('title')
@lang('fees::feesModule.add_fees_payment')
@endsection
@section('mainContent')
@include('fees::AdmissionFeesPayment',['role'=>'admin'])
@endsection