<template>
    <div class="container-fluid p-2 pt-5">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h5>Editar Fornecedor</h5>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-6">
                <b-input-group prepend="Nome do Fornecedor" class="mb-2">
                    <b-form-input aria-label="First name" v-model="fornecedor"></b-form-input>
                </b-input-group>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-6 text-lg-start text-center">
                <h5 :style="'color:' + colorMessage">{{ message }}</h5>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-6 text-lg-start text-center">
                <button class="btn btn-outline-success" @click="atualizar">Atualizar</button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { request } from '@/composables/request';
    import { onMounted, ref, watch } from 'vue';
    import { useRoute } from 'vue-router';

    const message= ref("")
    const colorMessage= ref("")
    const route= useRoute()
    const fornecedor= ref("")

    watch(fornecedor, () => {
        message.value= ""
    })

    const atualizar= () => { 
        request("post","api/fornecedor/update",{
            "id": route.params.id,
            "name": fornecedor.value
        }).then((res) => {
            message.value= res.data.message
            colorMessage.value= "green"
        }).catch((errors) => {
            message.value= errors.response.data.name[0]
            colorMessage.value= "red"
        })
    }

    onMounted(() => {
        request("get","api/fornecedor/edit/" + route.params.id,{}).then((res) => {
            fornecedor.value= res.data.name
        }).catch((errors) => {
            console.log(errors)
        })
    })
</script>

<style scoped>

</style>
