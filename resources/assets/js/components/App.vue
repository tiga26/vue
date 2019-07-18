<template>
  <div id="app">
    <div class="heading">
      <h1>Tests</h1>
    </div>
    <div>
      <input type="text" name="name"/>
      <button @click="create()">Add</button>
    </div>
    <test-component
      v-for="test in tests"
      v-bind="test"
      :key="test.id"
    ></test-component>
  </div>
</template>

<script>
  function Test({ id, name}) {
    this.id = id;
    this.name = name;
  }

  import Test from './Test.vue';

  export default {
    mounted() {
      console.log('Component mounted.')
    },
    data() {
      return {
        tests: []
      }
    },
    methods: {
      create() {
        window.axios.post('/api/tests', this.post).then((response) => {
          this.tests.push(new Test({response.id, response.name}));
        });
      },
      read() {
        window.axios.get('/api/tests').then(({ data }) => {
          data.forEach(test => {
            this.tests.push(new Test({test.id, test.name}));
          });
        });
      }
    },
    components: {
      Test
    },
    created() {
      this.read();
    }
  }
</script>