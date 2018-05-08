// For CKEditor 
var editor = document.getElementById ("editor");

if (editor) {
  ClassicEditor
    .create( document.querySelector('#editor'))
    .catch( error => { console.error( error ); });
}

// for Select all checkbox
var selectAll = document.getElementById ("selectAllBoxes");
var checkboxes = document.querySelectorAll ("input[type=checkbox]");

selectAll.addEventListener ("click", function (){
  if (selectAll.checked) {
    Array.prototype.forEach.call (checkboxes, function (i) {
      i.checked = true;
    });
  }
  else {
    Array.prototype.forEach.call (checkboxes, function (i) {
      i.checked = false;
    });
  }
});
