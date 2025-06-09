<div class="flex items-center justify-end gap-3">
    <a href="{{ route('admin.society-pages.edit', $page->id) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
    <button @click="$dispatch('deletePage', {{ $page->id }})" class="text-red-600 hover:text-red-800">Delete</button>
</div>
