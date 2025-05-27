<div
        x-data="{ show: false, type: 'info', message: '', timeout: 4000 }"
        x-show="show"
        x-transition.opacity
        x-cloak
        @toast.window="type = $event.detail.type; message = $event.detail.message; show = true; setTimeout(() => show = false, timeout)"
        class="fixed top-6 right-6 z-50"
>
    <template x-if="message">
        <div
                x-bind:class="{
                'bg-green-100 text-green-800 border-green-300': type === 'success',
                'bg-red-100 text-red-800 border-red-300': type === 'error',
                'bg-yellow-100 text-yellow-800 border-yellow-300': type === 'warning',
                'bg-blue-100 text-blue-800 border-blue-300': type === 'info'
            }"
                class="border px-4 py-2 rounded-md shadow-lg text-sm"
        >
            <div class="flex justify-between items-center space-x-2">
                <span x-text="message"></span>
                <button @click="show = false" class="text-xl font-bold leading-none">&times;</button>
            </div>
        </div>
    </template>
</div>
