@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Recycling Processes</h1>
        <a href="{{ route('recycling.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nouveau processus</a>
    </div>

    @if(session('status'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('status') }}</div>
    @endif

    <div class="bg-white shadow rounded">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">ID</th>
                    <th class="p-3">Déchet</th>
                    <th class="p-3">Méthode</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3">Responsable</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($processes as $process)
                    <tr class="border-b">
                        <td class="p-3">{{ $process->id }}</td>
                        <td class="p-3">#{{ $process->waste_id }} ({{ optional($process->waste)->type }})</td>
                        <td class="p-3">{{ $process->method }}</td>
                        <td class="p-3">{{ $process->status }}</td>
                        <td class="p-3">{{ optional($process->responsibleUser)->name }}</td>
                        <td class="p-3 space-x-2">
                            <a class="text-blue-600" href="{{ route('recycling.show', $process) }}">Voir</a>
                            @if($process->status !== 'completed')
                                <a class="text-green-600" href="{{ route('recycling.complete', $process) }}">Terminer</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="6">Aucun processus</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $processes->links() }}</div>
</div>
@endsection

