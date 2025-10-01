<template>
    <div>
        <subview-navbar-component
            add="Adicionar"
            add_link="/zyora/app/saidas/adicionar"
            edit="Listar"
            edit_link="/zyora/app/saidas/listar"
        ></subview-navbar-component>

        <router-view></router-view>
    </div>
</template>

<script setup>
    import SubviewNavbarComponent from '@/components/Zyora/SubviewNavbarComponent.vue';
</script>

<style scoped>

</style>
