<template>
    <div v-if="stateIconMaterial">
        <b-input-group prepend="Lote" class="mb-2">
            <template #append>
                <b-input-group-text>
                    <div v-show="stateIconLote">
                        <i class="bi bi-hand-thumbs-up" style="color: green"></i>
                    </div>
                    <div v-show="!stateIconLote">
                        <i class="bi bi-x-circle" style="color: red"></i>
                    </div>
                </b-input-group-text>
            </template>
            <b-form-input v-model="lote" type="text" name="lote"></b-form-input>

        </b-input-group>

        <div class="menu-select" v-if="!stateIconLote && lote != ''">
            <div class="menu-select-item" v-for="(lote, key) in lote_list" :key="key" @click="submitlote(lote)">
                {{ lote.lote }}
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed, ref, watch} from 'vue'
    import { useStore } from 'vuex'
    import { request } from '@/composables/request'
    
    const store= useStore()
    const lote = ref("")
    const lote_list= ref({})

    const stateIconLote = computed(() => {
        return store.getters.getSearchmaterial.lote_finded
    })

    const stateIconMaterial= computed(() =>{
        return store.getters.getSearchmaterial.finded
    });

    watch(stateIconMaterial, (newValue) => {
        if(!newValue){
            lote.value= ""
            store.commit("setLoteFindedSearchmaterial", false)
            store.commit("setLoteSearchmaterial", "")
        }
    })

    watch(lote, (newValue) => {
        if(newValue == "") {
            store.commit("setLoteFindedSearchmaterial",false)
            return 
        }

        searchLote(newValue)

        

        Object.keys(lote_list).forEach((key) => {
            if(lote_list[key] == newValue){
                submitlote(newValue)
                return
            }
        })
    })

    const submitlote= (lt) => {
        lote.value= lt.lote
        store.commit("setLoteSearchmaterial", lt.lote)
        store.commit("setLoteFindedSearchmaterial", true)
        store.commit("setMaterialSelectedSearchmaterial", lt)
    }
    
    const searchLote= (value) => {
        console.log(store.getters.getSearchmaterial.name + " - " + value)
        request("post","api/materiais/select",{
            "name": store.getters.getSearchmaterial.name,
            "lote":  value
        }, true).then((res) => {
            lote_list.value=  res.data;
            if(res.data.lote){
                submitlote(res.data.lote)
            }
        })
    }
   
</script>

<style scoped>
    .menu-select{
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        transition: 5s height;
    }

    .menu-select-item{
        padding: 5px;
        border-radius: 5px;
    }
    .menu-select-item:hover{
        background: #0f384c;
        color: white;
        cursor: pointer;
    }
</style>

