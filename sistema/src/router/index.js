import Vue from 'vue'
import Router from 'vue-router'
import login from '@/components/login'
import AddUsuario from '@/components/AddUsuario'
import AddTurma from '@/components/AddTurma'
import CadastroAtividade from '@/components/CadastroAtividade'
import ListaSolicitacao from '@/components/ListaSolicitacao'
import ListaTurma from '@/components/ListaTurma'
import Visualiza from '@/components/Visualiza'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: '/projetovuejs/',
  routes: [

    {
      path: '/visualiza/:id',
      name: 'visualiza',
      component: Visualiza
    },

    {
      path: '/',
      name: 'listasolicitacao',
      component: ListaSolicitacao
    },
    
    {
      path: '/listaturma',
      name: 'turma',
      component: ListaTurma
    },

    {
      path: '/atividade',
      name: 'atividade',
      component: CadastroAtividade
    },
    {
      path: '/atividade/:id',
      name: 'editatividade',
      component: CadastroAtividade
    },

    {
      path: '/login',
      name: 'login',
      component: login
    },
    {
      path: '/addusuario',
      name: 'addusuario',
      component: AddUsuario
    },
    {
      path: '/addturma',
      name: 'addturma',
      component: AddTurma
    },



  ]
})
