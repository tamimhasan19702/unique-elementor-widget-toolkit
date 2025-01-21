/** @format */

const slider = document.querySelector(".unique-slider");

function activate(e) {
  const items = document.querySelectorAll(".unique-item");
  e.target.matches(".unique-next") && slider.append(items[0]);
  e.target.matches(".unique-prev") && slider.prepend(items[items.length - 1]);
}

document.addEventListener("click", activate, false);
