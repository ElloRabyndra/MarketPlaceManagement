$(document).ready(function () {
  const $popup = $("#popup");
  const $addProductButton = $("#addProductButton");
  const $closePopup = $("#closePopup");
  const $uploadInput = $("#upload");
  const $uploadIcon = $("#uploadIcon");
  const $uploadLabel = $("label[for='upload']");

  // Buka Popup Add Product
  if ($addProductButton.length) {
    $addProductButton.on("click", function () {
      $popup.removeClass("hidden").addClass("flex");
    });
  }

  // Tutup Popup Add Product
  if ($closePopup.length) {
    $closePopup.on("click", function () {
      $popup.removeClass("flex").addClass("hidden");
      $uploadIcon.removeClass("text-green-500 bx-check").addClass("text-gray-400 bx-upload");
      $uploadLabel.removeClass("text-green-500").addClass("text-gray-400");
    });
  }

  // Ganti Icon Upload
  if ($uploadInput.length) {
    $uploadInput.on("change", function () {
      if (this.files.length > 0) {
        $uploadIcon.removeClass("text-gray-400 bx-upload").addClass("text-green-500 bx-check");
        $uploadLabel.removeClass("text-gray-400").addClass("text-green-500");
      }
    });
  }
});
