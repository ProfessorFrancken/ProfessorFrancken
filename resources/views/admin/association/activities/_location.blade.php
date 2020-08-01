<div class="card mb-4">
    <div class="card-body">
        <h4 class="font-weight-bold">
            <i class="fas fa-map-marker"></i>
            Location
        </h4>
        <p>
            {{ $activity->location() }}
        </p>

        <div>
            <iframe
                frameborder="0"
                style="border:0; width: 100%; height: 500px"
                src="{{ $activity->googleMapsEmbedUri() }}" allowfullscreen
            ></iframe>
        </div>
    </div>
</div>
