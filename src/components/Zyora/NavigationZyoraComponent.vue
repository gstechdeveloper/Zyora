<template>
        <!-- <div class="col">
            <RouterLink class="link" to="/zyora/app/dashboard">Dashboard</RouterLink>
        </div> -->
        <div class="col">
            <RouterLink class="link" to="/zyora/app/entradas">Entradas</RouterLink>
        </div>
        <div class="col">
            <RouterLink class="link" to="/zyora/app/saidas">Saidas</RouterLink>
        </div>
        <div class="col">
            <RouterLink class="link" to="/zyora/app/materiais">Estoque</RouterLink>
        </div>
        <div class="col">
            <RouterLink class="link" to="/zyora/app/fornecedores">Fornecedores</RouterLink>
        </div>
</template>

<script setup>

</script>

<style scoped>
    .link{
        padding: 10px;
        border: 1px solid #999;
        border-radius: 5px;
        width: 100%;
        text-align: center;
        text-decoration: none;
        color: black;
        background: white;
        transition: background 1s
    }

    .router-link-active{
        background: #213f54;
        color: white;
    }
    .col{
        display: flex;
        padding: 0px;
    }
</style>
