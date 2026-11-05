<template>
  <div v-if="visible" class="enod-guia-row">
    <a :href="url" class="enod-guia-pill" title="Ver la guía de roles y accesos">
      <i class="fa fa-key"></i>
      <span>Ver guía de roles</span>
    </a>
  </div>
</template>

<script>
export default {
  props: {
    url: { type: String, default: '/ayuda_guia_roles' },
    // true cuando la pantalla ya tiene el botón Ayuda al lado
    conAyuda: { type: Boolean, default: true },
    // true para dejarlo en su lugar en vez de llevarlo al encabezado
    enLinea: { type: Boolean, default: false },
  },
  computed: {
    visible() {
      return this.$can('M_roles') || this.$can('M_roles_edita') || this.$can('M_usuarios') || this.$can('M_usuarios_edita');
    },
  },
  mounted() {
    if (this.enLinea || !this.visible) return;
    const contentHeader = document.querySelector('.content-header');
    if (!contentHeader || !this.$el) return;
    contentHeader.style.position = contentHeader.style.position || 'relative';
    contentHeader.appendChild(this.$el);
    this.$el.classList.add('enod-guia-in-header');
    if (this.conAyuda) this.$el.classList.add('enod-guia-con-ayuda');
  },
};
</script>

<style scoped>
.enod-guia-row { display: inline-flex; line-height: 1; }
.enod-guia-in-header {
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  z-index: 5;
}
.enod-guia-in-header.enod-guia-con-ayuda { right: 125px; }
.enod-guia-pill {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  border: 1px solid #d6dce3;
  background: #fff;
  color: #1a1a1a;
  border-radius: 999px;
  padding: 7px 14px;
  font-size: 12.5px;
  font-weight: 700;
  line-height: 1;
  text-decoration: none;
  white-space: nowrap;
  transition: all 0.12s ease;
}
.enod-guia-pill:hover,
.enod-guia-pill:focus {
  text-decoration: none;
  color: #1a1a1a;
  border-color: #FFCC00;
  box-shadow: 0 2px 8px rgba(255, 204, 0, 0.45);
}
</style>
