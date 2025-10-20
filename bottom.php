</div> <!-- Close container -->

    <nav class="fixed bottom-0 left-0 right-0 bg-gray-800 border-t border-gray-700">
        <div class="flex justify-around max-w-xl mx-auto">
            <a href="index.php" class="flex flex-col items-center justify-center text-gray-400 hover:text-white p-3 w-full">
                <i class="fas fa-home"></i>
                <span class="text-xs">Home</span>
            </a>
            <a href="search.php" class="flex flex-col items-center justify-center text-gray-400 hover:text-white p-3 w-full">
                <i class="fas fa-search"></i>
                <span class="text-xs">Search</span>
            </a>
            <a href="categories_page.php" class="flex flex-col items-center justify-center text-gray-400 hover:text-white p-3 w-full">
                <i class="fas fa-th-large"></i>
                <span class="text-xs">Categories</span>
            </a>
            <a href="profile.php" class="flex flex-col items-center justify-center text-gray-400 hover:text-white p-3 w-full">
                <i class="fas fa-user"></i>
                <span class="text-xs">Profile</span>
            </a>
        </div>
    </nav>

    <script>
        // Disable right-click, text selection, and zoom
        document.addEventListener('contextmenu', event => event.preventDefault());
        document.addEventListener('selectstart', event => event.preventDefault());
        document.addEventListener('gesturestart', event => event.preventDefault());
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && (e.key === '+' || e.key === '-' || e.key === '0')) {
                e.preventDefault();
            }
        });
        document.addEventListener('wheel', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
            }
        }, { passive: false });
    </script>
</body>
</html>