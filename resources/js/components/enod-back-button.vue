<template>
  <div class="enod-back-row">
    <button type="button" class="btn btn-enod btn-circle" @click="goBack">
      <span class="fa fa-arrow-left"></span>
      <span v-if="showLabel" class="enod-back-label">Volver</span>
    </button>
  </div>
</template>

<script>
export default {
  props: {
    fallbackUrl: {
      type: String,
      required: true
    },
    showLabel: {
      type: Boolean,
      default: false
    }
  },
  mounted() {
    const contentHeader = document.querySelector('.content-header');
    if (!contentHeader || !this.$el) return;
    const title = contentHeader.querySelector('h1');
    if (!title) return;
    if (title.contains(this.$el)) return;

    title.insertBefore(this.$el, title.firstChild);
    this.$el.classList.add('enod-back-in-header');
  },
  methods: {
    goBack() {
      const hasHistory = window.history.length > 1;
      const referrer = document.referrer || '';
      let isSameOriginReferrer = false;

      if (referrer) {
        try {
          isSameOriginReferrer = new URL(referrer).origin === window.location.origin;
        } catch (e) {
          isSameOriginReferrer = false;
        }
      }

      if (hasHistory && isSameOriginReferrer) {
        window.history.back();
        return;
      }

      window.location.href = this.fallbackUrl;
    }
  }
};
</script>

<style scoped>
.enod-back-row {
  display: flex;
  justify-content: flex-start;
  clear: both;
  margin: 0 0 10px 0;
  line-height: 1;
}

.enod-back-in-header {
  display: inline-flex;
  vertical-align: middle;
  margin: 0 8px 0 0;
}

.enod-back-label {
  margin-left: 6px;
}
</style>
