const popup = document.getElementById("popup");
const addProductButton = document.getElementById("addProductButton");
const closePopup = document.getElementById("closePopup");
const uploadInput = document.getElementById("upload");
const uploadIcon = document.getElementById("uploadIcon");
const uploadLabel = document.querySelector("label[for='upload']");

// Buka Popup Add Product
if (addProductButton) {
  addProductButton.addEventListener("click", function () {
    popup.classList.replace("hidden", "flex");
  });
}

// Tutup Popup Add Product
if (closePopup) {
  closePopup.addEventListener("click", function () {
    popup.classList.replace("flex", "hidden");
    uploadIcon.classList.replace("text-green-500", "text-gray-400");
    uploadIcon.classList.replace("bx-check", "bx-upload");
    uploadLabel.classList.replace("text-green-500", "text-gray-400");
  });
}

// Ganti Icon Upload
if (uploadInput) {
  uploadInput.addEventListener("change", function () {
    if (uploadInput.files.length > 0) {
      uploadIcon.classList.replace("text-gray-400", "text-green-500");
      uploadIcon.classList.replace("bx-upload", "bx-check");
      uploadLabel.classList.replace("text-gray-400", "text-green-500");
    }
  });
}

const themeButton = document.getElementById("themeButton");
if(themeButton) {
  themeButton.addEventListener("click", () => {
    console.log("toggleTheme");
    const current = getCookie("theme") || "dark";
    const next = current === "dark" ? "light" : "dark";
    document.cookie = "theme=" + next + "; path=/; max-age=" + 60 * 60 * 24 * 30;
    location.reload();
  });
  
  function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? match[2] : null;
  }
}

