<template>
    <div class="container-fluid">
        <div class="row">
            <!-- <navbar @search="search"></navbar> -->
            <div class="col-md-12">
            <nav class="navbar navbar-dark bg-dark justify-content-between mb-2">
                  <a class="navbar-brand">Super Shop</a>
                  <form @submit.prevent="search" class="form-inline">
                    <input class="form-control mr-sm-2" @keyup="search" v-model="keyword" type="text" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                  </form>
                </nav>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <inventory @newItemAdded="addCartItem" :products="filteredProducts"></inventory>
                
            </div>

            <div class="col-md-4">
                <cart @removeItem="removeCartItem" :cartItems="cart.items"></cart>
            </div>

        </div>
  
    </div>
</template>

<script>
    import Cart from './Cart';
    import Inventory from './Inventory';
    import Navbar from './Navbar';
   
    export default {
        components:{
            Cart,Inventory,Navbar
        },
        data(){
            return{
                keyword:'',
                products:[],
                cart:{
                    items:[]
                }
            }
        },
        computed:{
            filteredProducts:function(){
                return this.products.filter((product)=>{
                    return product.p_name.match(this.keyword)
                })
            }
        },
        methods:{
            
            search(keyword){
                // this.products = this.products.filter(product =>{
                //     return product.p_name.toLowerCase().indexOf(keyword.toLowerCase()) !== -1
                // })
                this.filteredProducts();
            },
            addCartItem(product){

                var cartItem = this.getCartItem(product);
      //console.log(cartItem);
                  if (cartItem != null) {
                    cartItem.quantity++;
                  } else {
                    this.cart.items.push({
                      product: product,
                      quantity: 1
                    });

                  }
                  product.p_sku--;
            },
            getCartItem: function(product) {
              for (var i = 0; i < this.cart.items.length; i++) {
                if (this.cart.items[i].product.id === product.id) {
                  return this.cart.items[i];
                }
              }
              
              return null;
            },
            removeCartItem(index){
                var index = this.cart.items.indexOf(index);
                 if (index !== -1) {
                    this.cart.items.splice(index, 1);
                  }
            }
        },

        mounted() {
            axios.get("api/product").then(({ data })=>(this.products = data.data));
            
        }
    }
</script>
