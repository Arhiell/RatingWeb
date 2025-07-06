// script.js

document.addEventListener("DOMContentLoaded", () => {
  // === Menú hamburguesa ===
  const menuToggle = document.getElementById("menu-toggle");
  const menuDropdown = document.getElementById("menu-dropdown");

  menuToggle.addEventListener("click", () => {
    menuDropdown.style.display =
      menuDropdown.style.display === "flex" ? "none" : "flex";
  });

  // === Modales ===
  const modalInfo = document.getElementById("modal-info");
  const modalRating = document.getElementById("modal-rating");
  const modalComment = document.getElementById("modal-comment");
  const closeButtons = document.querySelectorAll(".close-modal");

  // Mostrar info película
  document.querySelectorAll(".movie-info-icon").forEach((icon) => {
    icon.addEventListener("click", () => {
      const title = icon.dataset.title || "Película";
      document.getElementById("modal-title").textContent = title;
      modalInfo.style.display = "block";
    });
  });

  // Mostrar modal calificar
  document.querySelectorAll(".rate").forEach((el) => {
    el.addEventListener("click", () => {
      modalRating.style.display = "block";
    });
  });

  // Mostrar modal comentar
  document.querySelectorAll(".comment").forEach((el) => {
    el.addEventListener("click", () => {
      modalComment.style.display = "block";
    });
  });

  // Cerrar modales
  closeButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      btn.closest(".modal").style.display = "none";
    });
  });

  // === Calificación ===
  const stars = document.querySelectorAll("#modal-rating .stars i");
  stars.forEach((star, index) => {
    star.addEventListener("click", () => {
      stars.forEach((s, i) => {
        s.classList.toggle("selected", i <= index);
      });
    });
  });

  // === Comentar ===
  const submitComment = document.getElementById("submit-comment");
  const commentList = document.getElementById("comment-list");

  submitComment.addEventListener("click", () => {
    const commentText = document.getElementById("user-comment").value.trim();
    if (commentText !== "") {
      const li = document.createElement("li");
      li.textContent = commentText;
      commentList.appendChild(li);
      document.getElementById("user-comment").value = "";
      modalComment.style.display = "none";
    }
  });

  // === Cerrar modal al hacer clic fuera ===
  window.addEventListener("click", (e) => {
    document.querySelectorAll(".modal").forEach((modal) => {
      if (e.target === modal) {
        modal.style.display = "none";
      }
    });
  });
});
