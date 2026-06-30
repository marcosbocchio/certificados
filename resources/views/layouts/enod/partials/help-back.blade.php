<div class="ayuda_backbar">
    <a href="{{ route('ayuda-general') }}"
       class="ayuda_backbtn"
       title="Volver"
       onclick="(function(e){
            try {
                var ref = document.referrer;
                if (ref && new URL(ref).origin === window.location.origin) {
                    e.preventDefault();
                    window.history.back();
                    return;
                }
            } catch (err) {}
            // Sin referrer del mismo origen: deja seguir el href (índice de ayuda).
       })(event)">
        <i class="fa fa-arrow-left"></i>
        <span>Volver</span>
    </a>
</div>
