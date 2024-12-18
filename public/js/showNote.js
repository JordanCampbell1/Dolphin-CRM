console.log("hit shownote.js");

//seems that there are duplicate js being moved to the div when you go on more than one contact to add notes thereforec ecausing a syntax error and not being able to work

// console.log("this is addnotebutton", addNoteButton);

// if (!notesContainer || !contactIdElement || !addNoteButton) {
//   console.error("Required elements not found in the DOM.");
// }

function loadNotes() {
  const notesContainer = document.getElementById("container-notes-list");

  const contactIdElement = document.getElementById("contact-id");
  const contactId = contactIdElement.value; // Assuming a hidden input holds the contact ID
  console.log("hit load notes fetch");
  fetch(`../php/setup/showNote.php?contact_id=${contactId}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        notesContainer.innerHTML = "<h5>Notes</h5>";

        if (data.notes.length > 0) {
          data.notes.forEach((note) => {
            const noteDiv = document.createElement("div");
            noteDiv.className = "note";
            noteDiv.innerHTML = `
                                <p>${note.comment}</p>
                                <small>Created at: ${note.created_at}</small>
                            `;
            notesContainer.appendChild(noteDiv);
          });
        } else {
          notesContainer.innerHTML +=
            "<p>No notes available for this contact.</p>";
        }
      } else {
        notesContainer.innerHTML = `<p>${data.error}</p>`;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function addNote() {
  const contactIdElement = document.getElementById("contact-id");
  const contactId = contactIdElement.value; // Assuming a hidden input holds the contact ID
  const noteComment = document
    .querySelector('textarea[name="note_comment"]')
    .value.trim();

  if (!noteComment) {
    alert("Please enter a note.");
    return;
  }

  // Create FormData to send form-encoded data including user_id
  const formData = new URLSearchParams();
  formData.append("contact_id", contactId);
  formData.append("comment", noteComment);

  fetch("../php/setup/update-notes.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: formData.toString(),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        loadNotes();
        document.querySelector('textarea[name="note_comment"]').value = "";
      } else {
        alert(data.error || "Failed to add note");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Failed to add note");
    });
}

document.querySelector(".btn").addEventListener("click", addNote);

loadNotes(); // Initial load
