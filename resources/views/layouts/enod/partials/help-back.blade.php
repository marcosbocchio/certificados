<div class="ayuda_backbar">
    <a href="{{ route('ayuda-general') }}"
       class="btn btn-enod btn-circle ayuda_backbutton_enod"
       onclick="if (window.history.length > 1 && document.referrer) { try { if (new URL(document.referrer).origin === window.location.origin) { event.preventDefault(); window.history.back(); } } catch (e) {} }">
        <span class="fa fa-arrow-left"></span>
    </a>
</div>
