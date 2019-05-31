import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex, axios);

export const store = new Vuex.Store({
    state: {
        cart:[]
    },
    getters:{
        getCart(state){
            return state.cart
        },
    },
    mutations:{
        add_to_cart(state, prod){
            state.cart.push(prod)
        },
        remove_item(state, prod){
          let i =  state.cart.map(item => item.id).indexOf(prod)
          state.cart.splice(i, 1)
          localStorage.setItem('cart', JSON.stringify(store.cart))
        //    var cart = state.cart.filter((item)=>
        //        item !== prod
        //     )
            // state.cart = cart
            // state.cart.splice(index, 1)
            console.log(state.cart)
        }
    },
    actions:{
        
    }
})