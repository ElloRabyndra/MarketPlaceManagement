$(document).ready(function () {
  const $popup = $("#popup");
  const $addProductButton = $("#addProductButton");
  const $closePopup = $("#closePopup");
  const $uploadInput = $("#upload");
  const $uploadIcon = $("#uploadIcon");
  const $uploadLabel = $("label[for='upload']");
  const $searchInput = $("#search-input");
  const $clearSearch = $("#clear-search");
  const $productContainer = $("#product-container");
  let originalProducts = null;

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

// Search 
if ($searchInput.length) {
  // Simpan konten awal untuk dapat dikembalikan
  $(document).ready(function() {
    originalProducts = $productContainer.html();
  });

  // Event ketika user mengetik
  $searchInput.on("keyup", function() {
    const query = $(this).val().trim();
    
    // Tampilkan/sembunyikan tombol clear
    if (query.length > 0) {
      $clearSearch.show();
    } else {
      $clearSearch.hide();
    }
    
    // Jika query kosong, kembalikan tampilan awal
    if (query.length === 0) {
      $productContainer.html(originalProducts);
      return;
    }
    
    // Lakukan AJAX request
    $.ajax({
      url: 'include/search.php',
      type: 'GET',
      data: { query: query },
      dataType: 'json',
      success: function(data) {
        // Kosongkan container
        $productContainer.empty();
        
        // Jika tidak ada hasil
        if (data.length === 0) {
          $productContainer.html('<p class="text-xl p-3 rounded-lg ' + 
            (document.body.classList.contains('bg-zinc-900') ? 
            'bg-zinc-800 text-gray-100' : 'bg-gray-300 text-slate-900') + 
            '">Produk Tidak Ditemukan</p>');
          return;
        }
        
        // Tampilkan hasil pencarian
        data.forEach(function(product) {
          const colorClass = document.body.classList.contains('bg-zinc-900') ? 
            'bg-zinc-800 text-gray-100' : 'bg-gray-300 text-slate-900';
          
          const productCard = `
            <div id="product-card" class="${colorClass} w-80 md:w-96 p-6 border border-neutral-500 rounded-xl">
              <figure class="overflow-hidden rounded-xl border border-neutral-500">
                <img src="uploads/${product.image}" class="w-[350px] h-[220px] m-auto object-cover hover:scale-110 transition">
              </figure>
              <div id="product-detail" class="text-center p-2 space-y-1">
                <h1 class="font-bold text-xl">${product.name}</h1>
                <h3 class="font-medium">${product.description}</h3>
                <div class="flex justify-center gap-2 md:gap-4 pt-2">
                  <p class="py-2 px-4 text-lg font-semibold">Rp${new Intl.NumberFormat('id-ID').format(product.price)}</p>
                  <a href="buy.php?id=${product.id}" class="block h-max py-2 px-6 bg-blue-500 text-white rounded-2xl hover:bg-blue-600 transition">Beli</a>
                  <a href="editProduct.php?id=${product.id}"><i class="bx bxs-pencil text-3xl text-blue-500 hover:text-blue-600"></i></a>
                  <form method="POST" action="include/productManagement.php">
                    <input type="hidden" name="delete" value="${product.id}">
                    <button type="submit"><i class="bx bx-trash text-3xl text-red-600 hover:text-red-700"></i></button>
                  </form>
                </div>
              </div>
            </div>
          `;
          
          $productContainer.append(productCard);
        });
      },
      error: function(xhr, status, error) {
        console.error("Error in search:", error);
      }
    });
  });
  
  // Event untuk tombol clear
  $clearSearch.on("click", function() {
    $searchInput.val('');
    $clearSearch.hide();
    $productContainer.html(originalProducts);
  });
}
});
