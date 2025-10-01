<template>
    <div>
        <subview-navbar-component
            add="Adicionar"
            add_link="/zyora/coletor/requisicoes/adicionar"
            edit="Requisições"
            edit_link="/zyora/coletor/requisicoes/list"
        ></subview-navbar-component> 
        <router-view></router-view>
    </div>
</template>

<script setup>
    import SubviewNavbarComponent from '@/components/Zyora/SubviewNavbarComponent.vue';
</script>

<style scoped>

</style>
