
function confirm_delete(url) {
   confirmation = confirm(lbl_confirm_delete);
   if (confirmation) {
     window.location.href = url;
   }
}