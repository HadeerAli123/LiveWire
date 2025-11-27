<div class="w-50 m-outo mt-5">

    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
<button wire:click="flash">click here </button>
</div>
