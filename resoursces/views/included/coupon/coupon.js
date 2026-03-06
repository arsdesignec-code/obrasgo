function deletecoupon(id, title, yes, no, deleteurl, wrong, recordsafe) {
   swalWithBootstrapButtons.fire({
      title: title,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true,
   }).then((result) => {
      if (result.isConfirmed) {
         $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: deleteurl,
            data: {
               id: id
            },
            method: 'POST',
            success: function (response) {
               if (response == 1) {
                  swal.close();
                  window.location.reload();
               } else {
                  swalWithBootstrapButtons.fire("Cancelled", wrong, "error");
               }
            },
            error: function (e) {
               swalWithBootstrapButtons.fire("Cancelled", wrong, "error");
            }
         });
      } else {
         swalWithBootstrapButtons.fire("Cancelled", recordsafe, "error");
      }
   });
}
