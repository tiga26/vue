<template>
  <div id="app">
    <form @submit.prevent="submit">
      <div class="input-group mb-1">
        <div v-for="name in errors.name" class="text-danger">{{ name }}</div>
      </div>
      <div class="input-group">
        <input type="text" class="form-control" v-model="fields.name" placeholder="Enter a new task">
        <input type="submit" style="position: absolute; left: -9999px"/>
      </div>
    </form>
    <ul class="list-group col-md-6">
      <test-component
        v-for="test in tests"
        v-bind="test"
        :key="test.id"
      ></test-component>
    </ul>
  </div>
</template>

<script>
  function Test({id, name}) {
    this.id = id;
    this.name = name;
  }

  import TestComponent from './Test.vue';

  export default {
    data() {
      return {
        tests: [],
        fields: {},
        errors: {},
        waitingForResponse: false,
      }
    },
    methods: {
      submit() {
        if (!this.waitingForResponse) {
          this.waitingForResponse = true;
          this.errors = {};
          window.axios.post('/api/test', this.fields).then((response) => {
            this.waitingForResponse = false;
            this.tests.unshift(new Test(response.data));
          }).catch(error => {
            this.waitingForResponse = false;
            if (error.response.status === 422) {
              console.log(error.response.data);
              this.errors = error.response.data || {};
            }
          });
        }
      },
      read() {
        window.axios.get('/api/test').then(({ data }) => {
          data.data.forEach(test => {
            this.tests.push(new Test(test));
          });
        });
      }
    },
    components: {
      TestComponent
    },
    created() {
      this.read();
    }
  }
</script>