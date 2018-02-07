@extends('layouts.app')

@section('content')
<v-container fluid fill-height>
            <v-layout row wrap align-center justify-center>
                <v-flex md4 xs10>
                    <v-card>
                        <v-toolbar dark color="primary">
                            <v-toolbar-title>Register</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <v-card-text>
                        <v-text-field
                            label="Name"
                            type="text"
                            placeholder=""
                            value="{{ old('name') }}"
                            name="name"
                            required
                           
                            ref="name"
                        ></v-text-field>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif

                        <v-text-field
                            label="Email"
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required>
                        </v-text-field>
                        @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif

                        <v-text-field 
                            label="Password"
                            id="password"
                            type="password"
                            name="password"
                            required
                            >
                        </v-text-field>
                         @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif

                        <v-text-field
                            label="Confirm Password"
                            id="password-confirm"
                            type="password"
                            name="password_confirmation"
                            required
                            >
                        </v-text-field>

                        </v-card-text> 
                        <v-card-actions>

                            <v-btn 
                                color="primary"
                                type="submit"
                            >
                            Register
                            </v-btn>
                        </v-card-actions>
                    </form>
                </v-card>
                </v-flex>
            </v-layout>
        </v-container>
</div>
@endsection
