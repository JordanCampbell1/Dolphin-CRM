document.addEventListener("DOMContentLoaded", () => {
    // Function to handle the filtering logic
    function filterTable(filter, userId) {
        const rows = document.querySelectorAll("#contacts-table-body tr");

        rows.forEach(row => {
            const type = (row.getAttribute("data-type") || "").trim().toLowerCase(); // Contact type
            const assignedTo = (row.getAttribute("data-assigned") || "").trim();    // ID of the assigned user
            const createdBy = (row.getAttribute("data-created") || "").trim();     // ID of the user who created the contact

            // Debugging outputs
            console.log(`Filter: ${filter}, UserID: ${userId}, Row Assigned To: ${assignedTo}`);

            // Apply filters based on the selected filter type
            if (filter === "all") {
                row.style.display = ""; // Show all rows
            } 
            else if (filter === "assigned") {
                // Show rows where assignedTo matches the current user ID
                if (assignedTo === userId) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            } 
            else if (filter === "assigned by me") {
                // Show rows created by the current user
                row.style.display = (createdBy === userId) ? "" : "none";
            } 
            else if (filter === "sales lead" || filter === "support") {
                // Show rows matching the contact type
                row.style.display = (type === filter) ? "" : "none";
            } 
            else {
                row.style.display = "none"; // Hide unmatched rows
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
        const userId = "<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>"; // Current user's ID
        console.log("UserID Loaded From PHP:", userId); // Debugging UserID

        // Validate if userId is set
        if (!userId) {
            console.error("User ID is not set in the session.");
            return;
        }

        setupFilterListeners(userId); // Set up filter functionality

        // Optional: Set default filter to "all"
        const defaultFilter = document.querySelector('.filter-option[data-filter="all"]');
        if (defaultFilter) {
            defaultFilter.click();
        }
    }

    // Run initialization
    initializeFilters();
});
