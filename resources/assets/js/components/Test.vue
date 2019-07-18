<template>
  <div class="test">
    <div class="col-2">
      <h3>{{ name | properCase }}</h3>
    </div>
  </div>
</template>

<script>
  export default {
    computed: {
    },
    methods: {
    },
    props: ['id', 'name'],
    filters: {
    }
  }
</script>