
"use strict";
$('#edit_handyman_mobile').keyup(function () {
   var val = $(this).val();
   if (isNaN(val)) {
      val = val.replace(/[^0-9\.]/g, '');
      if (val.split('.').length > 2)
         val = val.replace(/\.+$/, "");
   }
   $(this).val(val);
});
$('#add_handyman_mobile').keyup(function () {
   var val = $(this).val();
   if (isNaN(val)) {
      val = val.replace(/[^0-9\.]/g, '');
      if (val.split('.').length > 2)
         val = val.replace(/\.+$/, "");
   }
   $(this).val(val);
});