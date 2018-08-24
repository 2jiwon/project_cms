// For Login Collapse
window.addEventListener ("load", function () {
  $('#collapseLogin').collapse('toggle');
}); 

var url = window.location.href.split('/');
var current = url[url.length-1];

var login = document.getElementById ('loginBtn');
if (login) {
  login.addEventListener ('click', function () {
    if (current !== 'index.php') {
      $(location).attr('href', './index.php');
    }     
  });
}
