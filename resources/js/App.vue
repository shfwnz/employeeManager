<template>
    <div id="app">
        <Navbar />
        <router-view />
    </div>
</template>

<script>
import Navbar from "./components/Navbar.vue";

export default {
    components: { Navbar },
};
</script>

<style>
#app {
    font-family: Arial, sans-serif;
    padding: 20px;
}
</style>
