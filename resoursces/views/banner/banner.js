
"use strict";
function getduration(x) {

   if (x.value == 'Fixed') {

      document.getElementById("duration").style.display = '';
   }
   else {
      document.getElementById("duration").style.display = 'none';
   }
}
$('#banner_type').change(function () {
   if ($('#banner_type').val() == '1') {
      $('#category').removeClass('d-none');
      $('#category_id').prop('required', true);
   } else {
      $('#category').addClass('d-none');
      $('#category_id').prop('required', false);
   }
});