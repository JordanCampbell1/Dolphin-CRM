document.getElementById("logout-link").addEventListener("click", async (e) => {
    e.preventDefault(); // Prevent default behavior
  
    try {
      // Send a POST request to logout.php
      const response = await fetch("../php/logout.php", {
        method: "POST",
      });
  
      // Check if the response is OK
      if (!response.ok) {
        throw new Error("Failed to log out");
      }
  
      const result = await response.json();
  
      // Handle the response
      if (result.success) {
        alert(result.message); // Display success message
        window.location.href = "../php/index.php"; // Redirect to the login page
      } else {
        alert("Logout failed. Please try again.");
      }
    } catch (error) {
      console.error("Logout error:", error);
      alert("An error occurred during logout.");
    }
  });
  