<template>
  <v-app>
    <v-navigation-drawer
    fixed
    :mini-variant="miniVariant"
    clipped
    v-model="drawer"
    width="200"
    app
    >
    <my-nav></my-nav>
  </v-navigation-drawer>
  <v-toolbar fixed app clipped-left>
    <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
    <v-btn icon @click.stop="miniVariant = !miniVariant">
      <v-icon v-html="miniVariant ? 'chevron_right' : 'chevron_left'"></v-icon>
    </v-btn>
    <v-toolbar-title v-text="title"></v-toolbar-title>
    <v-spacer></v-spacer>
    <slot name="userControl"></slot>
  </v-toolbar>
  <v-content>
    <v-container fluid>
      <v-slide-y-transition mode="out-in">
        
          <router-view>
          </router-view>
          <slot></slot>
      
      </v-slide-y-transition>
    </v-container>
  </v-content>

  <v-footer fixed  app>
    <span>&copy; 2018</span>
  </v-footer>
</v-app>
</template>

<script>
  import myNav from "./partials/myNav.vue";
  export default {
    components: {
      myNav
    },
    
    data () {
      return {
        drawer: true,
        miniVariant: false,
        title: 'MrBmj Admin'
      }
    },
  }
</script>
