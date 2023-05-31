<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                </div>

                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex">
                        <div class="border-gray-300 border flex-1 rounded-md overflow-hidden">
                            <h2 class="bg-gray-100 p-3">Add New Country</h2>
                            <form class="form" method="post" action="/countries">
                                <div class="p-4">
                                @csrf
                                <div class="mb-5">
                                    <label for="name" class="text-sm text-gray-500 mb-1 block">Name</label>
                                    <input type="text" name="name" id="name" class="rounded block w-full">
                                </div>
                                <div>
                                    <label for="iso" class="text-sm text-gray-500 mb-1 block">ISO</label>
                                    <input type="text" name="iso" id="iso" class="rounded block w-full">
                                </div>
                            </div>
                                <div class="bg-gray-100 p-3">
                                    <button type="submit" class="bg-black text-white rounded py-1 px-5 text-sm ms-auto block">SAVE</button>
                                </div>
                            </form>
                        </div>
                        <div class="border-gray-300 border w-3/4 ms-5 rounded-md overflow-hidden">
                            <h2 class="bg-gray-100 p-3">List of countries</h2>
                            <div class="p-5">
                                <div class="w-full table-auto text-start ">
                                    <div class="border-t p-3 flex w-full justify-between align-middle">
                                        <strong class="w-1/12">#</strong>
                                        <strong class="w-1/3">Country</strong>
                                        <strong class="w-1/3">ISO</strong>
                                        <strong class="w-1/12">Edit</strong>
                                        <strong class="w-1/12">Delete</strong>
                                    </div>
                                    @foreach ($countries as $item)
                                    <form class="border-t p-3 flex justify-between w-full align-middle" data-id="{{ $item->id }}">
                                        <span class="flex-0 w-1/12">{{ $loop->iteration }}</span>
                                        <input type="text" class="editable-name w-1/3 border-0 ps-0" name="name" value="{{ $item->name }}">
                                        <input type="text" class="editable-iso w-1/3 border-0 ps-0" name="iso" value="{{ $item->iso }}">
                                        <span class="w-1/12 flex align-middle">
                                            <button class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-4 rounded edit" data-id="{{ $item->id }}">Edit</button>
                                        </span>
                                        <span class="w-1/12 flex align-middle">
                                            <button class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-4 rounded delete" data-id="{{ $item->id }}">Delete</button>
                                        </span>
                                    </form>
                                @endforeach
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    (function() {
        const editBtns = document.querySelectorAll('button.edit')
        const deleteBtns = document.querySelectorAll('button.delete')

        editBtns.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                id = e.target.dataset.id

                const form = document.querySelector(`form[data-id="${id}"]`)
                const name = form.name.value
                const iso = form.iso.value

                if(!iso || !name){
                    alert('You must enter a value!')
                    return
                }

                const csrfToken = document.querySelector('input[type="hidden"][name="_token"]').value

                fetch(`/countries/${id}`, {
                    method: 'PUT',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        name,
                        iso
                    })
                })
                .then(res => res.json())
                .then(res => console.log(res))
                .catch(err => console.error(err))
            })
        });

        deleteBtns.forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                id = e.target.dataset.id

                const form = document.querySelector(`form[data-id="${id}"]`)

                const csrfToken = document.querySelector('input[type="hidden"][name="_token"]').value

                fetch(`/countries/${id}`, {
                    method: 'DELETE',
                    headers: {
                        "Content-Type": "application/json",
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(res => res.json())
                .then(res => form.remove())
                .catch(err => console.error(err))
            })
        });
    })()
</script>



