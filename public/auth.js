document.addEventListener("DOMContentLoaded", () => {
  const authCard = document.getElementById("authCard");
  const switchButtons = document.querySelectorAll("[data-mode]");
  const registerForm = document.getElementById("registerForm");
  const loginForm = document.getElementById("loginForm");

  function setMode(mode) {
    if (!authCard) return;

    if (mode === "login") {
      authCard.classList.remove("register-mode");
      authCard.classList.add("login-mode");
      localStorage.setItem("auth_mode", "login");
    } else {
      authCard.classList.remove("login-mode");
      authCard.classList.add("register-mode");
      localStorage.setItem("auth_mode", "register");
    }
  }

  function hasLoginError() {
    const errorBox = document.querySelector(".error-message, .alert, .alert-danger");
    const text = (errorBox?.innerText || "").toLowerCase();

    const keywords = [
      "mot de passe",
      "incorrect",
      "aucun compte",
      "connectez-vous",
      "en attente",
      "refusé",
      "impossible"
    ];

    return keywords.some(k => text.includes(k));
  }
  if (hasLoginError()) {
    setMode("login");
  } else {
    const savedMode = localStorage.getItem("auth_mode");
    if (savedMode === "login" || savedMode === "register") {
      setMode(savedMode);
    }
  }

  switchButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const mode = button.getAttribute("data-mode");
      if (mode === "login" || mode === "register") setMode(mode);
    });
  });

  if (registerForm) {
    registerForm.addEventListener("submit", (e) => {
      const name = document.getElementById("registerName")?.value.trim();
      const email = document.getElementById("registerEmail")?.value.trim();
      const password = document.getElementById("registerPassword")?.value.trim();

      if (!name || !email || !password) {
        e.preventDefault();
        alert("Please fill in all fields.");
        return;
      }

      if (password.length < 8) {
        e.preventDefault();
        alert("Password must be at least 8 characters.");
        return;
      }
    });
  }

  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      const email = document.getElementById("loginEmail")?.value.trim();
      const password = document.getElementById("loginPassword")?.value.trim();

      if (!email || !password) {
        e.preventDefault();
        alert("Please fill in all fields.");
        return;
      }
    });
  }
});