document.addEventListener("DOMContentLoaded", () => {
    initializeFilters();
    const filterOptions = document.querySelectorAll(".filter-option");
    const tableBody = document.getElementById("contacts-table-body");
    const userId = "<?php echo $_SESSION['user_id']; ?>"; // Ensure userId is available from session

    // Add event listeners to filter options
    filterOptions.forEach(option => {
        option.addEventListener("click", () => {
            filterOptions.forEach(opt => opt.classList.remove("selected")); // Remove 'selected' class from all options
            option.classList.add("selected"); // Add 'selected' class to the clicked option
            const filter = option.getAttribute("data-filter"); // Get the selected filter type
            filterTable(filter); // Apply the selected filter to the table
        });
    });
// add comment 
    // Function to filter table based on the selected filter
    function filterTable(filter) {
        const rows = tableBody.querySelectorAll("tr");

        rows.forEach(row => {
            const type = row.getAttribute("data-type");
            const assignedTo = row.getAttribute("data-assigned");

            if (filter === "all") {
                row.style.display = ""; // Show all rows
            } else if (filter === "assigned") {
                if (assignedTo === userId || assignedTo === "") {
                    row.style.display = ""; // Show rows assigned to the current user
                } else {
                    row.style.display = "none"; // Hide non-assigned rows
                }
            } else if (filter === "sales leads" || filter === "support") {
                if (type === filter) {
                    row.style.display = ""; // Show rows matching the selected type
                } else {
                    row.style.display = "none"; // Hide non-matching rows
                }
            } else {
                row.style.display = "none"; // Hide rows that don't match any filter
            }
        });
    }
});

// Function to handle the filtering logic
function filterTable(filter, userId) {
    const rows = document.querySelectorAll("#contacts-table-body tr");

    rows.forEach(row => {
        const type = row.getAttribute("data-type").toLowerCase(); // Contact type (e.g., "sales leads", "support")
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
        } else if (filter === "sales leads" || filter === "support") {
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
            const filter = option.getAttribute("data-filter").toLowerCase();

            // Call the filterTable function with the selected filter
            filterTable(filter, userId);
        });
    });
}

// Function to initialize filters on page load
function initializeFilters() {
    const userId = "<?php echo $_SESSION['user_id']; ?>"; // Get the current user ID from PHP
    setupFilterListeners(userId); // Set up the filter functionality
}
