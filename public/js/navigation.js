function loadContent(url) {
  console.log("hit navigation");
  const mainContent = document.getElementById("main-content-container");

  // Fetch the content from the server
  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.text();
    })
    .then((data) => {
      // Create a temporary container to parse the fetched content
      const tempDiv = document.createElement("div");
      tempDiv.innerHTML = data;

      // Extract and execute any script tags
      const scripts = tempDiv.querySelectorAll("script");
      scripts.forEach((script) => {
        const newScript = document.createElement("script");
        if (script.src) {
          newScript.src = script.src; // Copy external script src
        } else {
          newScript.textContent = script.textContent; // Inline script
        }
        document.body.appendChild(newScript);
      });

      // Replace the content of the main container
      mainContent.innerHTML = tempDiv.innerHTML;
    })
    .catch((error) => {
      console.error("Error loading content:", error);
      mainContent.innerHTML =
        "<p>Sorry, an error occurred while loading the content.</p>";
    });
}
