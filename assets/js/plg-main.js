
(function($) {
  "use strict";

  // MENU
  $('.navbar-collapse a').on('click', function() {
    $(".navbar-collapse").collapse('hide');
  });

  // CUSTOM LINK
  $('.smoothscroll').click(function() {
    var el = $(this).attr('href');
    var elWrapped = $(el);
    var header_height = $('.navbar').height();

    scrollToDiv(elWrapped, header_height);
    return false;

    function scrollToDiv(element, navheight) {
      var offset = element.offset();
      var offsetTop = offset.top;
      var totalScroll = offsetTop - navheight;

      $('body,html').animate({
        scrollTop: totalScroll
      }, 300);
    }
  });
})(window.jQuery);

const rupiah = (number) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(number);
};

$(document).ready(function() {
  $('.checkoutBtn').click(function() {
    // Mengambil nilai dari elemen HTML
    var idPaket = $('#idPaket').val();
    var namaPaket = $('#namaPaket').val();
    var harga = $('#harga').val();
    var namaPelanggan = $('#namaPelanggan').val();
    var email = $('#email').val();
    var nomorTelepon = $('#nomorTelepon').val();

    // Membuat array JavaScript
    var dataCheckout = {
      id_paket: idPaket,
      nama_paket: namaPaket,
      harga: harga,
      nama_pelanggan: namaPelanggan,
      email: email,
      nomor_telepon: nomorTelepon
    };

    // Melakukan sesuatu dengan data checkout, misalnya mengirim ke server
    console.log(dataCheckout);

    // Mengirim dataCheckout ke server menggunakan AJAX
    $.ajax({
      url: 'pages/payment/place-order.php',
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(dataCheckout),
      success: function(response) {
        console.log("Response dari server:", response);

        // Assuming the response is a plain text token
        var token = response.trim();
        if (token) {
          console.log(token);
          window.snap.pay(token);
        } else {
          console.error("Invalid response from server");
        }
      },
      error: function(xhr, status, error) {
        console.error("Error:", error);
      }
    });
  });
});
