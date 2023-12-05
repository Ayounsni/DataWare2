<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_question'])) {
    // Fetch the project name from the form
    $id_question = $_POST['id_question'];

    // Display a form to confirm deletion
    echo '<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
    <section class="bg-white dark:bg-gray-900 h-screen flex justify-center items-center">
    <div class="px-6 py-16 mx-auto text-center">
        <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">are you  really sure you wanna  delete this Question ?</h1>
        <p class="max-w-md mx-auto mt-5 text-gray-500 dark:text-gray-400">Warning: If you delete this project, you won\'t be able to recover it.</p>

        <form method="post" action="deleteQuestion.php" class="flex flex-col mt-8 space-y-3 sm:space-y-0 sm:flex-row sm:justify-center sm:-mx-2">
            <input type="hidden" name="id_question" value="' . $id_question . '">
            <button type="submit" class="px-4 py-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-700 rounded-md sm:mx-2 hover:bg-blue-600 focus:outline-none focus:bg-blue-600">
                Delete
            </button>
        </form>
    </div>
</section>
</body>
</html>

';
} else {
}

?>
