@extends('layouts.admin')

@section('title', 'Дашборд')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Админ-панель</h1>
    <p>Добро пожаловать, {{ auth()->user()->name }}!</p>
@endsection
