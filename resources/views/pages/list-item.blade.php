<div class="page">
    <h3>
        <a href="{{ $page->getUrl() }}" class="text-page">@icon('page'){{ $page->name }}</a>
    </h3>

    @if(isset($showMeta) && $showMeta)
        <div class="meta">
            <span class="text-book">@icon('book') {{ $page->book->name }}</span>
            @if($page->chapter)
                <span class="text-chapter">@icon('chapter') {{ $page->chapter->name }}</span>
            @endif
         </div>
    @endif

    @if(isset($page->searchSnippet))
        <p class="text-muted">{!! $page->searchSnippet !!}</p>
    @else
        <p class="text-muted">{{ $page->getExcerpt() }}</p>
    @endif
</div>