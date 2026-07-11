(function(){
  //colour map per toast type
  var colours={
    success:{ border:'var(--green)', icon:'bi bi-check-circle-fill', bg:'#E1F5EE'},
    error:  { border:'var(--red)',   icon:'bi bi-x-circle-fill',     bg:'#FAECE7'},
    info:   { border:'var(--br)',    icon:'bi bi-info-circle-fill',  bg:'#FAEEDA'},
  };

  //container that show toasts on top-right
  function getContainer(){
      el=document.createElement('div');
      el.id='ax-toast-container';
      el.style.cssText= 
      'position:fixed;top:20px;right:20px;z-index:99999;display:flex;flex-direction:column;gap:8px;'+
      'max-width:340px;width:100%;pointer-events:none';
      document.body.appendChild(el);
      return el;
  }

  window.showToast=function(_, opts){
    opts=opts || {};
    var type=opts.type || 'info';
    var title=opts.title || '';
    var sub=opts.sub|| '';
    var dur=opts.duration || 4000;
    var c=colours[type] || colours.info;

    var toast=document.createElement('div');
    toast.className='ax-toast';
    toast.style.cssText= 
    'background:#fff;border:1px solid var(--border);border-left:4px solid '+c.border+';border-radius:12px;'+
    'padding:12px 14px;box-shadow:0 4px 20px rgba(0,0,0,.10);font-family:\'Nunito\',sans-serif;font-size:.85rem;'+
    'display:flex;align-items:flex-start;gap:10px;pointer-events:all;opacity:0;transform:translateX(20px);'+
    'transition:opacity .25s,transform .25s';

    toast.innerHTML=
    '<div style="width:28px;height:28px;border-radius:50%;background:' + c.bg + ';display:flex;align-items:center;'+
    'justify-content:center">' +
    '<i class="' + c.icon + '" style="color:' + c.border + ';font-size:.85rem"></i>' +
    '</div> <div style="flex:1;min-width:0">' +
    '<div style="font-weight:700;color:var(--text-primary,#1a1a1a);line-height:1.3">' + title + '</div>' +
    (sub ? '<div style="color:var(--muted,#777);font-size:.8rem;margin-top:2px;line-height:1.4;'+
    'white-space:nowrap;overflow:hidden;text-overflow:ellipsis">' + sub + '</div>' : '') +
    '</div>' +
    '<button onclick="this.closest(\'.ax-toast\').remove()" style="background:none;border:none;padding:0;'+
    'cursor:pointer;color:var(--muted,#aaa);font-size:1rem;line-height:1;flex-shrink:0;margin-top:-2px">&times;</button>';

    getContainer().appendChild(toast);

    // Animate in
      requestAnimationFrame(function(){
        toast.style.opacity='1';
        toast.style.transform='translateX(0)';
    });

    // Auto-dismiss
    if(dur > 0){
      setTimeout(function(){
        toast.style.opacity='0';
        toast.style.transform='translateX(20px)';
        setTimeout(function(){ toast.remove(); },280);
      }, dur);
    }
  };
})();
