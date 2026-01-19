@props([
    'uid',
    'name',
    'value' => '',
    'placeholder' => 'Write here...',
    'minHeight' => 'min-h-[220px]',
    'maxHeight' => 'max-h-[420px]',
    'ai' => false,
    'aiType' => '',
])

<div
    class="w-full"
    data-quill-wrap
    data-quill-uid="{{ $uid }}"
    data-quill-placeholder="{{ $placeholder }}"
>
    {{-- Toolbar --}}
    <div
        id="toolbar_{{ $uid }}"
        class="border border-gray-300 rounded-t bg-gray-50 dark:bg-slate-900
               px-2 py-1 flex flex-wrap items-center gap-1"
    >
        <button type="button" class="ql-bold"></button>
        <button type="button" class="ql-italic"></button>
        <button type="button" class="ql-underline"></button>
        <button type="button" class="ql-link"></button>
        <button type="button" class="ql-list" value="ordered"></button>
        <button type="button" class="ql-list" value="bullet"></button>
        <button type="button" class="ql-clean"></button>

        @if($ai)
            <div class="ml-auto flex items-center gap-1">
                <button
                    type="button"
                    class="inline-flex items-center justify-center w-8 h-8 rounded
                           bg-indigo-600 text-white hover:bg-indigo-700"
                    data-ai-generate
                    data-ai-type="{{ $aiType }}"
                    title="Generate"
                >🤖</button>

                <button
                    type="button"
                    class="inline-flex items-center justify-center w-8 h-8 rounded
                           bg-slate-200 hover:bg-slate-300"
                    data-ai-rewrite
                    data-ai-type="{{ $aiType }}"
                    title="Rewrite"
                >✍️</button>

                <button
                    type="button"
                    class="inline-flex items-center justify-center w-8 h-8 rounded
                           bg-slate-200 hover:bg-slate-300"
                    data-ai-expand
                    data-ai-type="{{ $aiType }}"
                    title="Expand"
                >➕</button>

                <button
                    type="button"
                    class="inline-flex items-center justify-center w-8 h-8 rounded
                           bg-slate-200 hover:bg-slate-300"
                    data-ai-shorten
                    data-ai-type="{{ $aiType }}"
                    title="Shorten"
                >➖</button>
            </div>
        @endif
    </div>

    {{-- Editor --}}
    <div
        id="editor_{{ $uid }}"
        class="border border-t-0 border-gray-300 rounded-b
               {{ $minHeight }} {{ $maxHeight }} overflow-y-auto
               bg-white dark:bg-slate-800
               text-gray-900 dark:text-gray-100"
    ></div>

    {{-- Hidden field --}}
    <input
        type="hidden"
        id="{{ $uid }}"
        name="{{ $name }}"
        value="{{ $value }}"
        data-quill-hidden
    >
</div>
