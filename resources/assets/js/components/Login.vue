<template>
	<v-card>
                        <v-toolbar color="info">
                            <v-toolbar-title>Login</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card-text>
                        <v-form class="form-horizontal" method="POST" >
                        <v-text-field
                            label="E-mail"
                            type="email"
                            placeholder="Your E-mail Address"
                            name="email"
                            required
                            ref="name"
                        ></v-text-field>
                        
                        <v-text-field
                            label="Password"
                            type="password"
                            name="password"
                            required
                        
                            ref="password"
                        ></v-text-field>
                        
                           

                        <v-card-actions>
                              <v-spacer></v-spacer>
                                <v-btn type="submit">
                                    Login
                                </v-btn>
                        </v-card-actions>
                        </v-form>
                        </v-card-text>
                    </v-card>
</template>