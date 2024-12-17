// Select the form element
console.log("hit create contact js fetch");
console.log(document.getElementById("new-contact-form"));

document
  .getElementById("new-contact-form")
  .addEventListener("submit", async (event) => {
    event.preventDefault(); // Prevent the default form submission

    // Create a FormData object to collect form data
    const formData = new FormData(event.target);
    console.log("submit event for create contact");
    // Log each key-value pair in FormData
    for (const [key, value] of formData.entries()) {
      console.log(key, value);
    }

    try {
      // Send data to the PHP file using fetch
      const response = await fetch("../php/API/CreateContact.php", {
        method: "POST",
        body: formData,
      });

      if (response.ok) {
        // Handle success response
        const result = await response.text();
        console.log("Contact added successfully:", result);
        alert("Contact added successfully!");

        // Optionally, redirect to another page
        // window.location.href = "users.php";

        loadContent("dashboard.php");
      } else {
        // Handle error response
        console.error("Failed to add contact:", response.statusText);
        alert("Error: Failed to add contact.");
      }
    } catch (error) {
      // Handle network or other errors
      console.error("Error:", error);
      alert("Error: Unable to submit form.");
    }
  });
