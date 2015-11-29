
<div class="book-tree">
    <h6 class="text-muted">Book Navigation</h6>
    <ul class="sidebar-page-list menu">
        <li class="book-header"><a href="{{$book->getUrl()}}" class="book {{ $current->matches($book)? 'selected' : '' }}">@icon('book'){{$book->name}}</a></li>


        @foreach($sidebarTree as $bookChild)
            <li class="list-item-{{ $bookChild->getName() }} {{ $bookChild->getName() }}">
                <a href="{{$bookChild->getUrl()}}" class="{{ $bookChild->getName() }} {{ $current->matches($bookChild)? 'selected' : '' }}">
                    @if($bookChild->isA('chapter'))@icon('chapter')@else @icon('page')@endif{{ $bookChild->name }}
                </a>

                @if($bookChild->isA('chapter') && count($bookChild->pages) > 0)
                    <p class="text-muted chapter-toggle @if($bookChild->matchesOrContains($current)) open @endif">
                        @icon('arrow-right') @icon('page') <span>{{ count($bookChild->pages) }} Pages</span>
                    </p>
                    <ul class="menu sub-menu inset-list @if($bookChild->matchesOrContains($current)) open @endif">
                        @foreach($bookChild->pages as $childPage)
                            <li class="list-item-page">
                                <a href="{{$childPage->getUrl()}}" class="page {{ $current->matches($childPage)? 'selected' : '' }}">
                                    @icon('page') {{ $childPage->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif


            </li>
        @endforeach


    </ul>
</div>
