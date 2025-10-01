<template>
    <div class="row">
        <div class="col">
            <router-link class="link" :to="add_link">{{ props.add }}</router-link>
        </div>
        <div class="col px-2">
            <router-link class="link" :to="edit_link">{{ props.edit }}</router-link>
        </div>  
        <div class="col-9">
        </div>   
    </div>
</template>

<script setup>
    import { defineProps } from 'vue';

    const props= defineProps({
        add: {
            type: String,
            default: "Adicionar"
        },
        add_link: {
            type: String,
            default: ""
        },
        edit: {
            type: String,
            default: "Editar"
        },
        edit_link: {
            type: String,
            default: ""
        }
    })
</script>

<style scoped>
    .link{
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        text-decoration: none;
        color: black;
        width: 100%;
        text-align: center;
    }
    .col{
        display: flex;
        padding: 0px;
    }
    .col:first{
        padding-left: 10px;
    }

    .router-link-active{
        background: #213f54;
        color: white;
    }
</style>
