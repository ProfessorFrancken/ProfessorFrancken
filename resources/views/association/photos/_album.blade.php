@include('association.photos._photo', [
    'title' => $album->title,
    'amount_of_photos' => $album->amount_of_photos,
    'views' => $album->views,
    'photo' => $album->coverPhoto ?? $album->photos()->first(),
    'classes' => $classes ?? [],
    'href' => $album->url(),
])
