document.addEventListener("DOMContentLoaded", () => {
    // Function to handle the filtering logic
    function filterTable(filter, userId) {
        const rows = document.querySelectorAll("#contacts-table-body tr");

        rows.forEach(row => {
            const type = (row.getAttribute("data-type") || "").trim().toLowerCase(); // Contact type (e.g., "sales lead", "support")
            const assignedTo = row.getAttribute("data-assigned"); // ID of the assigned user

            // Determine visibility based on filter type
            if (filter === "all") {
                row.style.display = ""; // Show all rows
            } else if (filter === "assigned") {
                if (assignedTo === userId || !assignedTo) {
                    row.style.display = ""; // Show rows assigned to the current user or unassigned
                } else {
                    row.style.display = "none"; // Hide rows assigned to other users
                }
            } else if (filter === "sales lead" || filter === "support") {
                if (type === filter) {
                    row.style.display = ""; // Show rows matching the selected type
                } else {
                    row.style.display = "none"; // Hide rows not matching the selected type
                }
            } else {
                row.style.display = "none"; // Hide rows that don't match any valid filter
            }
        });
    }

    // Function to set up click event listeners on filter buttons
    function setupFilterListeners(userId) {
        const filterOptions = document.querySelectorAll(".filter-option");

        filterOptions.forEach(option => {
            option.addEventListener("click", () => {
                // Remove 'selected' class from all options
                filterOptions.forEach(opt => opt.classList.remove("selected"));

                // Add 'selected' class to the clicked option
                option.classList.add("selected");

                // Get the filter type from the data attribute
                const filter = option.getAttribute("data-filter").trim().toLowerCase();

                // Call the filterTable function with the selected filter
                filterTable(filter, userId);
            });
        });
    }

    // Function to initialize filters on page load
    function initializeFilters() {
        const userId = "<?php echo $_SESSION['user_id']; ?>"; // Get the current user ID from PHP
        setupFilterListeners(userId); // Set up the filter functionality

        // Optional: Set default filter (e.g., "all")
        const defaultFilter = document.querySelector('.filter-option[data-filter="all"]');
        if (defaultFilter) {
            defaultFilter.click();
        }
    }

    // Run initialization
    initializeFilters();
});
