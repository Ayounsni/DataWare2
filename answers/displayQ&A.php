<?php
require_once('config/db.php');


$result_questions = mysqli_query($con, "SELECT  contenu FROM questions");

$result_id_questions = mysqli_query($con, "SELECT  id_question FROM questions");

$result_title = mysqli_query($con, "SELECT titre FROM questions");

$result_tags = mysqli_query($con, "SELECT nom_tag FROM tags");

$result_date = mysqli_query($con, "SELECT date_creation FROM questions");


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Q&A</title>
</head>

<body class="flex flex-col min-h-screen">
    <header class="antialiased fixed w-full top-0 z-10 ">
        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800 ">
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
    <div class="flex">
        <aside class="w-64 h-screen fixed top-16 left-0 px-4 overflow-y-auto bg-white border-r rtl:border-r-0 rtl:border-l dark:bg-gray-900 dark:border-gray-700 block z-10">
            <div class="flex flex-col justify-between flex-1 mt-6">
                <nav>
                    <a class="flex items-center px-4 py-2 mt-5 text-gray-600 transition-colors duration-300 transform rounded-md dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700" href="#">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">Home</span>
                    </a>

                    <a class="flex items-center px-4 py-2 mt-5 text-gray-600 transition-colors duration-300 transform rounded-md dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700" href="#">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">Quetions</span>
                    </a>

                    <a class="flex items-center px-4 py-2 mt-5 text-gray-600 transition-colors duration-300 transform rounded-md dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700" href="#">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 5V7M15 11V13M15 17V19M5 5C3.89543 5 3 5.89543 3 7V10C4.10457 10 5 10.8954 5 12C5 13.1046 4.10457 14 3 14V17C3 18.1046 3.89543 19 5 19H19C20.1046 19 21 18.1046 21 17V14C19.8954 14 19 13.1046 19 12C19 10.8954 19.8954 10 21 10V7C21 5.89543 20.1046 5 19 5H5Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">Tags</span>
                    </a>

                    <a class="flex items-center px-4 py-2 mt-5 text-gray-600 transition-colors duration-300 transform rounded-md dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-gray-200 hover:text-gray-700" href="#">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.3246 4.31731C10.751 2.5609 13.249 2.5609 13.6754 4.31731C13.9508 5.45193 15.2507 5.99038 16.2478 5.38285C17.7913 4.44239 19.5576 6.2087 18.6172 7.75218C18.0096 8.74925 18.5481 10.0492 19.6827 10.3246C21.4391 10.751 21.4391 13.249 19.6827 13.6754C18.5481 13.9508 18.0096 15.2507 18.6172 16.2478C19.5576 17.7913 17.7913 19.5576 16.2478 18.6172C15.2507 18.0096 13.9508 18.5481 13.6754 19.6827C13.249 21.4391 10.751 21.4391 10.3246 19.6827C10.0492 18.5481 8.74926 18.0096 7.75219 18.6172C6.2087 19.5576 4.44239 17.7913 5.38285 16.2478C5.99038 15.2507 5.45193 13.9508 4.31731 13.6754C2.5609 13.249 2.5609 10.751 4.31731 10.3246C5.45193 10.0492 5.99037 8.74926 5.38285 7.75218C4.44239 6.2087 6.2087 4.44239 7.75219 5.38285C8.74926 5.99037 10.0492 5.45193 10.3246 4.31731Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="mx-4 font-medium">Settings</span>
                    </a>
                </nav>
            </div>
        </aside>
        <main class="flex-1 p-4 ml-64 pt-16">
            <div class="flex justify-between px-16 mt-4">
                <span class="font-bold	text-lg	">Top Questions</span>

                <button disabled="" type="button" class="relative flex items-center justify-center w-36 px-6 py-3 text-sm font-medium text-white transition-colors duration-300 rounded-lg pointer-events-auto bg-blue-950 hover:bg-blue-900 focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-700">
                    <a href="add Q/Add Questions.php">
                        <span>Add Questions</span>
                    </a>
                </button>

            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4 mt-4">
                <?php
                while (
                    ($row_title = mysqli_fetch_array($result_title)) &&
                    ($row_questions = mysqli_fetch_array($result_questions)) &&
                    ($row_tags = mysqli_fetch_array($result_tags)) &&
                    ($row_id_questions = mysqli_fetch_array($result_id_questions))
                ) {
                ?>
                    <div class="max-w-2xl w-full bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="p-4">
                            <p class="inline-block text-xl font-bold text-gray-700 dark:text-white hover:text-gray-600 dark:hover:text-gray-200 hover:underline mt-2" tabindex="0" role="link">
                                <?php echo $row_title['titre']; ?>
                            </p>
                            <p class="text-md text-white dark:text-white hover:text-gray-600 dark:hover:text-gray-200">
                                <?php echo $row_questions['contenu']; ?>
                            </p>
                        </div>

                        <div class="flex items-center justify-between mt-4 mt-3">
                            <button type="button" class="mb-3 w-36 px-6 py-3 text-sm font-medium text-white transition-colors duration-300 rounded-lg pointer-events-auto bg-blue-950 hover:bg-blue-900 focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-700">
                                <p><?php echo $row_tags['nom_tag']; ?></p>
                            </button>

                            <form method="post" action="delete Q/deleteQuestionform.php">
                                <input type="hidden" name="id_question" value="<?php echo $row_id_questions['id_question']; ?>">
                                <button type="submit" class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none j-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                            <form method="post" action="modify Q/modifyQuestionform.php">
                            <input type="hidden" name="contenu" value="<?php echo $row_questions['contenu']; ?>">
                                <button type="submit" class="text-gray-500 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                            </form>
                            <form method="post" action="Answers/displayQ&A.php">
                            <input type="hidden" name="contenu" value="<?php echo $row_questions['contenu']; ?>">
                                <button type="submit" class="text-gray-500 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>

        </main>

</body>

</html>