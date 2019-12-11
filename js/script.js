jQuery(document).ready(function() {
  //hilangkan tombol cari. menyembunyikan. karena sudah live search
  $("#button-search").hide();

  //buat event ketika keyword ditulis
  jQuery("#keyword").on("keyup", function() {
    jQuery(".loader").show(); //munculkan icon loader ketika loading

    //ajax menggunakan load
    jQuery("#container").load(
      "ajax/student.php?keyword=" + jQuery("#keyword").val()
    );

    //ajax menggunakan. $.get()
    $.get("ajax/student.php?keyword=" + $("#keyword").val(), function(data) {
      $("#container").html(data);
      $(".loader").hide(); //menhyebunyikan icon ketika data sudah ketemu
    });
  });
});
