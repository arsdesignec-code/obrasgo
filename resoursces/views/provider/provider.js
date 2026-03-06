"use strict";
$("#add_provider_mobile").keyup(function() {
  var val = $(this).val();
  if (isNaN(val)) {
    val = val.replace(/[^0-9\.]/g, "");
    if (val.split(".").length > 2) val = val.replace(/\.+$/, "");
  }
  $(this).val(val);
});
$("#account_number").keyup(function() {
  var val = $(this).val();
  if (isNaN(val)) {
    val = val.replace(/[^0-9\.]/g, "");
    if (val.split(".").length > 2) val = val.replace(/\.+$/, "");
  }
  $(this).val(val);
});
$("#routing_number").keyup(function() {
  var val = $(this).val();
  if (isNaN(val)) {
    val = val.replace(/[^0-9\.]/g, "");
    if (val.split(".").length > 2) val = val.replace(/\.+$/, "");
  }
  $(this).val(val);
});
$("#edit_provider_mobile").keyup(function() {
  var val = $(this).val();
  if (isNaN(val)) {
    val = val.replace(/[^0-9\.]/g, "");
    if (val.split(".").length > 2) val = val.replace(/\.+$/, "");
  }
  $(this).val(val);
});
function deleteservicerating(id, title, yes, no, deleteurl, wrong, recordsafe) {
  swalWithBootstrapButtons
    .fire({
      title: title,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      showLoaderOnConfirm: true
    })
    .then(result => {
      if (result.isConfirmed) {
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          url: deleteurl,
          data: { id: id },
          method: "POST",
          success: function(response) {
            if (response == 1) {
              swal.close();
              toastr.success("Rating deleted successfully");
              window.location.reload();
            } else {
              swalWithBootstrapButtons.fire("Cancelled", wrong, "error");
            }
          },
          error: function(e) {
            swalWithBootstrapButtons.fire("Cancelled", wrong, "error");
          }
        });
      } else {
        swalWithBootstrapButtons.fire("Cancelled", recordsafe, "error");
      }
    });
}

function deleteaccount(nexturl) {
  var deleted = document.getElementById("delete_account").checked;
  if (deleted == true) {
    swalWithBootstrapButtons
      .fire({
        title: are_you_sure,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: yes,
        cancelButtonText: no
      })
      .then(result => {
        if (result.isConfirmed) {
          location.href = nexturl;
        } else {
          swalWithBootstrapButtons.fire("Cancelled", record_safe, "error");
        }
      });
  } else {
    toastr.error(checkbox_delete_account);
  }
}
