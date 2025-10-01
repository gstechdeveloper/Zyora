<template>
        <div class="col-4">
            <RouterLink class="link" to="/zyora/coletor/requisicoes">Requisições</RouterLink>
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
    .col-4{
        display: flex;
        padding: 0px;
    }
</style>
