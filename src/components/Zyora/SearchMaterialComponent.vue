<template>
    <div>
        <b-input-group prepend="Material" class="mb-2">
            <template #append>
                <b-input-group-text>
                    <div v-show="stateIcon">
                        <i class="bi bi-hand-thumbs-up" style="color: green"></i>
                    </div>
                    <div v-show="!stateIcon">
                        <i class="bi bi-x-circle" style="color: red"></i>
                    </div>
                </b-input-group-text>
            </template>
            <b-form-input v-model="material" type="text" name="material"></b-form-input>

        </b-input-group>

        <div class="menu-select" v-if="!stateIcon && material != ''">
            <div class="menu-select-item" v-for="(material, key) in materials_list_filtered" :key="key" v-show="key <= 4" @click="submitmaterial(material)">
                {{  material }}
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed, onMounted, ref, watch } from 'vue'
    import { useStore } from 'vuex'
    import { request } from '@/composables/request'
    
    const store= useStore()
    const material = ref("")
    const materials_list= ref({})
    const materials_list_filtered= ref([])

    const stateIcon= computed(() => {
        return store.getters.getSearchmaterial.finded
    }) 


    
    watch(material, (newValue) => {
        if (newValue === "") {
         store.commit("setFindedSearchmaterial", false)
         materials_list_filtered.value = []
         return
        }

        store.commit("setNameSearchmaterial","")

        // procura no array apenas os que batem com o valor digitado
        materials_list_filtered.value = Object.values(materials_list.value)
            .filter(item => item.name.toLowerCase().includes(newValue.toLowerCase()))
            .map(item => item.name)

        // remove duplicados
        materials_list_filtered.value = [...new Set(materials_list_filtered.value)]

        // se encontrou correspondência exata, muda ícone
        const hasExactMatch = materials_list_filtered.value.includes(newValue)
        store.commit("setFindedSearchmaterial", hasExactMatch)

        if(hasExactMatch){
            store.commit("setNameSearchmaterial",newValue)
        }
    })

    /*const searchResponsive= (pesquisar) => {
        request("post","api/materiais/all",{ "notpgnt": true, "search": pesquisar}, true).then((res) =>{
            materials_list.value= res.data
        })
    }*/

    const submitmaterial= (mat) => {
        material.value= mat
        mat
    }

    onMounted(() => {
        request("post","api/materiais/all",{ "notpgnt": true}, true).then((res) =>{
            materials_list.value= res.data
        })
    })

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

