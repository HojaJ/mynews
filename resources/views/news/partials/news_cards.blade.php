@foreach($news as $item)
<div class="mb-4">
    <a href="{{ route('news.show', $item->id) }}" class="card h-100">
        <div class="card-body">
            <h5 class="card-title">{{ $item->name }}</h5>
        </div>
    </a>
</div>
@endforeach 