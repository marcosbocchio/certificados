<template>
  <div class="enod-help-row">
    <a :href="url" class="btn btn-enod enod-help-pill" :title="title">
      <i class="fa fa-question-circle"></i>
      <span>Ayuda</span>
    </a>
  </div>
</template>

<script>
export default {
  props: {
    url: { type: String, required: true },
    title: { type: String, default: 'Ver ayuda de esta pantalla' },
    showLabel: { type: Boolean, default: true }, // mantenida por compatibilidad
  },
  mounted() {
    const contentHeader = document.querySelector('.content-header');
    if (!contentHeader || !this.$el) return;
    if (contentHeader.contains(this.$el) && this.$el.classList.contains('enod-help-in-header')) return;

    contentHeader.style.position = contentHeader.style.position || 'relative';
    contentHeader.appendChild(this.$el);
    this.$el.classList.add('enod-help-in-header');
  },
};
</script>

<style scoped>
.enod-help-row {
  display: inline-flex;
  line-height: 1;
}
.enod-help-in-header {
  position: absolute;
  top: 50%;
  right: 15px;
  transform: translateY(-50%);
  margin: 0;
  z-index: 5;
}
.enod-help-pill {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  border-radius: 999px;
  padding: 7px 16px;
  font-size: 13px;
  font-weight: 700;
  line-height: 1;
  text-decoration: none;
  white-space: nowrap;
  transition: all 0.12s ease;
}
.enod-help-pill i { font-size: 14px; }
.enod-help-pill:hover,
.enod-help-pill:focus {
  text-decoration: none;
  box-shadow: 0 2px 8px rgba(255, 204, 0, 0.45);
}
@media (max-width: 480px) {
  .enod-help-pill span { display: none; }
  .enod-help-pill { padding: 7px 9px; }
}
</style>
