import LoginZyoraView from "@/views/Zyora/LoginZyoraView.vue";
import AppZyoraView from "@/views/Zyora/views/AppZyoraView.vue";
import { request } from "@/composables/request";
import DashboardZyoraView from "@/views/Zyora/subviews/DashboardZyoraView.vue";
import EntradasZyoraView from "@/views/Zyora/subviews/EntradasZyoraView.vue";
import SaidasZyoraView from "@/views/Zyora/subviews/SaidasZyoraView.vue";
import MateriaisZyoraView from "@/views/Zyora/subviews/MateriaisZyoraView.vue";
import FornecedoresZyoraView from "@/views/Zyora/subviews/FornecedoresZyoraView.vue";
import UsuariosZyoraView from "@/views/Zyora/subviews/UsuariosZyoraView.vue";
import AddComponentMateriais from "@/views/Zyora/cruds/materiais/AddComponent.vue";
import AddComponentFornecedores from "@/views/Zyora/cruds/fornecedores/AddComponent.vue";
import ListComponentFornecedores from "@/views/Zyora/cruds/fornecedores/ListComponent.vue";
import EditComponentFornecedores from "@/views/Zyora/cruds/fornecedores/EditComponent.vue";
import EditComponentMaterial from "@/views/Zyora/cruds/materiais/EditComponent.vue";
import ListComponentMaterial from "@/views/Zyora/cruds/materiais/ListComponent.vue";
import AddComponentEntrada from "@/views/Zyora/cruds/entradas/AddComponent.vue";
import ColetorZyoraView from "@/views/Zyora/views/ColetorZyoraView.vue";
import ListComponentEntrada from "@/views/Zyora/cruds/entradas/ListComponent.vue";
import RequisicoesZyoraView from "@/views/Zyora/subviews/RequisicoesZyoraView.vue";
import AddComponentColetor from "@/views/Zyora/cruds/coletor/AddComponent.vue";
import ListComponentColetor from "@/views/Zyora/cruds/coletor/ListComponent.vue";
import AddComponentSaida from "@/views/Zyora/cruds/saidas/AddComponent.vue";
import ListComponentSaida from "@/views/Zyora/cruds/saidas/ListComponent.vue";
import EditComponentSaida from "@/views/Zyora/cruds/saidas/EditComponent.vue";

const routes= [
  {
    path: '/zyora',
    name: 'mainzyora',
    component: LoginZyoraView
  },
  {
    path: '/zyora/coletor',
    name: 'coletorzyora',
    component: ColetorZyoraView,
    beforeEnter: (to, from, next) => {
      request("get","api/user",{},true).then((res) => {
        if(res.data.user_type == "coletor"){
          next()
        }else{
          next("/zyora/app")
        }
        
      }).catch(() => {
        next("/zyora")
      })
    },
    children: [
      {
        path: "requisicoes",
        component: RequisicoesZyoraView,
        children: [
          {
            path: "adicionar",
            component: AddComponentColetor
          },
          {
            path: "list",
            component: ListComponentColetor
          }
        ]
      }
    ]
  },
  {
    path: '/zyora/app',
    name: 'appzyora',
    component: AppZyoraView,
    beforeEnter: (to, from, next) => {
      request("get","api/user",{},true).then((res) => {
        if(res.data.user_type != "coletor"){
          next()
        }else{
          next("/zyora/coletor")
        }
        
      }).catch(() => {
        next("/zyora")
      })
    },
    children: [
      {
        path: 'dashboard',
        name: 'dashboardzyora',
        component: DashboardZyoraView
      },
      {
        path: 'entradas',
        name: 'entradaszyora',
        component: EntradasZyoraView,
        children: [
          {
            path: 'adicionar',
            component: AddComponentEntrada
          },
          {
            path: 'listar',
            component: ListComponentEntrada
          }
        ]
      },
      {
        path: 'saidas',
        name: 'saidaszyora',
        component: SaidasZyoraView,
        children: [
          {
            path: "adicionar",
            component: AddComponentSaida
          },
          {
            path: "listar",
            component: ListComponentSaida
          },
          {
            path: "edit/:id",
            component: EditComponentSaida
          }
        ]
      },
      {
        path: 'materiais',
        name: 'materiaszyora',
        component: MateriaisZyoraView,
        children: [
          {
            path: "adicionar",
            component: AddComponentMateriais
          },
          {
            path: "edit/:id",
            component: EditComponentMaterial
          }, 
          {
            path: "listar",
            component: ListComponentMaterial
          }, 
        ]
      },
      {
        path: 'fornecedores',
        name: 'fornecedoreszyora',
        component: FornecedoresZyoraView,
        children: [
          {
            path: "adicionar",
            component: AddComponentFornecedores
          },
          {
            path: "listar",
            component: ListComponentFornecedores
          },
          {
            path: "edit/:id",
            component: EditComponentFornecedores
          }
        ]
      },
      {
        path: 'usuarios',
        name: 'usuarioszyora',
        component: UsuariosZyoraView
      },
    ]
  }

]

export default routes;