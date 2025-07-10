<div id="listingsContainer">
    <div class="row">
        @foreach ($listings as $listing)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="overflow-hidden">
                    @php
                        $images = $listing->image_url;
                        $firstImage = (is_array($images) && !empty($images)) ? $images[0] : (is_string($images) ? json_decode($images, true)[0] ?? null : null);
                    @endphp
                    @if ($firstImage)
                        <img class="img-fluid" src="{{ asset('storage/' . $firstImage) }}" alt="{{ $listing->title }}" style="height: 300px; object-fit: cover;">
                    @else
                        <img class="img-fluid" src="img/placeholder.jpg" alt="No Image" style="height: 200px; object-fit: cover;">
                    @endif
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $listing->title }}</h5>
                    <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>{{ $listing->location_city }}</p>
                    <p class="card-text"><strong>{{ number_format($listing->price_per_night, 2) }} DT</strong></p>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('listings.edit', $listing->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('listings.destroy', $listing->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this hotel?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div id="paginationContainer" class="pagination justify-content-center mt-4">
    {{ $listings->links() }}
</div>