<x-inupress::layout :title="$page->title" :description="$page->excerpt">
    <article class="inupress-prose">
        <h1>{{ $page->title }}</h1>
        {!! $html !!}
    </article>
</x-inupress::layout>
