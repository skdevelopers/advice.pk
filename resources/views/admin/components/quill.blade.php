@props([
    'id',
    'name',
    'height' => 'min-h-[220px]',
    'value' => ''
])

<div class="mb-4">
    <div id="toolbar_{{ $id }}"
         class="border border-gray-300 rounded-t bg-gray-50 px-2 py-1 flex gap-1">
        <button type="button" class="ql-bold"></button>
        <button type="button" class="ql-italic"></button>
        <button type="button" class="ql-underline"></button>
        <button type="button" class="ql-link"></button>
        <button type="button" class="ql-list" value="ordered"></button>
        <button type="button" class="ql-list" value="bullet"></button>
        <button type="button" class="ql-clean"></button>
    </div>

    <div
        id="editor_{{ $id }}"
        class="border border-t-0 border-gray-300 rounded-b
               {{ $height }} max-h-[420px] overflow-y-auto
               bg-white dark:bg-slate-800
               text-gray-900 dark:text-gray-100">
    </div>

    <input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}">
</div>
