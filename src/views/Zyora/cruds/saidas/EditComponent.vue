<template>
    <div class="container-fluid p-2 pt-5">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h5>Vincular Material</h5>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-4">
                <b-input-group prepend="Material Requisitado" class="mb-2">
                    <b-form-input :value="requisicao.material_req"  disabled></b-form-input>
                </b-input-group>
            </div>
            <div class="col-12 col-lg-4">
                <b-input-group prepend="Quantidade Requisitada" class="mb-2">
                    <b-form-input :value="requisicao.quantidade"  disabled></b-form-input>
                </b-input-group>
            </div>
            <div class="col-12 col-lg-4">
                <b-input-group prepend="Quantidade liberada" class="mb-2">
                    <b-form-input v-model="quantidade_liberada" type="number"></b-form-input>
                    <button class="btn btn-primary" @click="atualizar_quantidade_liberada">Atualizar</button>
                </b-input-group>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-4">
                <search-material-component></search-material-component>
            </div>
            <div class="col-12 col-lg-4">
                <search-lote-component></search-lote-component>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-4">
                    <b-form-select v-model="selected" :options="options" @change="AuxLoadInitial= false"></b-form-select>
            </div>
        </div>

        <div class="row mt-3" v-show="requisicao.material">
            <div class="col-12 col-lg-4">
                <b-input-group prepend="ID Selecionado" class="mb-2">
                    <b-form-input :value="requisicao.material?.id"  disabled></b-form-input>
                </b-input-group>
            </div>
            <div class="col-12 col-lg-4">
                <b-input-group prepend="Material Selecionado" class="mb-2">
                    <b-form-input :value="requisicao.material?.name"  disabled></b-form-input>
                </b-input-group>
            </div>

            <div class="col-12 col-lg-4">
                <b-input-group prepend="Quantidade Atual" class="mb-2">
                    <b-form-input :value="requisicao.material?.qtdatual"  disabled></b-form-input>
                </b-input-group>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 mb-3">Ações<hr></div>
            
            <div class="col-12 col-lg-2 text-left" v-if="requisicao?.aprovado_por == null && material_selected.finded || requisicao.material">
                <div v-show="requisicao.quantidade_liberada  <= requisicao.material?.qtdatual && requisicao?.aprovado_por == null">
                    <button class="btn btn-success" @click="aprovar">Aprovar</button>
                </div>
                <div v-show="requisicao.quantidade_liberada  > requisicao.material?.qtdatual  && requisicao?.aprovado_por == null">
                    <button class="btn btn-danger">Quantidade Insuficiente</button>
                </div>
                <h5 class="btn btn-outline-success" v-if="requisicao?.aprovado_por != null">Requisição Aprovada!</h5>
            </div>
            <div class="col-12 col-lg-2 text-left">
                <div  v-if="requisicao?.aprovado_por != null && requisicao?.confirm_retirada == 0">
                    <button class="btn btn-primary" @click="retirada">Fazer retirada</button>
                </div>
                <div>
                    <h5 class="btn btn-outline-success" v-if="requisicao?.confirm_retirada == 1">Retirada Realizada!</h5>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-6 text-lg-start text-center">
                <h5 :style="'color:' + colorMessage">{{ message }}</h5>
            </div>
        </div>

    </div>
</template>

<script setup>
    import { request } from '@/composables/request';
    import { computed, onMounted, ref, watch } from 'vue';
    import { useRoute } from 'vue-router';
    import SearchMaterialComponent from '@/components/Zyora/SearchMaterialComponent.vue';
    import SearchLoteComponent from '@/components/Zyora/SearchLoteComponent.vue';
    import { useStore } from 'vuex';

    const store= useStore()
    const AuxLoadInitial = ref(true)

    const options= [
        {value: 'Aberta', text: 'Aberta'},
        {value: 'Cancelada', text: 'Cancelada'},
        {value: 'Em análise', text: 'Em análise'},
        {value: 'Resolvida', text: 'Resolvida'}
    ]

    const message= ref("")
    const colorMessage= ref("")
    const route= useRoute()
    const requisicao= ref({
        "aprovado_por": null,
        "material_id": null,
        "status": null,
        "confirm_retirada": null,
        "material_req": null,
        "material": null,
        "quantidade_liberada": null
    })
    const user= ref("")
    const selected= ref("")
    const quantidade_liberada= ref("")

    const atualizar_quantidade_liberada= () => {
        request("post","api/requisicoes/update",{
            "id": requisicao.value.id,
            "quantidade_liberada": quantidade_liberada.value
        }, true).then(
            message.value= "Quantidade a ser liberada atualizada!",
            colorMessage.value= "green",
            loadDefault()
        )
    }

    const loadDefault= () => {
        request("get","api/requisicoes/edit/" + route.params.id,{},true).then((res) => {
            requisicao.value= res.data
            selected.value=  requisicao.value.status
            quantidade_liberada.value= requisicao.value.quantidade_liberada
        }).catch((errors) => {
            console.log(errors)
        })
    }

    const material_selected= computed(() => {
        return store.getters.getSearchmaterial
    })

    const retirada= () => {
        request("post","api/requisicoes/update",{
            "id": requisicao.value.id,
            "confirm_retirada": true
        }, true).then(
            message.value= "Retirada Realizada!",
            colorMessage.value= "green",
            loadDefault()
        )
    }


    watch(() => store.getters.getSearchmaterial.lote_finded, () => {
        request("post","api/requisicoes/update",{
            "id": requisicao.value.id,
            "material_id": store.getters.getSearchmaterial.material_selected.id
        }, true).then(
            message.value= "Material vinculado!",
            colorMessage.value= "green",
            loadDefault()
        )
    })

    watch(requisicao, () => {
        message.value= ""
    })

    watch(selected, (newValue) => {
        if(!AuxLoadInitial.value){
            request("post","api/requisicoes/update",{
                "id": requisicao.value.id,
                "status": newValue
            }, true).then(
                message.value= "Status atualizado!",
                colorMessage.value= "green"
            )
        }
    })

    const aprovar= () => {
        request("post","api/requisicoes/update",{
                "id": requisicao.value.id,
                "aprovado_por": user.value.id
            }, true).then(
                message.value= "Requisição aprovada!",
                colorMessage.value= "green",
                loadDefault()
            )
    }

    onMounted(() => {
        loadDefault()

        request("get","api/user",{}, true).then((res) => {
            user.value= res.data
        }).catch((errors) => {
            console.log(errors)
        })
    })
</script>

<style scoped>

</style>
