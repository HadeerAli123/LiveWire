<div class="p-4 bg-white rounded-lg shadow">
    <h3 class="text-xl font-bold mb-4">العداد: {{ $count }}</h3>
    
    <div class="space-x-2">
        <button wire:click="increment" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
            +
        </button>
        
        <button wire:click="decrement" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            -
        </button>
    </div>
</div>