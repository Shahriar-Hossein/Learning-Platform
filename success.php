<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-lg text-center">
        <div class="flex justify-center items-center mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 10-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Payment Successful!</h1>
        <p class="text-gray-600 text-lg mb-6">
            Thank you for your payment! Your transaction has been completed successfully.
        </p>
        <div class="flex flex-col gap-4">
            <a href="Student/my-courses.php" class="bg-violet-500 hover:bg-violet-600 text-white px-6 py-3 rounded-lg shadow-md text-lg font-semibold">
                Access Your Courses
            </a>
            <a href="index.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg shadow-md text-lg font-semibold">
                Return to Home
            </a>
        </div>
    </div>
</body>
</html>
