// Select the form element

document
  .getElementById("new-user-form")
  .addEventListener("submit", async (event) => {
    event.preventDefault(); // Prevent the default form submission

    // Create a FormData object to collect form data
    const formData = new FormData(event.target);

    try {
      // Send data to the PHP file using fetch
      const response = await fetch("../php/API/createUser.php", {
        method: "POST",
        body: formData,
      });

      if (response.ok) {
        // Handle success response
        const result = await response.text();
        console.log("User added successfully:", result);
        alert("User added successfully!");

        // Optionally, redirect to another page
        // window.location.href = "users.php";

        loadContent('users.php');
      } else {
        // Handle error response
        console.error("Failed to add user:", response.statusText);
        alert("Error: Failed to add user.");
      }
    } catch (error) {
      // Handle network or other errors
      console.error("Error:", error);
      alert("Error: Unable to submit form.");
    }
  });
