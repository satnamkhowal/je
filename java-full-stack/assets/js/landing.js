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
    form.addEventListener('submit',function(e){
      e.preventDefault();
      var name=(form.querySelector('[name="name"]')||{}).value||'';
      var phone=(form.querySelector('[name="phone"]')||{}).value||'';
      var message='Hello Jaipur Engineers, I am interested in the Java Full Stack Developer course.';
      if(name){message+='\nName: '+name.trim();}
      if(phone){message+='\nPhone: '+phone.trim();}
      message+='\nPlease share the next batch timing, current fee and counselling details.';
      window.open('https://wa.me/917014692039?text='+encodeURIComponent(message),'_blank','noopener');
    });
  });
})();
