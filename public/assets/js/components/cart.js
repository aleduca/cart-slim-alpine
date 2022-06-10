import http from '../services/http';
import currency from '../services/currency';

export default function cart(){
  return {
    productsInCart:[],

    getProducts: function(){
      this.productsInCart = JSON.parse(localStorage.getItem('cart'));
    },
      
    add: async function(productId){
      try {
        const {data} = await http.post('/cart/add', {productId});
        localStorage.setItem('cart', JSON.stringify(data));
        this.productsInCart = data;
      } catch (error) {
        console.log(error); 
      }
    },

    inCart: function(productId){
      let cart = [];

      if(this.productsInCart){
        cart = Object.keys(this.productsInCart).map(p => +p);
      }

      return cart.includes(productId);
    },

    subtotal: function(productId, price){
      const quantity = this.productsInCart[productId];
      return `x ${quantity} = ${currency('pt-BR', 'BRL', quantity * price)}`;
    },

    remove: async function(productId){
      try{
        const {data} = await http.get('/cart/remove', {
          params:{
            productId
          }
        });
        localStorage.setItem('cart', JSON.stringify(data));
        this.productsInCart = data;
      }catch(error){
        console.log(error);
      }
    },

    clear: async function(){
      const {data} = await http.post('/cart/clear'); 
      localStorage.setItem('cart', JSON.stringify(data));
      this.productsInCart = data;
    }
  };
}