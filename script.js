// JavaScript to validate form
document.getElementById("contactForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form from submitting

    // Get form fields
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();

    // Error message elements
    const nameError = document.getElementById("nameError");
    const emailError = document.getElementById("emailError");
    const phoneError = document.getElementById("phoneError");

    // Reset error messages
    nameError.style.display = "none";
    emailError.style.display = "none";
    phoneError.style.display = "none";

    // Validation flags
    let isValid = true;

    // Validate Name
    if (name === "" || name.length < 3) {
        nameError.textContent = "Name must be at least 3 characters long.";
        nameError.style.display = "block";
        isValid = false;
    }

    // Validate Email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        emailError.textContent = "Please enter a valid email address.";
        emailError.style.display = "block";
        isValid = false;
    }

    // Validate Phone Number
    const phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        phoneError.textContent = "Phone number must be 10 digits.";
        phoneError.style.display = "block";
        isValid = false;
    }

    // If valid, submit the form (for demonstration purposes, log the values)
    if (isValid) {
        alert("Form submitted successfully!");
        console.log({ name, email, phone });
    }
});
