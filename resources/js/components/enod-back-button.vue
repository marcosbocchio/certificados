<template>
  <div class="enod-back-row">
    <button type="button" class="pull-left btn btn-enod btn-circle" @click="goBack">
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
  margin-bottom: 10px;
}

.enod-back-label {
  margin-left: 6px;
}
</style>
