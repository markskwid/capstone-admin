$('input[type="file"]').change(function(e){
  var fileName = e.target.files[0].name;
  $('.file-chosen').text(this.files[0].name);
  allowedFileExtensions: ['jpg', 'png', 'jpeg'];
});

function hide_text() {
    var messages = document.querySelectorAll(".hide-this");
    for (var i = 0; i < messages.length; i++) {
        var str = messages[i].style.display = "none";
        messages[i].style.display = "none";
    }

    var sm = document.querySelectorAll(".container-sm"); 
    for (var i = 0; i < sm.length; i++) {
        sm[i].style.width = "285px";
    }

    var md = document.querySelectorAll('.container-md');
    for (var i = 0; i < md.length; i++) {
      md[i].style.width = "590px";
  }

}



  function show_text() {
    var messages = document.querySelectorAll(".hide-this");
    for (var i = 0; i < messages.length; i++) {
        var str = messages[i].style.display = "inline-block";
        messages[i].style.display = "block";
    }

    var sm = document.querySelectorAll(".container-sm");
    for (var i = 0; i < sm.length; i++) {
        sm[i].style.width = "240px";
    }

    var md = document.querySelectorAll('.container-md');
    for (var i = 0; i < md.length; i++) {
      md[i].style.width = "498px";
  }

  
  }
    /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
  function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
    document.getElementById("main").style.marginLeft = "250px";
    document.querySelector('.header').style.display ="block";
    document.querySelector('#bars').classList.add('mt-3');
    show_text();
  }


  /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
  function closeNav() {
    document.getElementById("mySidenav").style.width = "50px";
    document.getElementById("main").style.marginLeft = "50px";
    document.querySelector('.header').style.display ="none";   
    document.querySelector('#bars').classList.remove('mt-3')
    hide_text();
   
  }

  $('#indicator').click(function(){
    const arrow_indicator = document.querySelector("#indicator");
    if(arrow_indicator.classList.contains('open')){
      openNav();
      show_text();
      arrow_indicator.classList.remove("open")
      arrow_indicator.classList.add("close-now")
    }else{
     closeNav();
      hide_text();
      arrow_indicator.classList.remove("close-now")
      arrow_indicator.classList.add("open")
    }
  });


  $('#total-emp').hover(function(){
    $(this).children('img').attr('src', './assets/emp.gif');
  }, function(){
    $(this).children('img').attr('src', './assets/emp_icon.png');
  })

  $('#total-book').hover(function(){
    $(this).children('img').attr('src', './assets/doc.gif');
  }, function(){
    $(this).children('img').attr('src', './assets/history_icon.png');
  })

  $('#total-product').hover(function(){
    $(this).children('img').attr('src', './assets/box.gif');
  }, function(){
    $(this).children('img').attr('src', './assets/inv-icon.png');
  })
  
  

   /**
    * 
  document.querySelector('#event-input').style.width = "650px";
  document.querySelector('#event-display').style.width = "530px";
    */