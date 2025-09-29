// Vote AJAX
document.addEventListener('click', (e)=>{
  const f = e.target.closest('.vote-form');
  if(f && e.target.tagName==='BUTTON'){
    e.preventDefault();
    const fd = new FormData(f);
    fd.set('value', e.target.value);
    fetch(f.action, {method:'POST', body:fd})
      .then(r=>r.json()).then(j=>{
        if(j.ok){ f.parentElement.querySelector('.score').textContent=j.score; }
        else if(j.msg==='login'){ location.href='/login'; }
      }).catch(()=>{});
  }
});
// Scroll fluide pour les liens d'ancre (#topics, #votes, #users, etc.)
document.addEventListener('click', (e)=>{
  const a = e.target.closest('a[href^="#"]');
  if(!a) return;
  const id = a.getAttribute('href').slice(1);
  const el = document.getElementById(id);
  if(el){
    e.preventDefault();
    el.scrollIntoView({behavior:'smooth', block:'start'});
  }
});
// Scroll fluide pour tous les liens d'ancre (#topics, #votes, #users, #tags…)
document.addEventListener('click', (e)=>{
  const a = e.target.closest('a[href^="#"]');
  if(!a) return;
  const id = a.getAttribute('href').slice(1);
  const el = document.getElementById(id);
  if(el){
    e.preventDefault();
    el.scrollIntoView({behavior:'smooth', block:'start'});
  }
});
