<script>
  export default {
    methods: {
      $can(permissionName) {
        return Laravel.permissions.map(x => x.name).indexOf(permissionName) !== -1;
      },
    },
  };
</script>