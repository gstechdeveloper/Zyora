<template>
    <div>
        <h5>Materiais</h5>
        <subview-navbar-component
            add_link="/zyora/app/materiais/adicionar"
            edit_link="/zyora/app/materiais/listar"
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
