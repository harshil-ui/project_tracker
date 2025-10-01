<div>

    <div class="max-w-1/2 mx-auto p-6">

        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                class="mb-4 p-3 rounded-lg bg-green-100 text-green-800 border border-green-300">
                ✅ {{ session('message') }}
            </div>
        @endif

        <div x-data="{ open: @entangle('showModal') }" class="w-[17%]">
            <?php if($user->role == 'admin'){ ?>
            <button @click="open = true"
                class="bg-gray-500 text-white px-4 py-2 rounded float-right mb-2.5 hover:bg-gray-600">
                Add
            </button>
            <?php } ?>
            <div x-show="open" x-cloak
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-lg w-1/2 p-6 max-h-[80vh] overflow-y-auto relative ">

                    <button @click="open = false"
                        class="absolute top-2 right-2 text-gray-600 hover:text-gray-900 text-xl font-bold"
                        wire:click="resetInput">
                        &times;
                    </button>

                    <div class="my-6">
                        <form class="space-y-5" wire:submit.prevent="save">
                            <input type="hidden" wire:model="task_id">

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-gray-700 font-medium mb-2">Name</label>
                                    <input type="text" id="name" placeholder="Enter name" wire:model.live="name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                                   focus:outline-none focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500 transition" />
                                    @error('name')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                                        Select Due Date
                                    </label>
                                    <input type="date" id="due_date" name="due_date"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700"
                                        wire:model.live="due_date" />
                                    @error('due_date')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="priority" class="block text-gray-700 font-medium mb-2">
                                        Select Priority
                                    </label>
                                    <select id="priority" name="priority"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700"
                                        wire:model.live="priority">
                                        <option value="">-- Choose an option --</option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                        <option value="emergency">Emergency</option>
                                    </select>
                                    @error('priority')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-gray-700 font-medium mb-2">
                                        Select Status
                                    </label>
                                    <select id="status" name="status"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700"
                                        wire:model.live="status">
                                        <option value="">-- Choose an option --</option>
                                        <option value="to_do">Todo</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="done">Done</option>
                                    </select>
                                    @error('status')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="projects" class="block text-gray-700 font-medium mb-2">Projects</label>
                                    <select id="projects" name="projects"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-gray-700"
                                        wire:model.live="project_id">
                                        <option value="">-- Choose an option --</option>
                                        @foreach ($projects as $value)
                                            <option value="{{ $value->id }}">{{ $value->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="description"
                                        class="block text-gray-700 font-medium mb-2">Description</label>
                                    <textarea id="description" rows="4" placeholder="Enter description" wire:model.live="description"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg
                                   focus:outline-none focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500 transition resize-none"></textarea>
                                    @error('description')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="text-center" style="margin-bottom: 50px;">
                                <button type="submit"
                                    class="bg-gray-500 text-white px-4 py-2 rounded float-right mb-2.5 hover:bg-gray-600 float-left">
                                    {{ empty($this->task_id) ? 'Save' : 'Update' }}
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>


        <div class="overflow-hidden bg-white shadow-md rounded-xl w-3/4 mx-auto">
            <table class="table-auto w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Project</th>
                        <th class="px-6 py-3">Task name</th>
                        <th class="px-6 py-3">Description</th>
                        <th class="px-6 py-3">Priority</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Due date</th>
                        <?php if($user->role == 'admin') { ?>
                        <th class="px-6 py-3 text-right">Actions</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($tasks as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $item->id }}</td>
                            <td class="px-6 py-4">{{ $item->project->title }}</td>
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4">
                                <p class="truncate w-48">{{ $item->description }}</p>
                            </td>
                            <td class="px-6 py-4">{{ $item->priority }}</td>
                            <td class="px-6 py-4">{{ $item->status }}</td>
                            <td class="px-6 py-4">{{ $item->due_date }}</td>


                            <?php if($user->role == 'admin'){
                            ?>
                            <td class="px-6 py-4 text-right">
                                <button class="text-blue-500 hover:text-blue-700" title="Edit"
                                    wire:click="edit({{ $item->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </button>

                                <div x-data="{ confirmDelete: false }" class="inline-block">

                                    <button @click="confirmDelete = true" class="text-red-500 hover:text-red-700"
                                        title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v0a1 1 0 001 1h4a1 1 0 001-1v0a1 1 0 00-1-1m-4 0h4" />
                                        </svg>
                                    </button>

                                    <div x-show="confirmDelete" x-cloak
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                                        <div class="bg-white rounded-lg shadow-lg w-96 p-6 relative">
                                            <h2 class="text-lg font-semibold mb-4">Confirm Delete</h2>
                                            <p class="mb-6 text-gray-600">
                                                Are you sure you want to delete
                                                <span class="font-bold">{{ $item->name }}</span>?
                                            </p>

                                            <div class="flex justify-end space-x-3">
                                                <button @click="confirmDelete = false" type="button"
                                                    class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400">
                                                    Cancel
                                                </button>

                                                <button wire:click="delete({{ $item->id }})"
                                                    @click="confirmDelete = false" type="button"
                                                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                                                    Yes, Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <?php }
                            ?>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <div class="px-6 py-4">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>
