import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex, axios);

export const store = new Vuex.Store({
    state: {
        newStock:{}
    },
    getters:{

    },
    mutations:{
        addStock(state, prod){
            state.newStock = prod
        }
    },
    actions:{
        
    }
})