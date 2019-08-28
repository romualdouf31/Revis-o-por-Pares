<template>
  <section class="content" data-app>
    <v-dialog v-model="dialog" persistent max-width="120vh">
      <v-card>
        <v-card-title class="headline">Lista de Alunos</v-card-title>

        <v-card-text>
          <v-data-table
            :headers="headers"
            hide-details
            :items="itens"
            class="elevation-1"
            hide-actions
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
    <v-card style="margin-left: 30vh; margin-top: 15vh; margin-right: 30vh">
      <v-layout row wrap style="margin-left:46vh; ">
        <span style="color:black; font-size:46px; ">Formulário de Avaliação</span>
      </v-layout>

      <v-layout row wrap style="margin-left: 40vh; padding: 16px 0;">
        <v-flex xs3 sm2 style="margin-top: 2vh; text-align: right">
          <label>Nome do Formulário:</label>
        </v-flex>
        <v-flex xs3 sm3>
          <input
            v-model="formulario.nome"
            style=" cursor: pointer; border: 2px solid DimGray; border-radius: 5px;  height: 39px; width: 40vh;"
            type="text"
            class="form-control"
          />
        </v-flex>
        <v-spacer></v-spacer>

        <v-flex xs3 sm11 style="margin-left:20vh">
          <v-btn color="#006DB5" fab dark>
            <v-icon @click.prevent.stop="novaMeta">person_add</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
      <v-layout row wrap style="margin-left: 57vh;">
        <v-flex xs3 sm3>
          <v-btn
            type="submit"
            style="height:5vh; width:40vh; border-radius: 5px;"
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

    validacaoRequiredField: function() {
      if (this.usuario.tipo === null || this.usuario.tipo === "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }

      if (this.usuario.nome === null || this.usuario.nome === "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }

      if (this.usuario.matricula === null || this.usuario.matricula === "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }
      if (
        this.usuario.universidade === null ||
        this.usuario.universidade === ""
      ) {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }
      if (this.usuario.senha === null || this.usuario.senha === "") {
        this.cor = "red";
        this.snackbar = true;
        this.nomeCampo = "";
        this.textoAlerta = "Peencha os campos obrigatorios";
        return true;
      }
    },
    cadastrar: function() {
      if (!this.validacaoRequiredField()) {
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
  }
};
</script>
<style scoped>
</style>