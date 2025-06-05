@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-bold mb-6">Мои бронирования</h1>

    @if($reservations->isEmpty())
        <p class="text-gray-600">У вас пока нет активных туров или бронирований.</p>
    @else
        <div class="space-y-6">
            @foreach($reservations as $reservation)
                <div class="bg-white p-5 rounded shadow border">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl font-semibold">{{ $reservation->tour_name }}</h2>
                        <span class="text-sm text-gray-500">{{ $reservation->created_at->format('d.m.Y') }}</span>
                    </div>

                    <p class="text-sm text-gray-700 mb-2">
                        Статус: <strong>{{ ucfirst($reservation->status) }}</strong><br>
                        Текущий этап: <strong>{{ $reservation->current_step }}</strong>
                    </p>

                    <div class="w-full bg-gray-200 h-2 rounded overflow-hidden mb-2">
                        <div class="bg-blue-600 h-full" style="width: {{ $reservation->progress_percent }}%"></div>
                    </div>

                    <div class="text-right">
                        <a href="#" class="text-sm text-blue-600 hover:underline">Подробнее</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection