<template>
    <div>
      <h1>{{ message }}</h1>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        message: 'Hello from Vue 3!'
      };
    }
  };
  </script>
  
  <style scoped>
  h1 {
    color: #42b983;
  }
  </style>
  