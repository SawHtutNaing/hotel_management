<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Room Type Management</h1>
        <button wire:click="openCreateModal" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Room Type
        </button>
    </div>

    <!-- Room Types Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($room_types as $roomType)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $roomType->name }}</td>
                        <td class="px-6 py-4">{{ $roomType->description ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($roomType->base_price, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button wire:click="editRoomType({{ $roomType->id }})" class="text-blue-600 hover:text-blue-900 mr-4">Edit</button>
                            <button wire:click="deleteRoomType({{ $roomType->id }})" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Are you sure you want to delete this room type?')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    <div wire:model="showCreateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full @if(!$showCreateModal) hidden @endif">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h2 class="text-lg font-bold mb-4">Create New Room Type</h2>
            <form wire:submit.prevent="createRoomType">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Base Price</label>
                    <input type="number" wire:model="base_price" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('base_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="button" wire:click="closeModal" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div wire:model="showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full @if(!$showEditModal) hidden @endif">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h2 class="text-lg font-bold mb-4">Edit Room Type</h2>
            <form wire:submit.prevent="updateRoomType">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Base Price</label>
                    <input type="number" wire:model="base_price" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    @error('base_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end">
                    <button type="button" wire:click="closeModal" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('livewire:initialized', () => {
    Livewire.on('notify', (event) => {
        alert(event.message); // Simple notification, replace with your preferred notification system
    });
});
</script>
@endpush
