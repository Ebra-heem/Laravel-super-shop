<template>
              <div class="row">



                
                    <div v-for="(product,index) in products" :key="index" class="col-md-4">
                        <div class="card" style="width: 12rem;">
                          <img class="card-img-top" src="https://dummyimage.com/300.png/09f/fff" alt="Card image cap" height="100px">
                          <div class="card-body">
                            <h5 class="card-title">{{product.p_name}}-&#2547; {{product.p_price}}/-</h5>
                            <p v-if="product.p_sku>5" class="text-success">InStock-{{product.p_sku}}</p>
                            <p v-if="product.p_sku<5" class="text-danger">InStock-{{product.p_sku}}</p>
                            <p v-if="product.p_sku==5" class="text-danger">InStock-{{product.p_sku}}</p>
                            <button @click="addToCart(product)" :disabled="product.p_sku == 0" class="btn btn-primary">Add to cart</button>
                          </div>
                        </div>
                    </div>
            </div>
</template>

<script>
    export default {
        props: ['products'],
        methods:{
            addToCart(product){
                this.$emit('newItemAdded',product)
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
