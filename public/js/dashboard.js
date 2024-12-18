document.addEventListener("DOMContentLoaded", () => {
    function toggleRowVisibility(row, condition) {
        row.style.display = condition ? "" : "none";
    }

    function filterTable(filter) { 
        // Access the user ID from the body data attribute
        const userId = document.body.getAttribute('data-user-id');
        
        // If userId is 'null', return early
        if (userId === 'null') {
            console.error("User ID is not set in the session.");
            return;
        }

        // Convert userId to integer for comparison
        const parsedUserId = parseInt(userId, 10);
        
        const rows = document.querySelectorAll("#contacts-table-body tr");

        rows.forEach(row => {
            const type = (row.getAttribute("data-type") || "").trim().toLowerCase(); // Contact type
            const assignedTo = parseInt((row.getAttribute("data-assigned") || "").trim()); // Assigned user ID (parse as integer)

            // Log for debugging
            console.log(`Filter: ${filter}, UserID: ${parsedUserId}, Row Assigned To: '${assignedTo}'`);

            if (filter === "all") {
                toggleRowVisibility(row, true); // Show all rows
            } else if (filter === "assigned") {
                toggleRowVisibility(row, assignedTo === parsedUserId); // Compare directly as integers
            } else if (filter === "sales lead" || filter === "support") {
                toggleRowVisibility(row, type === filter); // Show rows matching the contact type
            } else {
                toggleRowVisibility(row, false); // Hide unmatched rows
            }
        });
    }

    function setupFilterListeners() {
        const filterOptions = document.querySelectorAll(".filter-option");

        filterOptions.forEach(option => {
            option.addEventListener("click", () => {
                filterOptions.forEach(opt => opt.classList.remove("selected"));
                option.classList.add("selected");

                const filter = option.getAttribute("data-filter").trim().toLowerCase();
                filterTable(filter);
            });
        });
    }

    function initializeFilters() {
        setupFilterListeners();

        const defaultFilter = document.querySelector('.filter-option[data-filter="all"]');
        if (defaultFilter) {
            defaultFilter.click();
        } else {
            console.warn("Default filter 'all' not found.");
        }
    }

    initializeFilters();
});
