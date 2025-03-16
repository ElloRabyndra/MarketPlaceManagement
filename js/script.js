const popup = document.getElementById('popup');
const addProductButton = document.getElementById('addProductButton');
const closePopup = document.getElementById('closePopup');

// Buka Popup Add Product
addProductButton.addEventListener("click", function() {
  popup.classList.replace("hidden", "flex");
});

// Tutup Popup Add Product
closePopup.addEventListener("click", function() {
  popup.classList.replace("flex", "hidden");
});