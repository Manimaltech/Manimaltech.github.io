document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('contactForm');

  form.addEventListener('submit', function(event) {
      let isValid = true;

      // Validate Name
      const name = document.getElementById('name').value;
      const nameError = document.getElementById('nameError');
      if (!name) {
          isValid = false;
          nameError.textContent = "Name is required!";
      } else {
          nameError.textContent = "";
      }

      // Validate Email
      const email = document.getElementById('email').value;
      const emailError = document.getElementById('emailError');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!email || !emailRegex.test(email)) {
          isValid = false;
          emailError.textContent = "Please enter a valid email!";
      } else {
          emailError.textContent = "";
      }

      // Validate Phone Number
      const phone = document.getElementById('phone').value;
      const phoneError = document.getElementById('phoneError');
      const phoneRegex = /^[0-9]{10}$/;
      if (!phone || !phoneRegex.test(phone)) {
          isValid = false;
          phoneError.textContent = "Please enter a valid 10-digit phone number!";
      } else {
          phoneError.textContent = "";
      }

      // Validate Message
      const message = document.getElementById('message').value;
      const messageError = document.getElementById('messageError');
      if (!message) {
          isValid = false;
          messageError.textContent = "Message is required!";
      } else {
          messageError.textContent = "";
      }

      // If form is invalid, prevent submission
      if (!isValid) {
          event.preventDefault();
      }
  });
});
