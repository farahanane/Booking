<div class="content">
    @if ($reservations->count())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Hotel</th>
                        <th>Location</th>
                        @if (Auth::user()->email === 'admin@gmail.com')
                            <th>Client</th>
                        @endif
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Travelers</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reservations as $reservation)
                        <tr>
                            <td>
                                @if ($reservation->listing)
                                    {{ $reservation->listing->title }}
                                @else
                                    <span class="text-danger">Listing Not Found</span>
                                @endif
                            </td>
                            <td>
                                @if ($reservation->listing)
                                    {{ $reservation->listing->location_city }}
                                @else
                                    N/A
                                @endif
                            </td>
                            @if (Auth::user()->email === 'admin@gmail.com')
                                <td>{{ $reservation->user->name }} ({{ $reservation->user->email }})</td>
                            @endif
                            <td>{{ $reservation->start_date->format('Y-m-d') }}</td>
                            <td>{{ $reservation->end_date->format('Y-m-d') }}</td>
                            <td>{{ $reservation->number_of_travelers }} Traveler{{ $reservation->number_of_travelers > 1 ? 's' : '' }}</td>
                            <td>{{ number_format($reservation->total_price, 2) }} DT</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="pagination justify-content-center mt-4">
            {{ $reservations->links() }}
        </div>
    @else
        <p class="text-center">No reservations found.</p>
    @endif
</div>