@extends('layouts.master')

@section('title')
Laravel data viewer

@endsection

@section('content')
	<data-viewer source="api\customers" title="Customer Data "></data-viewer>
@endsection
