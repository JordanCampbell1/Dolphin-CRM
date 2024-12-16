function loadContent(url) {
    const mainContent = document.getElementById('main-content-container');
  
    // Fetch the content from the server
    fetch(url)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
      })
      .then(data => {
        // Replace the main content with the fetched content
        mainContent.innerHTML = data;
      })
      .catch(error => {
        console.error('Error loading content:', error);
        mainContent.innerHTML = '<p>Sorry, an error occurred while loading the content.</p>';
      });
  }
  