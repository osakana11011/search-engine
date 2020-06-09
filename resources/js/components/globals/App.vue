<template>
  <div>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand " href="/">Search Engine</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">

          <!-- この下の行に mr-auto クラスを付与するだけ -->
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/crawlings" class="nav-link">Crawlings</router-link>
            </li>
          </ul>

          <ul class="navbar-nav">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Menu
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Dummy</a>
              <a class="dropdown-item" href="#">Dummy</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" @click="logout">Logout</a>
            </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Contents -->
    <slot></slot>
  </div>
</template>

<script>
export default {
  methods: {
    logout: function () {
      console.log('logout');
      this.$store.dispatch('logout');
    }
  }
}
</script>

<style scoped>
</style>
