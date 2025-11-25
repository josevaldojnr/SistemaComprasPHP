@extends('layout')

@section('title', 'Dashboard')

@section('content')
@auth
    <h1 class="text-2xl font-bold mb-4">
      Bem-vindo, {{ auth()->user()->name }} 👋
    </h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
      <h2 class="text-xl font-semibold mb-4">Visão Geral das Requisições</h2>

      {{-- Inclui o componente Blade que substitui AllRequests.php --}}
      @includeIf('components.allrequests')
    </div>
@else
    {{-- Se não estiver autenticado redireciona para login --}}
    <script>window.location = "{{ route('login.form') }}";</script>
@endauth
@endsection
