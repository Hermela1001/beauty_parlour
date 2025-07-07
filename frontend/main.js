

document.addEventListener("DOMContentLoaded", () => {
  console.log("Glamorous Haven JS Loaded ✨");

  
  const serviceCards = document.querySelectorAll("div[style*='box-shadow']");
  serviceCards.forEach(card => {
    card.addEventListener("mouseover", () => {
      card.style.transform = "scale(1.03)";
      card.style.transition = "transform 0.3s ease";
    });
    card.addEventListener("mouseout", () => {
      card.style.transform = "scale(1)";
    });
  });

  
  const buttons = document.querySelectorAll("button");
  buttons.forEach(btn => {
    btn.addEventListener("click", () => {
      btn.style.transform = "scale(0.97)";
      setTimeout(() => {
        btn.style.transform = "scale(1)";
      }, 150);
    });
  });

  
  const loginForm = document.querySelector("form");
  if (loginForm && loginForm.querySelector("#email") && loginForm.querySelector("#password")) {
    loginForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const email = loginForm.querySelector("#email").value.trim();
      const password = loginForm.querySelector("#password").value.trim();

      if (email && password) {
        console.log("Login successful for:", email);
        window.location.href = "home.php"; 
      } else {
        alert("Please fill in both fields.");
      }
    });
  }

  
  const ctaButtons = document.querySelectorAll("a[href^='#']");
  ctaButtons.forEach(link => {
    link.addEventListener("click", function (e) {
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: "smooth" });
      }
    });
  });
});
