<template>
  <section class="content" data-app>
    <v-dialog v-model="dialog" persistent max-width="120vh">
      <v-card>
        <v-card-title class="headline">Lista de Alunos</v-card-title>

        <v-card-text>
          <v-data-table
            :headers="headers"
            hide-details
            v-model="selected"
            :items="itens"
            :single-select="singleSelect"
            class="elevation-1"
            hide-actions
            show-select
            style="text-align: center; margin-top:30px"
          >
            <template slot="items" slot-scope="props">
              <td>{{props.item.nome}}</td>
              <td>{{props.item.matricula}}</td>
            </template>
          </v-data-table>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" flat @click="dialog = false">cancelar</v-btn>
          <v-btn color="green darken-1" flat @click="deleteSim">Salvar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-snackbar
      v-model="snackbar"
      :bottom="y === 'bottom'"
      :left="x === 'left'"
      :multi-line="mode === 'multi-line'"
      :right="x === 'right'"
      :timeout="4000"
      :top="y === 'top'"
      :vertical="mode === 'vertical (mobile)'"
      :color="this.cor"
    >
      {{ textoAlerta }}
      &nbsp;
      <b>{{ nomeCampo }}</b>

      <v-btn color="white" flat @click="snackbar = false">Ok!</v-btn>
    </v-snackbar>
    <v-card style="background-color: #b3d4fc;'">
      <v-layout row wrap style="margin-left:6vh; ">
        <span style="color:black; font-size:36px; ">Peer Review Edition</span>
      </v-layout>
    </v-card>
    <v-card style="margin-left: 20vh; margin-top: 15vh; margin-right: 20vh">
      <v-layout row wrap style="margin-left:6vh; ">
        <span style="color:black; font-size:36px; ">Cadastro de Turmas</span>
      </v-layout>

      <v-layout row wrap style="margin-left: 5vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Nome da Turma:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="turma.nome"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="text"
            class="form-control"
          />
        </v-flex>

        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Periodo:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="turma.periodo"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="text"
            class="form-control"
          />
        </v-flex>
      </v-layout>
      <v-layout row wrap style="margin-left: 117vh;">
        <v-flex xs3 sm3>
          <v-btn
            type="submit"
            style="height:5vh; width:40vh; color:black; border-radius: 5px;"
            @click.prevent.stop="cadastrar"
            color="#92b7ef"
          >Cadastrar Turma</v-btn>
        </v-flex>
      </v-layout>
    </v-card>
  </section>
</template>
<script>
import axios from "../axios/client.js";
import Vue from "vue";

export default {
  data() {
    return {
      view: 0,
      dialog: false,
      dialog2: false,
      visible: false,
      enabledSave: true,
      items: [],
      model: null,
      selected: [],
      show: false,
      event: null,
      id: "",
      snackbar: false,
      color: "",
      mode: "",
      y: "",
      x: "",
      headers: [
        { text: "Nome", align: "center;", sortable: false },
        { text: "Matricula", align: "center;", sortable: false }
      ],
      itens: [],
      textoAlerta: "",
      nomeCampo: "",
      cor: "",
      turma: {
        nome: "",
        periodo: "",
        alunos: {
          id: "",
          nome: ""
        }
      }
    };
  },

  methods: {
    listaAlunos: function() {
      axios.get("/listaalunos").then(response => {
        console.log(response.data);
        this.itens = response.data;
        for (let i = 0; i < this.itens.length; i++) {
          this.itens[i].id = i;
          this.itens[i].marcado = false;
        }
      });
    },
    novaMeta: function() {
      this.dialog = true;
      this.listaAlunos();
    },

    cadastrar: function() {
      axios
        .post("/usuario", this.usuario)
        .then(response => {
          if (response.data !== false) {
            this.cor = "green";
            this.snackbar = true;
            this.nomeCampo = "";
            this.textoAlerta = "Usuário cadastrado com sucesso";
            this.$router.push({ name: "login" });
          } else {
            this.cor = "red";
            this.snackbar = true;
            this.nomeCampo = "";
            this.textoAlerta = "Esse Usuário já existe";
            return;
          }
        })

        .catch(e => {
          console.log(e);
        });
    }
  }
};
</script>
<style scoped>
</style>


