(function(){
  var navToggle=document.querySelector('.nav-toggle');
  var nav=document.querySelector('.nav-links');
  if(navToggle&&nav){
    navToggle.addEventListener('click',function(){
      nav.classList.toggle('open');
      navToggle.setAttribute('aria-expanded',nav.classList.contains('open')?'true':'false');
    });
    nav.querySelectorAll('a').forEach(function(link){link.addEventListener('click',function(){nav.classList.remove('open');navToggle.setAttribute('aria-expanded','false');});});
  }

  document.querySelectorAll('.module-head').forEach(function(btn){
    btn.addEventListener('click',function(){
      var module=btn.closest('.module');
      var icon=btn.querySelector('.module-toggle i');
      module.classList.toggle('open');
      if(icon){icon.className=module.classList.contains('open')?'fa fa-minus':'fa fa-plus';}
    });
  });

  document.querySelectorAll('.faq button').forEach(function(btn){
    btn.addEventListener('click',function(){
      var faq=btn.closest('.faq');
      var icon=btn.querySelector('i');
      faq.classList.toggle('open');
      if(icon){icon.className=faq.classList.contains('open')?'fa fa-minus':'fa fa-plus';}
    });
  });

  document.querySelectorAll('.js-whatsapp-form').forEach(function(form){
    var section=form.closest('.lead-section');
    if(section){
      var title=section.querySelector('.lead-copy h2');
      var copy=section.querySelector('.lead-copy p');
      var formTitle=form.querySelector('h3');
      var button=form.querySelector('button[type="submit"]');
      var note=form.querySelector('.form-note');
      if(title)title.textContent='Start your Python Full Stack course enquiry.';
      if(copy)copy.textContent='Enter your name and mobile number first. The next step captures your learning preference and saves the enquiry securely for counselling follow-up.';
      if(formTitle)formTitle.textContent='Start enquiry';
      if(button)button.innerHTML='<i class="fa fa-arrow-right"></i> Continue Enquiry';
      if(note)note.textContent='Next: email, qualification, preferred mode and batch details.';
    }

    form.setAttribute('method','get');
    form.setAttribute('action','enquire.php');
    form.addEventListener('submit',function(e){
      e.preventDefault();
      var name=(form.querySelector('[name="name"]')||{}).value||'';
      var phone=(form.querySelector('[name="phone"]')||{}).value||'';
      var params=new URLSearchParams(window.location.search);
      params.set('name',name.trim());
      params.set('phone',phone.trim());
      window.location.href='enquire.php?'+params.toString();
    });
  });
})();
