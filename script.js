// alert("Js file loaded");

const menuBtn = document.querySelector("#menuBtn");
const navMenu = document.querySelector("#navMenu");

menuBtn.addEventListener("click", () => {
    const isOpen = navMenu.classList.toggle("show");

    menuBtn.setAttribute("aria-expanded", String(isOpen));

    if (isOpen) {
        menuBtn.setAttribute("aria-label", "Close menu")
    }
    else {
        menuBtn.setAttribute("aria-label", "Open menu")
    }
});

const navLinks = navMenu.querySelectorAll("a");

navLinks.forEach((link) => {
    link.addEventListener("click", () => {
        navMenu.classList.remove("show");
        menuBtn.setAttribute("aria-expanded", "false");
        menuBtn.setAttribute("aria-label", "Open menu");
    });
});

const formMessage = document.querySelector("#formMessage");
//2. contact form
const contactForm = document.querySelector("#contactForm");
contactForm.addEventListener("submit", async (event) => {
    event.preventDefault();

    // alert("Js submit handleris running!");
    formMessage.textContent = "Sending message... ";

    try {
        const response = await fetch("process.php", {
            method: "POST",
            body: new FormData(contactForm)
        });

        // const result = await response.json();
        const rawResponse = await response.text();
        
        console.log("HTTP status:", response.status);
        console.log("Server response:", rawResponse);
        // console.log("Server response:", result);
        const result = JSON.parse(rawResponse);

        formMessage.textContent = result.message;

        // alert(result.message);

        if (response.ok && result.success) {
            contactForm.reset();
        }
    } catch (error) {
        console.error("Submit error:", error);
        formMessage.textContent = "Something went wrong. Please try again."
    }
});


