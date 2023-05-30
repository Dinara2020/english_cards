@extends('layouts.app')
@section('title', '')
@section('content')
    <div id="words">
        <div v-for="(word) in items">
            <card-small :word="word"></card-small>
        </div>
    </div>
@endsection
