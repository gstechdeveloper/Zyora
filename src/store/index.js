import { createStore } from 'vuex'

export default createStore({
  state: {
    searchfornecedor: {
      "finded": false,
      "id": -1
    },
    searchmaterial: {
      "finded": false,
      "lote_finded": false,
      "material_selected": {},
      "name": "",
      "lote": ""
    }
  },
  getters: {
    getSearchmaterial: (state) => state.searchmaterial,
    getSearchFornecedor: (state) => state.searchfornecedor
  },
  mutations: {
    setFindedSearchmaterial(state, value){
      state.searchmaterial.finded= value
    },
    setNameSearchmaterial(state, value){
      state.searchmaterial.name= value
    },
    setLoteSearchmaterial(state, value){
      state.searchmaterial.lote= value
    },
    setLoteFindedSearchmaterial(state, value){
      state.searchmaterial.lote_finded= value
    },
    setMaterialSelectedSearchmaterial(state, value){
      state.searchmaterial.material_selected= value
    },

    setFornecedorFinded(state, value){
      state.searchfornecedor.finded= value
    },

    setFornecedorId(state, value){
      state.searchfornecedor.id= value
    }
  },
  actions: {
  },
  modules: {
  }
})
