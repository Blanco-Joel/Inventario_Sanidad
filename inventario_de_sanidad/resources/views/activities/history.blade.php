@extends('layout.app')

@section('title', 'Historial de actividades')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/activityHistory.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tables.css') }}">
@endpush

@section('content')
    <div class="">
        <h1 class="activities-title">Historial de actividades</h1>
        <div class="activities-section">
            @forelse($activities as $activity)
                <div class="activity-card">
                    <div class="activity-header">
                        {{ $activity->created_at->format('d/m/Y H:i') }}  
                    </div>
                    <div class="">
                        <p><strong>Descripción:</strong> {{ $activity->title }}</p>

                        @if($activity->materials->isEmpty())
                            <p><em>No se usaron materiales.</em></p>
                        @else
                            <div class="table-wrapper">
                                <table class="table activity-table">
                                    <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($activity->materials as $material)
                                        <tr>
                                        <td>{{ $material->name }}</td>
                                        <td>{{ $material->pivot->units }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <p>No has registrado ninguna actividad aún.</p>
            @endforelse

                {{-- Mensajes flash --}}
                @if(session('success'))
                    <div class="alert alert-success">
                    {{ session('success') }}
                    </div>
                @endif

                {{-- Mensajes de error --}}
                @if(session('error'))
                    <div class="alert alert-error-uspas">
                    {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/activity.js') }}" type="text/javascript"></script>
@endpush