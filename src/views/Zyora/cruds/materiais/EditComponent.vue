<template>
    <div class="container-fluid p-2 pt-5">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h5>Editar Material</h5>
            </div>
        </div>
        <hr>

        <div class="row mt-3">
            <div class="col-12 col-lg-3">
                <b-input-group prepend="Nome" class="mb-2">
                    <b-form-input v-model="name"></b-form-input>
                </b-input-group>
                <div class="error">{{ errors.name[0] }}</div>
            </div>
            <div class="col-12 col-lg-3">
                <b-form-textarea
                    id="textarea"
                    v-model="descricao"
                    placeholder="Descrição do Material"
                    rows="1"
                    max-rows="6"
                ></b-form-textarea>
            </div>

            <div class="col-12 col-lg-3">
                <b-input-group prepend="Vencimento" class="mb-2">
                    <b-form-input v-model="vencimento" type="date"></b-form-input>
                </b-input-group>
                <div class="error">{{ errors.vencimento[0] }}</div>
            </div>

            <div class="col-12 col-lg-3">
                <b-input-group prepend="Valor Entrada" class="mb-2">
                    <b-form-input v-model="ventrada" type="number"></b-form-input>
                </b-input-group>
                <div class="error">{{ errors.ventrada[0] }}</div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 col-lg-3">
                <b-input-group prepend="Valor Saída" class="mb-2">
                    <b-form-input v-model="vsaida" type="number"></b-form-input>
                </b-input-group>
                <div class="error">{{ errors.vsaida[0] }}</div>
            </div>
            <div class="col-12 col-lg-3">
                <b-input-group prepend="Estoque mínimo" class="mb-2">
                    <b-form-input v-model="qtdmin" type="number"></b-form-input>
                </b-input-group>
                <div class="error">{{ errors.qtdmin[0] }}</div>
            </div>
            <div class="col-12 col-lg-3">
                <b-input-group prepend="Estoque médio" class="mb-2">
                    <b-form-input v-model="qtdmedia" type="number"></b-form-input>
                </b-input-group>
                <div class="error">{{ errors.qtmedia[0] }}</div>
            </div>

            <div class="col-12 col-lg-3">
                <b-input-group prepend="Estoque máximo" class="mb-2">
                    <b-form-input v-model="qtdmax" type="number"></b-form-input>
                </b-input-group>
                <div class="error">{{ errors.qtmax[0] }}</div>
            </div>
        </div>

        

        <div class="row mt-3">
            <div class="col-12 col-lg-3">
                <search-fornecedor-component :fornecedor_txt="fornecedor_txt"></search-fornecedor-component>
            </div>
            <div class="col-12 col-lg-3">
                <b-input-group prepend="Lote" class="mb-2">
                    <b-form-input v-model="lote" type="text"></b-form-input>
                </b-input-group>
                <div class="error">{{ errors.lote[0] }}</div>
            </div>
        </div>
        

        <div class="row mt-3">
            <div class="col-12 col-lg-6 text-lg-start text-center">
                <h5 style="color: green; margin-top: 20px; margin-bottom: 20px; font-size: 1rem;">{{ message }}</h5>
                <button class="btn btn-outline-success" @click="atualizar" :disabled="!fornecedor_finded">Atualizar</button>
            </div>
        </div>

    </div>
</template>

<script setup>

    import SearchFornecedorComponent from '@/components/Zyora/SearchFornecedorComponent.vue';
    import { computed, onMounted, ref, watch } from 'vue';
    import { useStore } from 'vuex';
    import { useRoute } from 'vue-router';
    import { request } from '@/composables/request';


    const route= useRoute()
    const state= useStore().state 
    const fornecedor_finded= computed(() => state.searchfornecedor.finded);
    const fornecedor_id= computed(() => state.searchfornecedor.id); 
    var name= ref("")
    var vencimento= ref("")
    var descricao= ref("")
    var ventrada= ref("")
    var vsaida= ref("")
    var qtdmin= ref("")
    var qtdmedia= ref("")
    var qtdmax= ref("")
    var lote= ref("")
    var fornecedor_txt= ref("")
    const message= ref("")
    const errors= ref({
        "name": [],
        "vencimento": [],
        "ventrada": [],
        "vsaida": [],
        "qtdmin": [],
        "qtmedia": [],
        "qtmax": [],
        "lote": []
    })

    watch([name,vencimento,descricao,ventrada,vsaida,qtdmin,qtdmedia,qtdmax,lote], () => {
        errors.value= {
            "name": [],
            "vencimento": [],
            "ventrada": [],
            "vsaida": [],
            "qtdmin": [],
            "qtmedia": [],
            "qtmax": [],
            "lote": []
        }
        message.value= ""
    })

    const atualizar= () => { 
        if(fornecedor_finded.value){
            request("post","api/materiais/update",{
                "id": route.params.id,
                "name": name.value,
                "vencimento": vencimento.value,
                "descricao": descricao.value,
                "ventrada": ventrada.value,
                "vsaida": vsaida.value,
                "qtdmin": qtdmin.value,
                "qtmedia": qtdmedia.value,
                "qtmax": qtdmax.value,
                "lote": lote.value,
                "fornecedor_id": fornecedor_id.value
            }).then((res) => {
                message.value= res.data.message
            }).catch((err) => {
                console.log(err)
                var fdbk= err.response.data.errors
                errors.value.name = fdbk.name || []
                errors.value.vencimento= fdbk.vencimento || []
                errors.value.ventrada= fdbk.ventrada || []
                errors.value.vsaida= fdbk.vsaida || []
                errors.value.qtdmin= fdbk.qtdmin || []
                errors.value.qtmedia= fdbk.qtmedia || []
                errors.value.qtmax= fdbk.qtmax || []
                errors.value.lote= fdbk.lote || []
            })
        }
    }

    onMounted(() =>{
        request("get","api/materiais/edit/" + route.params.id,{}, true).then((res) =>{
            name.value= res.data.name
            vencimento.value= res.data.vencimento
            descricao.value= res.data.descricao
            ventrada.value= res.data.ventrada
            vsaida.value= res.data.vsaida
            qtdmin.value= res.data.qtdmin
            qtdmedia.value= res.data.qtmedia
            qtdmax.value= res.data.qtmax
            lote.value= res.data.lote
            state.searchfornecedor.finded= true
            state.searchfornecedor.id= res.data.fornecedor.id
            fornecedor_txt.value= res.data.fornecedor.name

        })
    })
</script>

<style scoped>
    .btn:disabled, .btn-outline-success:disabled{
        color: gray;
        border-color: gray;
    }

    .error{
        color: red;
        text-align: center;
        font-size: 0.7rem;
    }
</style>
