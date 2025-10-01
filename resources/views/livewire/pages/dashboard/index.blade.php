<div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-4">
                <!-- Card 1 -->
                <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-full">
                        <!-- Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3v4M8 3v4m-5 4h18" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Projects</p>
                        <p class="text-xl font-semibold">{{ $totalProjects }}</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4">
                    <div class="p-3 bg-green-100 text-green-600 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Completed Tasks</p>
                        <p class="text-xl font-semibold">{{ $completedTasks }}</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4">
                    <div class="p-3 bg-yellow-100 text-yellow-600 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Pending Tasks</p>
                        <p class="text-xl font-semibold">{{ $pendingTasks }}</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4">
                    <div class="p-3 bg-red-100 text-red-600 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Overdue Tasks</p>
                        <p class="text-xl font-semibold">{{ $overDueTasks }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
