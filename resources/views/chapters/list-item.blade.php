<div class="chapter">
    <h3>
        <a href="{{ $chapter->getUrl() }}" class="text-chapter">
            @icon('chapter'){{ $chapter->name }}
        </a>
    </h3>
    @if(isset($chapter->searchSnippet))
        <p class="text-muted">{!! $chapter->searchSnippet !!}</p>
    @else
        <p class="text-muted">{{ $chapter->getExcerpt() }}</p>
    @endif

    @if(count($chapter->pages) > 0 && !isset($hidePages))
        <p class="text-muted chapter-toggle">@icon('arrow-right') @icon('page') <span>{{ count($chapter->pages) }} Pages</span></p>
        <div class="inset-list">
            @foreach($chapter->pages as $page)
                <h4><a href="{{$page->getUrl()}}" class="text-page">@icon('page'){{$page->name}}</a></h4>
            @endforeach
        </div>
    @endif
</div>