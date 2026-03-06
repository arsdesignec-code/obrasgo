
"use strict";
$(document).on('click', '.select_handyman', function () {
   $('#booking_id').val($(this).attr('data-bookingid'));
   $('#select_handyman').modal('show');
});


function acceptbooking(id, status, title, yes, no, accepturl, wrong, recordsafe) {
   swalWithBootstrapButtons.fire({
      title: title,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      showLoaderOnConfirm: true
   }).then((result) => {

      if (result.isConfirmed) {
         $('.booking_status').prop('disabled', true);
         $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: accepturl,
            data: { id: id, status: status },
            method: 'POST',
            success: function (response) {
               if (response == 1) {
                  swal.close();
                  toastr.success("Booking Accepted Successfully");
                  window.location.reload();
               } else {
                  $('.booking_status').prop('disabled', false);
                  swalWithBootstrapButtons.fire("Cancelled", response.message, "error");
               }
            },
            error: function (e) {
               $('.booking_status').prop('disabled', false);
               swalWithBootstrapButtons.fire("Cancelled", wrong, "error");
            }
         });
      } else {
         $('.booking_status').prop('disabled', false);
         swalWithBootstrapButtons.fire("Cancelled", recordsafe, "error");
      }
   });
}

function cancelbooking(id, status, canceled_by, title, yes, no, cancelurl, wrong, recordsafe) {
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
         $('.booking_status').prop('disabled', true);
         $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: cancelurl,
            data: { id: id, status: status, canceled_by: canceled_by },
            method: 'POST',
            success: function (response) {
               if (response == 1) {
                  swal.close();
                  window.location.reload();
               } else {
                  $('.booking_status').prop('disabled', false);
                  swalWithBootstrapButtons.fire("Cancelled", response.message, "error");
               }
            },
            error: function (e) {
               $('.booking_status').prop('disabled', false);
               swalWithBootstrapButtons.fire("Cancelled", wrong, "error");
            }
         });
      } else {
         $('.booking_status').prop('disabled', false);
         swalWithBootstrapButtons.fire("Cancelled", recordsafe, "error");
      }
   });
}

function completebooking(id, status, title, yes, no, completeurl, wrong, recordsafe) {
   swalWithBootstrapButtons.fire({
      title: title,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: yes,
      cancelButtonText: no,
      showLoaderOnConfirm: true,
   }).then((result) => {
      if (result.isConfirmed) {
         $('.booking_status').prop('disabled', true);
         $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: completeurl,
            data: { id: id, status: status },
            method: 'POST',
            success: function (response) {
               if (response.status == 1) {
                  $('#cbooking_id').val(response.id);
                  $('#cbooking_status').val(response.booking_status);
                  $('#complete_booking').modal('show');
                  $('.booking_status').prop('disabled', false);
               } else {
                  $('.booking_status').prop('disabled', false);
                  toastr.error(response.message);
               }
            },
            error: function (e) {
               $('.booking_status').prop('disabled', false);
               swalWithBootstrapButtons.fire("Cancelled", wrong, "error");
            }
         });
      } else {
         $('.booking_status').prop('disabled', false);
         swalWithBootstrapButtons.fire("Cancelled", recordsafe, "error");
      }
   });
}


