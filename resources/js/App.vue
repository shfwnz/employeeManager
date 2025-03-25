<template>
    <div id="app" class="p-20">
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
