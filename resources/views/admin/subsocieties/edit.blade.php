@extends('admin.layouts.app')

@section('title', 'Edit Sub-Society')

@section('content')
    <div class="container-fluid relative px-3">
        <div class="layout-specing">
            <div class="md:flex justify-between items-center">
                <h5 class="text-lg font-semibold">Edit Sub-Society</h5>
                <a href="{{ route('admin.subsocieties.index') }}" class="btn bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">Back</a>
            </div>

            <div class="mt-6 bg-white dark:bg-slate-900 rounded shadow p-6"
                 x-data="editSub({{ $subsociety->toJson() }})">
                <form @submit.prevent="submit" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium">Parent Society<span class="text-red-500">*</span></label>
                        <select name="society_id" x-model="form.society_id" class="w-full border rounded px-3 py-2" required>
                            <option value="">Select</option>
                            @foreach($societies as $soc)
                                <option value="{{ $soc->id }}">{{ $soc->society_name }}</option>
                            @endforeach
                        </select>
                        <p class="text-red-600 text-sm" x-text="errors.society_id" x-show="errors.society_id"></p>
                    </div>

                    <div>
                        <label class="block font-medium">Name<span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="form.name" class="w-full border rounded px-3 py-2" required>
                        <p class="text-red-600 text-sm" x-text="errors.name" x-show="errors.name"></p>
                    </div>

                    <div>
                        <label class="block font-medium">Slug<span class="text-red-500">*</span></label>
                        <input type="text" name="slug" x-model="form.slug" class="w-full border rounded px-3 py-2" required>
                        <p class="text-red-600 text-sm" x-text="errors.slug" x-show="errors.slug"></p>
                    </div>

                    <div>
                        <label class="block font-medium">Type</label>
                        <input type="text" name="type" x-model="form.type" class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium">Detail</label>
                        <textarea name="detail" x-model="form.detail" class="w-full border rounded px-3 py-2" rows="3"></textarea>
                    </div>

                    <div class="text-right">
                        <button type="submit" :disabled="submitting"
                                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            <span x-show="!submitting">Update</span>
                            <span x-show="submitting">Updating…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
    @push('scripts')
        <script>
            document.getElementById('name').addEventListener('input', function () {
                // Replace multiple - with single -
                document.getElementById('slug').value = this.value.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove invalid chars
                    .trim()
                    .replace(/\s+/g, '-')         // Replace spaces with -
                    .replace(/-+/g, '-');
            });
            function editSub(data){
                return {
                    submitting: false,
                    form: { ...data },
                    errors: {},
                    async submit(){
                        this.submitting = true;
                        this.errors = {};
                        try {
                            await axios.put(`/admin/subsocieties/${this.form.id}`, this.form);
                            showToast('Updated!','success');
                            setTimeout(()=> location.href='{{ route('admin.subsocieties.index') }}',800);
                        } catch (e){
                            if (e.response?.data?.errors) this.errors = e.response.data.errors;
                            else showToast('Failed','error');
                        } finally { this.submitting = false; }
                    }
                }
            }
        </script>
    @endpush

