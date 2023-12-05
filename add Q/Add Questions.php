<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>

<body class="flex flex-col min-h-screen">
    <header class="antialiased ">
        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
            <div class="flex flex-wrap justify-between items-center">
                <div class="flex justify-between items-center">
                    <button id="toggleSidebar" aria-expanded="true" aria-controls="sidebar" class="p-2 mr-3 text-gray-600 rounded cursor-pointer lg:inline hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                        <svg class="  w-5 h-5 md:hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h14M1 6h14M1 11h7" />
                        </svg>
                    </button>
                    <a href="https://flowbite.com" class="flex mr-4">
                        <span class=" hidden md:inline-block  self-center text-2xl font-semibold whitespace-nowrap dark:text-white ">DataWare</span>
                    </a>
                </div>
                <form class="hidden lg:block lg:px-16">
                    <label for="topbar-search" class="sr-only">Search</label>
                    <div class="relative mt-1 lg:w-96">
                        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="email" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-9 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 " placeholder="Search">
                    </div>
                </form>
            </div>
            </div>
        </nav>
    </header>
    <main class="flex-1 p-4 items-center">
        <form method="post" action="postQuestion.php" class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-md ">
            <div class="mb-4">
                <label for="question" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input name="title" rows="4" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-primary-500"></input>
                <label for="question" class="block text-gray-700 text-sm font-bold mb-2">Question</label>
                <input name="question" rows="4" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-primary-500"></input>
                <label for="question" class="block text-gray-700 text-sm font-bold mb-2">Tags</label>
                <input name="Tag" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:border-primary-500"></input>
            </div>
            <div class="flex justify-end">
                <button type="submit" class=" mr-4 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-primary-700">
                    Discart Draft
                </button>
                <button name="post" type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-600 focus:outline-none focus:ring focus:border-primary-700">
                    Post Question
                </button>
            </div>
        </form>
    </main>
</body>

</html>