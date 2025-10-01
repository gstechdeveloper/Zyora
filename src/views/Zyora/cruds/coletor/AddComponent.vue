<template>
    <div class="container-fluid p-2 pt-5">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h5>Adicionar Requisição</h5>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-3">
                <search-material-name-zyora v-model="material_req"></search-material-name-zyora>
                <div class="error">{{ errors.material_req?.[0] }}</div>
            </div>

            <div class="col-12 col-lg-5">
                <b-form-textarea
                    id="textarea"
                    v-model="descricao"
                    placeholder="Descrição da requisição"
                    rows="1"
                    max-rows="6"
                    name="descricao"
                ></b-form-textarea>
            </div>
            <div class="col-12 col-lg-4 mt-2">
                <b-input-group prepend="Quantidade" class="mb-2">
                        <b-form-input aria-label="First name" type="number" v-model="quantidade"></b-form-input>
                </b-input-group>
                <div class="error">{{ errors.quantidade?.[0] }}</div>
            </div>

        </div>


        <div class="row mt-3">
            <div class="col-12 col-lg-6 text-lg-start text-center">
                <h5 style="color: green">{{ message }}</h5>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-6 text-lg-start text-center">
                <button class="btn btn-outline-success" @click="adicionar">Adicionar</button>
            </div>
        </div>
    </div>
</template>

<script setup>
    import SearchMaterialNameZyora from '@/components/Zyora/SearchMaterialNameZyora.vue';
    import { request } from '@/composables/request';
    import { ref, watch } from 'vue';

    const material_req= ref("")
    const descricao= ref("")
    const quantidade= ref("")
    const errors= ref("")
    const message= ref("")

    watch([material_req,quantidade,],() => {
        errors.value= ""
    })

    const adicionar= () => {
        request("post","api/requisicoes/adicionar",{
            "material_req": material_req.value,
            "descricao": descricao.value || " ",
            "quantidade": quantidade.value,
            "quantidade_liberada": quantidade.value
        }, true).then((res) => {
            console.log(res)
            message.value= res.data.message
            material_req.value= ""
            quantidade.value= ""
            descricao.value= ""
        }).catch((error) => {
            console.log(error)
            errors.value= error.response.data.errors
        })
    }
</script>

<style scoped>
    .error{
        color: red;
        text-align: center;
        font-size: 0.7rem;
    }
</style>
