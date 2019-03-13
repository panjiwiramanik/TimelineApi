<template>
   <div id="signin">
      <v-layout align-center justify-center class="min-a py-4">
          <v-snackbar
            v-model="snackbar"
            :multi-line=true
            :timeout=3000
            :top=true
            :vertical=true
          >
            {{ text }}
            <v-btn
              color="white"
              flat
              @click="snackbar = false"
            >
              Close
            </v-btn>
          </v-snackbar>
         <v-card class="transparent elevation-3 mx-auto" width="375" max-width="85%">
            <v-card-title class="wrap blue darken-2 white--text">
               <v-flex xs5 sm4 class="text-xs-center pa-1">
                  <p>Diary Timeline</p>
               </v-flex>
               <v-flex xs7 sm8 class="pa-2">
                  <h3 class="trueno-extra fs-30">Sign In</h3>
                  <p class="hidden-xs-only">Login as a member for you to write diary!</p>
               </v-flex>
            </v-card-title>

            <v-tabs v-model="signOptions" grow>
               <v-tabs-slider color="grey"></v-tabs-slider>

               <v-tab v-for="option in options" :key="option">
                  {{ option }}
               </v-tab>
            </v-tabs>

            <v-card-text>
               <v-tabs-items v-model="signOptions">
                  <v-tab-item>
                     <v-form ref="form" @submit.prevent="login">
                        <v-layout wrap justify-center>
                           <v-flex xs11>
                              <v-text-field
                                v-model="form.username"
                                color="blue darken-2"
                                label="Username"
                                required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs11>
                              <v-text-field
                                v-model="form.password"
                                :append-icon="showp ? 'visibility' : 'visibility_off'"
                                @click:append="showp = !showp"
                                :type="showp ? 'text' : 'password'"
                                color="blue darken-2"
                                name="sign-pw"
                                label="Password"
                                counter
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs11 class="text-xs-center">
                              <v-btn dark flat class="blue darken-2 text-capitalize" type="submit">Sign In</v-btn>
                           </v-flex>
                        </v-layout>
                     </v-form>
                  </v-tab-item>
                  <v-tab-item>
                     <v-form ref="form" @submit.prevent="register">
                        <v-layout wrap justify-center>
                           <v-flex xs11>
                              <v-text-field
                                v-model="form.name"
                                color="blue darken-2"
                                label="Name"
                                required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs11>
                              <v-text-field
                                v-model="form.email"
                                color="blue darken-2"
                                label="E-mail"
                                required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs11>
                              <v-text-field
                                v-model="form.username"
                                color="blue darken-2"
                                label="Username"
                                required
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs11>
                              <v-text-field
                                 :append-icon="showp ? 'visibility' : 'visibility_off'"
                                 @click:append="showp = !showp"
                                 :type="showp ? 'text' : 'password'"
                                 color="blue darken-2"
                                 name="password"
                                 v-model="form.password"
                                 label="Password"
                                 counter
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs11>
                              <v-text-field
                                 :append-icon="showcp ? 'visibility' : 'visibility_off'"
                                 @click:append="showcp = !showcp"
                                 :type="showcp ? 'text' : 'password'"
                                 color="blue darken-2"
                                 name="confirmpassword"
                                 v-model="form.confirmpassword"
                                 label="Confirm Password"
                                 counter
                              ></v-text-field>
                           </v-flex>
                           <v-flex xs11 class="text-xs-center">
                              <v-btn dark flat class="blue darken-2 text-capitalize"  type="submit">Sign Up</v-btn>
                           </v-flex>
                        </v-layout>
                     </v-form>
                  </v-tab-item>
               </v-tabs-items>
            </v-card-text>

         </v-card>
      </v-layout>
   </div>
</template>

<script>
  import axios from 'axios'

  export default {
    data() {
      return {
        showp: false,
        showcp: false,
        signOptions: null,
        options: [
          'Sign In', 'Sign Up'
        ],
        snackbar: false,
        text: '',
        form: {
          name: null,
          email: null,
          username: null,
          password: null,
          confirmpassword: null
        }
      }
    },
    methods: {
      login() {
        let data = this.form
        let url = 'https://timelineapi.derazu.tech/user/login/'

        if (this.form.username == null && this.form.password == null) {
          this.text = 'All field must have value!'
          this.snackbar = true
        } else {
          axios.post(url, data).then((res) => {
            if(res.data.status === 'success') {
              localStorage.setItem('auth', true)
              localStorage.setItem('id', res.data.result[0].id)
              localStorage.setItem('name', res.data.result[0].name)
              localStorage.setItem('email', res.data.result[0].email)
              localStorage.setItem('username', res.data.result[0].username)
              this.$router.push({name: 'home'})
            }
          }).catch(() => {
            this.text = 'Login Fail!'
            this.snackbar = true
          })
          this.snackbar = false
        }
      },
      register() {
        let data = this.form
        let url = 'https://timelineapi.derazu.tech/user/'

        if (this.form.name == null && this.form.username == null && this.form.email == null && this.form.password == null && this.form.confirmpassword == null) {
          this.text = 'All field must have value!'
          this.snackbar = true
        } else {
          if (this.form.password != this.form.confirmpassword) {
            this.text = 'Password must have same value with confirm password!'
            this.snackbar = true
          } else {
            axios.post(url, data).then((res) => {
              if(res.data.status === 'success') {
                this.text = 'Register Success! Please login now!'
                this.snackbar = true
              }
            }).catch(() => {
              this.text = 'Register Fail!'
              this.snackbar = true
            })
            this.snackbar = false
          }
        }
      }
    }
  }
</script>