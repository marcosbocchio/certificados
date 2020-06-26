<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ strtoupper($header_titulo)}} <span class="sub-titulo" >
                
                @isset($header_sub_titulo)
                        {{strtoupper($header_sub_titulo)}}
                @endisset
                </span>
        
            <span class="header-descripcion">{{ $header_descripcion }}</span>
        </h1>

    </section>


