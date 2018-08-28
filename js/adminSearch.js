function toggle_visibility() {
  var e = document.getElementById('divUsers');
  var f = document.getElementById('divGames');
  if(e.style.display == 'block')
    e.style.display = 'none';

  else if (f.style.display == 'block') {
    f.style.display = 'none';
    e.style.display = 'block';
  }
  else
    e.style.display = 'block';
    f.style.display ='none';
}

function toggle_visibility1() {
  var e = document.getElementById('divGames');
  var f = document.getElementById('divUsers');
  if(e.style.display == 'block')
    e.style.display = 'none';

  else if (f.style.display == 'block') {
    f.style.display = 'none';
    e.style.display = 'block';
  }
  else
    e.style.display = 'block';
    f.style.display ='none';
}


$(document).ready(function() {
  $('input[type="checkbox"]').on('change', function() {
    $('input[type="checkbox"]').not(this).prop('checked', false);
  });

});
