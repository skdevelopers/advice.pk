@props([
    'uid',
    'name',
    'value' => '',
    'placeholder' => 'Write here...',
    'minHeight' => 'min-h-[200px]',
    'maxHeight' => 'max-h-[420px]',
])

<div
    class="w-full"
    data-quill-wrap
    data-quill-uid="{{ $uid }}"
    data-quill-placeholder="{{ $placeholder }}"
>
    <div
        id="toolbar_{{ $uid }}"
        class="border border-gray-300 rounded-t bg-gray-50 px-2 py-1 flex items-center gap-1"
    >
        <button type="button" class="ql-bold" aria-label="Bold"></button>
        <button type="button" class="ql-italic" aria-label="Italic"></button>
        <button type="button" class="ql-underline" aria-label="Underline"></button>
        <button type="button" class="ql-link" aria-label="Link"></button>
        <button type="button" class="ql-list" value="ordered" aria-label="Ordered list"></button>
        <button type="button" class="ql-list" value="bullet" aria-label="Bullet list"></button>
        <button type="button" class="ql-clean" aria-label="Clear formatting"></button>
    </div>

    <div
        id="editor_{{ $uid }}"
        class="border border-t-0 border-gray-300 rounded-b bg-white {{ $minHeight }} {{ $maxHeight }} overflow-y-auto"
    ></div>

    <input type="hidden" id="{{ $uid }}" name="{{ $name }}" value="{{ $value }}">
</div>
