<template>
  <header>
    <v-card-title class="blue white--text">
      <v-menu offset-y>
        <template v-slot:activator="{ on }">
          <v-btn dark icon v-on="on">
            <v-icon style="color:white; font-size:35px;">dehaze</v-icon>
          </v-btn>
        </template>

        <v-list>
          <v-list-tile v-for="(item, i) in items" :key="i">
            <v-list-tile-title>
              <router-link
                :to="item.path"
                v-if="item.title != 'Sair'"
                style="color:black; text-decoration:none;"
              >{{ item.title }}</router-link>
              <span v-else-if="item.title == 'Sair'" @click="sair" style="cursor: pointer;">Sair</span>
            </v-list-tile-title>
          </v-list-tile>
        </v-list>
      </v-menu>
      <span style=" font-weight: bold; margin-left:75vh" class="headline">Peer Review Edition</span>
      <span style="margin-left:75vh">
        <i id="iconUser" class="material-icons">account_circle</i>
      </span>
      <label>
        <p style="margin-top:13px;margin-left:3px; font-weight: bold;">Olá, {{usuario}}!</p>
      </label>
    </v-card-title>
  </header>
</template>
<script>
export default {
  data() {
    return {
      items: [
       { title: "Atividades", path: "/" },       
       { title: "Turmas", path: "/listaturma" },
       { title: "Sair", path: "" }
      ],
      usuario: "",
      nivel: 0
    };
  },
  methods: {
    sair: function() {
      this.$emit("saiu");
    }
  },

  created: function() {
    this.usuario = JSON.parse(sessionStorage.getItem("contas_login"));
    console.log(this.usuario);

    this.usuario = this.usuario[0].nome;
  }
};
</script>

<style>
#iconInput {
  color: white;
  margin-top: 8px;
  margin-right: 20px;
}
#iconUser {
  color: white;
  margin-top: 3px;
}
#barraVertical {
  color: white;
  padding: 15px;
  font-size: 20px;
  margin-top: 13px;
}
</style>