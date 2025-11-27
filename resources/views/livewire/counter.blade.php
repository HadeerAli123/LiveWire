<div class="p-4 bg-white rounded-lg shadow">
    <h3 class="text-xl font-bold mb-4">العداد: {{ $active }}</h3>
    
    <div class="space-x-2">
        <button wire:click="$toggle('active' )" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    <!-- <button wire:click="$toggle('active' )" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"> -->

<!--         <button wire:click="$set('count',10)" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
 -->
            +
        </button>
        
        <button wire:click="decrement" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
            -
        </button>
    </div>

<div class ="mb-5">
    @livewire('fetch-component')
</div>


<!-- using magic function s
 
1- set()
عمل سيت للقيمة من صفر ل10 

2- toggle()
-->