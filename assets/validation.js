// JavaScript form validation for the Day 1 assignment.
(function () {
  "use strict";

  function showMessage(element, type, message) {
    element.className = "alert alert-" + type;
    element.textContent = message;
    element.classList.remove("d-none");
  }

  function clearInvalid(form) {
    form.querySelectorAll(".is-invalid").forEach(function (field) {
      field.classList.remove("is-invalid");
    });
  }

  var entryForm = document.getElementById("entryForm");
  if (entryForm) {
    entryForm.addEventListener("submit", function (event) {
      event.preventDefault();
      clearInvalid(entryForm);

      var name = document.getElementById("name");
      var email = document.getElementById("email");
      var phone = document.getElementById("phone");
      var message = document.getElementById("formMessage");
      var valid = true;

      if (name.value.trim() === "") {
        name.classList.add("is-invalid");
        valid = false;
      }

      // Check a simple valid email format, not only whether it contains "@"
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailPattern.test(email.value.trim())) {
        email.classList.add("is-invalid");
        valid = false;
      }

      // Exactly 10 numeric digits, matching the assignment requirement.
      if (!/^\d{10}$/.test(phone.value.trim())) {
        phone.classList.add("is-invalid");
        valid = false;
      }

      if (!valid) {
        showMessage(message, "danger", "Please correct the highlighted fields. All fields are required, enter a valid email, and use exactly 10 digits for the phone.");
        return;
      }

      showMessage(message, "success", "Validation successful! The form is working. This Day 1 demo does not save the entry to a database.");
    });

    entryForm.addEventListener("reset", function () {
      window.setTimeout(function () {
        clearInvalid(entryForm);
        var message = document.getElementById("formMessage");
        message.className = "alert d-none";
        message.textContent = "";
      }, 0);
    });
  }

  var contactForm = document.getElementById("contactForm");
  if (contactForm) {
    contactForm.addEventListener("submit", function (event) {
      event.preventDefault();
      clearInvalid(contactForm);

      var name = document.getElementById("contactName");
      var email = document.getElementById("contactEmail");
      var messageField = document.getElementById("message");
      var messageBox = document.getElementById("contactMessage");
      var valid = true;

      if (name.value.trim() === "") {
        name.classList.add("is-invalid");
        valid = false;
      }
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
        email.classList.add("is-invalid");
        valid = false;
      }
      if (messageField.value.trim() === "") {
        messageField.classList.add("is-invalid");
        valid = false;
      }

      if (!valid) {
        showMessage(messageBox, "danger", "Please complete all contact fields with valid information.");
      } else {
        showMessage(messageBox, "success", "Contact form validation successful. This demo does not send the message to a server.");
      }
    });

    contactForm.addEventListener("reset", function () {
      window.setTimeout(function () {
        clearInvalid(contactForm);
        var messageBox = document.getElementById("contactMessage");
        messageBox.className = "alert d-none";
        messageBox.textContent = "";
      }, 0);
    });
  }
})();
