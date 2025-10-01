<template>
    <div class="container-fluid p-2 pt-5">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h5>Registrar Entrada</h5>
            </div>
        </div>

        <form @submit.prevent="submitreq(this)" ref="formRef">
            <div class="row mt-3">
                <div class="col-12 col-lg-4 mt-3">
                    <search-material-component></search-material-component>
                </div>

                <div class="col-12 col-lg-4 mt-3">
                    <search-lote-component></search-lote-component>
                </div>


                <div class="col-12 col-lg-5 mt-3">
                    <b-form-textarea
                            id="textarea"
                            v-model="descricao"
                            placeholder="Descrição do Material"
                            rows="1"
                            max-rows="6"
                            name="descricao"
                    ></b-form-textarea>
                </div>

                <div class="col-12 col-lg-3 mt-3">
                    <b-input-group prepend="Quantidade" class="mb-2">
                        <b-form-input aria-label="First name" v-model="quantidade" type="number" name="quantidade"></b-form-input>
                    </b-input-group>
                    <div class="error">{{ errors.quantidade[0]}}</div>
                </div>
            </div>


            <div class="row mt-3">
                <div class="col-12 col-lg-3">
                    <b-input-group prepend="Total" class="mb-2">
                        <b-form-input aria-label="First name" disabled :value="total <= 0 ? '' : floatToCurrency(total)"></b-form-input>
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
                    <button class="btn btn-outline-success" type="submit" :disabled="!stateIcon || !stateIconLote">Adicionar</button>
                </div>
            </div>
        </form>

    </div>
</template>

<script setup>
    import { request } from '@/composables/request';
    import { computed, onMounted, ref } from 'vue';
    import SearchMaterialComponent from '@/components/Zyora/SearchMaterialComponent.vue';
    import SearchLoteComponent from '@/components/Zyora/SearchLoteComponent.vue';
    import { useStore } from 'vuex';
    import { useRouter } from 'vue-router';
    import { floatToCurrency } from '@/composables/auxiliars';

    const message= ref("")
    const store= useStore()
    const router= useRouter()
    const colorMessage= ref("")
    const descricao= ref("")
    const quantidade= ref("")
    const total= computed(() => {
        const ventrada = store.getters.getSearchmaterial.material_selected.ventrada || 0
        const qtd = parseInt(quantidade.value || 0)
        return qtd * ventrada
    })
    const errors= ref({
        "quantidade": ""
    })

    const stateIcon= computed(() => {
        return store.getters.getSearchmaterial.finded
    })

    const stateIconLote= computed(() => {
        return store.getters.getSearchmaterial.lote_finded
    })

    const formRef= ref("")

    const submitreq= () => {
        const formData = new FormData(formRef.value)

        // Se preferir já em objeto JSON:
        var data = Object.fromEntries(formData)

        data.total= total.value
        data.material_id= store.getters.getSearchmaterial.material_selected.id

        console.log(data)

        request("post","api/entradas/adicionar",data,true).then((res) => {
            message.value= res.data.message
            colorMessage.value= "green"
            router.push("/zyora/app/entradas/listar")
        }).catch((err) => {
            errors.value.quantidade= err.response.data.quantidade
        })
        
    }

    onMounted(() => {
        
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
