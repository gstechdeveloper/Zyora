<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h5>Fornecedores</h5>
            </div>
            <div class="col-12">
                <subview-navbar-component
                    add_link="/zyora/app/fornecedores/adicionar"
                    edit_link="/zyora/app/fornecedores/listar"
                ></subview-navbar-component>
            </div>
        </div>
        <div class="row">
            <router-view></router-view>
        </div>
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
