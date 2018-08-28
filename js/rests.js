$(document).ready(function() {
  $('input[type="checkbox"]').on('change', function() {
     $('input[type="checkbox"]').not(this).prop('checked', false);
  });


  $("input[name='inputRes']").change(function(){
    if($("input[value='idade']").is(':checked')){
      $("input[name = inputAge]").css('display','block');
    }
    else{
      $("input[name = inputAge").css('display','none');
    }
  })

  $("input[name='inputRes']").change(function(){
    if($("input[value='concelho']").is(':checked')){
      $("input[name = inputConcelho]").css('display','block');
    }
    else{
      $("input[name = inputConcelho]").css('display','none');
    }
  })

  $("input[name='inputRes']").change(function(){
    if($("input[value='distrito']").is(':checked')){
      $("input[name = inputDistrito]").css('display','block');
    }
    else{
      $("input[name = inputDistrito]").css('display','none');
    }
  })

  $("input[name='inputRes']").change(function(){
    if($("input[value='pais']").is(':checked')){
      $("input[name = inputPais]").css('display','block');
    }
    else{
      $("input[name = inputPais]").css('display','none');
    }
  })
});


function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
}
