<template>
    <div>
        <h5>Entradas</h5>
        <subview-navbar-component
            add_link="/zyora/app/entradas/adicionar"
            edit_link="/zyora/app/entradas/listar"
        ></subview-navbar-component>
        <router-view></router-view>
    </div>
</template>

<script setup>
    import SubviewNavbarComponent from '@/components/Zyora/SubviewNavbarComponent.vue';
</script>

<style scoped>
    h5{
        margin-bottom: 30px;
    }
</style>
