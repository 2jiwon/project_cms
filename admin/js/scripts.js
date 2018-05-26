// For CKEditor 
var editor = document.getElementById ("editor");

if (editor) {
  ClassicEditor
    .create (document.querySelector('#editor'))
    .catch (error => { console.error( error ); });
}

// for Select all checkbox
var selectAll = document.getElementById ("selectAllBoxes");
var checkboxes = document.querySelectorAll ("input[type=checkbox]");

if (selectAll) {
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
}

// jQuery for loader
var div_box = "<div id='load-screen'><div id='loading'></div></div>";

$("body").prepend (div_box);

$('#load-screen').delay (100).fadeOut (500, function (){
  $(this).remove ();
});

// For Instant Users online count
function loadUsersOnline () {
  $.get ("functions.php?usersonline=result", function (data) {
    $(".usersonline").text (data);
  });
}
setInterval (function () {
  loadUsersOnline ();
}, 500);
