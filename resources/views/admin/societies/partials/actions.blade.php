<div class="flex items-center space-x-2">
    {{-- Edit --}}
    <a href="{{ route('admin.societies.edit', $society->id) }}" title="Edit">
        <i data-feather="edit-3" class="text-blue-600 w-5 h-5 hover:text-blue-800"></i>
    </a>

    @if (!$society->deleted_at)
        {{-- Soft Delete --}}
        <button type="button" title="Delete"
                onclick="deleteSociety({{ $society->id }})">
            <i data-feather="trash-2" class="text-red-600 w-5 h-5 hover:text-red-800"></i>
        </button>
    @else
        {{-- Restore --}}
        <button type="button" title="Restore"
                onclick="restoreSociety({{ $society->id }})">
            <i data-feather="rotate-ccw" class="text-green-600 w-5 h-5 hover:text-green-800"></i>
        </button>
    @endif
</div>
