<template>
  <div class="metodos-equipo">
    <span v-for="m in lista" :key="m.id" class="metodo-chip"
          :title="m.descripcion">{{ m.metodo }}</span>
  </div>
</template>

<script>
  export default {
    props: {
      equipo: {
        type: Object,
        required: false,
        default: function () { return {} }
      }
    },
    computed: {
      // Método principal primero, después el resto de los métodos del equipo
      lista: function () {
        var e = this.equipo || {};
        var principal = e.metodo_ensayos;
        var otros = (e.metodos || []).filter(m => !principal || m.id !== principal.id);
        return principal ? [principal, ...otros] : otros;
      }
    }
  }
</script>

<style scoped>
.metodos-equipo {
  display: flex;
  flex-wrap: wrap;
  min-width: 64px;
  max-width: 190px;
}
.metodo-chip {
  display: inline-block;
  margin: 1px 4px 1px 0;
  padding: 0 8px;
  border-radius: 10px;
  background: #e8edf2;
  color: #333;
  font-size: 11px;
  font-weight: 600;
  line-height: 18px;
  white-space: nowrap;
}
</style>
