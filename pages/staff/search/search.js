function performSearch() {
            const query = document.getElementById('searchInput').value.trim();
            if (!query) {
                alert('Please enter a search term');
                return;
            }
            // Demo search - would connect to API
            console.log('Searching for:', query);
        }

        // Enter key search
        document.getElementById('searchInput').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') performSearch();
        });

        // Mobile menu
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('open');
        });
