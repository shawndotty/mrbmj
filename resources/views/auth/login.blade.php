@extends('layouts.app')

@section('content')
        <v-container fluid fill-height>
            <v-layout row wrap align-center justify-center>
                <v-flex md4 xs10>
                    <v-card>
                        <v-toolbar dark color="primary">
                            <v-toolbar-title>Login</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                        <v-card-text>
                        <v-form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <v-text-field
                            label="E-mail"
                            type="email"
                            placeholder="Your E-mail Address"
                            value="{{ old('email') }}"
                            name="email"
                            required
                           
                            ref="name"
                        ></v-text-field>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        <v-text-field
                            label="Password"
                            type="password"
                            name="password"
                            required
                        
                            ref="password"
                        ></v-text-field>
                        @if ($errors->has('password'))
                                    
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                           

                        <v-card-actions>
                              <v-spacer></v-spacer>
                                <v-btn type="submit">
                                    Login
                                </v-btn>
                        </v-card-actions>
                        </v-form>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
@endsection
