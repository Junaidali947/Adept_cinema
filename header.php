<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?= htmlspecialchars($APP_NAME) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            -webkit-user-select: none; /* Safari */
            -ms-user-select: none; /* IE 10 and IE 11 */
            user-select: none; /* Standard syntax */
            background-color: #111827; /* bg-gray-900 */
            color: white;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-900 text-white font-sans antialiased overflow-x-hidden">
    <div class="container mx-auto px-4 pt-6 pb-24">
        <header class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-red-600"><?= htmlspecialchars($APP_NAME) ?></h1>
            <a href="search.php">
                <i class="fas fa-search text-xl"></i>
            </a>
        </header>