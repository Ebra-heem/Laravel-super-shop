<template>
    <div>
       <form @submit.prevent="InvoiceGen()">
        <div class="row justify-content-center">
            <div class="card" style="width: 100%">
                  <h2 class="text-center text-success">Shopping Cart</h2>
        <table v-if="cartItems.length > 0" class="table table-striped">
      <thead>
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item,index) in cartItems" :key="index">
          <td><button @click="removeItemFromCart(item)" class="btn btn-sm"><i class="fa fa-trash red"></i></button>  {{item.product.p_name}}</td>
          <td>
            <button class="btn btn-sm btn-danger" @click="decreaseQuantity(item)">-</button>
            &nbsp; {{item.quantity}} &nbsp;
            <button class="btn btn-sm btn-success" @click="increaseQuantity(item)" >+</button>
          </td>
          <td>&#2547;-{{item.quantity*item.product.p_price}}/-</td>
        </tr>
        
        <tr>
          <td class="text-right" colspan="2">
            <strong>Total Price:</strong>
          </td>
          
          <td>&#2547; {{totalPrice}}/-</td>
        </tr>
        
        <tr>
          <td class="text-right" >
            <strong>Paid:</strong>
          </td>
          
          <td colspan="2" class="text-right"><input class="form-control" type="text"  v-model="form.paid" /></td>
        </tr>
        
        <tr>
          <td class="text-right" >
            <strong>Change:</strong>
          </td>
          
          <td colspan="2" class="text-right">&#2547;-({{change}})/-</td>
        </tr>
        
        <tr>
          <td class="text-right"><strong>Due:</strong></td>
          <td colspan="2" class="text-right">{{duePrice}}</td>
        </tr>
        <tr>
          <td >Select Customer</td>
          <td colspan="2">
            <div class="form-group">
      <select  type="text" class="form-control select2" v-model="form.customer" >
        <option v-for="customer in customers" :key="customer.id" :value="customer.id"> {{customer.name}}</option>
        </select>
      
        </div>
          </td>
        </tr>
        <tr>
          <td ></td>
          <td colspan="2"><button type="submit" class="btn btn-primary">Order Placed</button></td>
        </tr>
      </tbody>
    </table>
    
    <p v-else class="text-center text-danger">Your cart is currently empty.</p>
            </div>
        </div>
    </form>
    </div>
</template>

<script>
    export default {
        props: ['cartItems'],
        data(){
            return{

                customers:{},
                form: new Form({
                    paid:'',
                    due:'',
                    customer:'',
                    cartItems:{}
                })
            }
        },
        
        computed:{
            totalPrice(){
                var total = 0;
                this.cartItems.forEach(item=>{
                    total+= item.quantity*parseFloat(item.product.p_price);
                })
                return total;
            },
            change(){
                return this.form.paid-this.totalPrice;
            },
            duePrice(){
              if(this.form.paid>=this.totalPrice){
                return 0;
              }
              return this.totalPrice-this.form.paid;
            }
        },
        methods:{
            removeItemFromCart(index){
                this.$emit('removeItem',index)
            },
              increaseQuantity: function(index) {
                  index.product.p_sku--;
                  index.quantity++;
                },
            decreaseQuantity: function(index) {
                 index.quantity--;
             index.product.p_sku++;
              if (index.quantity == 0) {
                //this.removeItemFromCart(item);
                this.$emit('removeItem',index)
                  }
            },
             loadCustomers(){
                axios.get("api/customer").then(({ data })=>(this.customers = data.data));
            },
            InvoiceGen(){

              console.log(this.form.cartItems)
            }
        },
        mounted() {
            this.loadCustomers();
        }
    }
</script>
