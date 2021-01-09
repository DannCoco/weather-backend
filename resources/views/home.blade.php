@extends('layouts.app')

@section('content')
    <v-main>
        <v-container fluid fill-height class="pa-0">
            <v-layout>
                <v-fade-transition fluid fill-height mode="out-in">
                    <router-view></router-view>
                </v-fade-transition>
            </v-layout>
        </v-container>
    </v-main>
    @include('layouts.theme.menu')
@endsection
