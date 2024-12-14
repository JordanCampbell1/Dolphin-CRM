// JavaScript (login.js)
window.onload = () => {
  // Select the form and elements
  const loginForm = document.querySelector("form");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");

  // Handle form submission
  loginForm.addEventListener("submit", async (e) => {
    e.preventDefault(); // Prevent the default form submission

    const email = emailInput.value.trim();
    const password = passwordInput.value.trim();

    // Simple client-side validation
    if (email === "" || password === "") {
      alert("Please fill in both fields.");
      return;
    }

    try {
      // Create the data object
      const loginData = {
        email: email,
        password: password,
      };

      // Send a POST request to login.php using fetch
      const response = await fetch("../php/API/login.php", {
        method: "POST", // POST method
        headers: {
          "Content-Type": "application/json", // Send data as JSON
        },
        body: JSON.stringify(loginData), // Convert loginData object to JSON string
      });

      // Check if the request was successful
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      // Parse the JSON response from the server
      const result = await response.json();

      // Handle the result from login.php (successful login or error message)
      if (result.success) {
        // Redirect to the dashboard or another page after successful login
        window.location.href = "../public/dashboard.php"; // Ensure the path is correct
      } else {
        alert(result.message); // Show error message returned from login.php
      }
    } catch (error) {
      console.error("There was an error with the fetch operation:", error);
      alert("Something went wrong, please try again.");
    }
  });
};
