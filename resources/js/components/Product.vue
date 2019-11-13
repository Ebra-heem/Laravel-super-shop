<template>
    <div class="container">
        
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Products Table</h3>

                <div class="card-tools">
                 <button class="btn btn-success"  @click="newModal">  Add New <i class="fas fa-user-plus"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Price</th>
                    <th>SKU</th>
                    <th>Unit</th>
                    <th>Details</th>
                    
                    <th>Registered At</th>
                    <th>Action</th>
                  </tr>
                  <tr v-for="product in products" :key="product.id">
                    <td>{{product.id}}</td>
                    <td>{{product.p_name}}</td>
                    <td>{{product.p_code}}</td>
                    <td>{{product.p_price }}</td>
                    <td>{{product.p_sku }}</td>
                    <td>{{product.p_unit }}</td>
                    <td>{{product.p_detail }}</td>
                    <td>{{product.created_at | myDate}}</td>
                    <td>
                        <a href="#" @click="editModal(product)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click = "deleteUser(product.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                        <a href="#" @click = "uploadPhoto(product.id)">
                            <i class="fa fa-eye green"></i>
                        </a>
                    </td>
                  </tr>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        
<!-- Add Product Modal-->

<div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-show="!editMode" id="exampleModalLabel">Add New</h5>
        <h5 class="modal-title" v-show="editMode" id="exampleModalLabel" >Update   {{form.p_name}}'s Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editMode? updateModal():createProduct()">
      <div class="modal-body">
        <div class="form-group">
      <input v-model="form.p_name" type="text" name="p_name"
        placeholder="Product Name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('p_name') }">
      <has-error :form="form" field="p_name"></has-error>
        </div>
        <div class="form-group">
      <input v-model="form.p_code" type="text" name="p_code"
        placeholder="Product Code"
        class="form-control" :class="{ 'is-invalid': form.errors.has('p_code') }">
      <has-error :form="form" field="p_code"></has-error>
        </div>
        <div class="form-group">
      <input v-model="form.p_price" type="text" name="p_price"
        placeholder="Product Price"
        class="form-control" :class="{ 'is-invalid': form.errors.has('p_price') }">
      <has-error :form="form" field="p_price"></has-error>
        </div>

        <div class="form-group">
      <input v-model="form.p_sku" type="text" name="p_sku"
        placeholder="SKU"
        class="form-control" :class="{ 'is-invalid': form.errors.has('p_sku') }">
      <has-error :form="form" field="p_sku"></has-error>
        </div>

        <div class="form-group">
      <select v-model="form.p_unit" type="text" name="p_unit"
        class="form-control" :class="{ 'is-invalid': form.errors.has('p_unit') }">
        <option value=""> Select Unit</option>
        <option value="kg"> Kg</option>
        <option value="litter"> Litter</option>
        <option value="pack"> Pack</option>
        </select>
      <has-error :form="form" field="p_unit"></has-error>
        </div>

        <div class="form-group">
      <textarea v-model="form.p_detail" type="text" name="p_detail"
        placeholder="Short detail for product(Optional)"
        class="form-control" :class="{ 'is-invalid': form.errors.has('p_detail') }"></textarea>
      <has-error :form="form" field="p_detail"></has-error>
        </div>
        <div class="form-group">
      <select v-model="form.p_status" type="text" name="p_status"
        class="form-control" :class="{ 'is-invalid': form.errors.has('p_status') }">
        <option value=""> Select Status</option>
        <option value="1"> Active</option>
        <option value="0">Inactive</option>
        </select>
      <has-error :form="form" field="p_status"></has-error>
        </div>
        
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button v-show="editMode" type="submit" class="btn btn-success">Update </button>
        <button v-show="!editMode" type="submit" class="btn btn-primary">Create </button>
      </div>

      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="addImg" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editMode? updateModal():createProduct()">
      <div class="modal-body">
        <div class="form-group">
          <div class="widget-user-image">
                <img class="img-circle" :src="getProductPhoto()" alt="User Avatar">
            </div>
            
              <div class="col-sm-12">
                <input type="file" @change="updateProfile" name="p_photo" class="form-input">
                 </div>

         </div>
        
        
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button  type="submit" class="btn btn-success">Upload </button>
      </div>

      </form>

    </div>
  </div>
</div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                editMode: false,
                products : {},
                form: new Form({
                    id:'',
                    p_name: '',
                    p_code: '',
                    p_price: '',
                    p_sku: '',
                    p_unit: '',
                    p_photo: '',
                    p_detail: '',
                    p_status: ''
                })
            }
        },
        methods:{
          updateProfile(e){
               // console.log('uploading');
               //take the file from input fields
               let file = e.target.files[0];
              // console.log(file);
               let reader = new FileReader();
              //check file size is not max 2 MB
               if(file['size'] < 2111775){
                 reader.onloadend = (file)=>{
                  // console.log('Result',reader.result)
                  this.form.photo = reader.result;
               }
                  reader.readAsDataURL(file);
               }else{
                 Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    })
               }
               
        },
          uploadPhoto(){
            $('#addImg').modal('show');

          },
           getProductPhoto(){
             let photo = (this.form.p_photo.length >200)? this.form.p_photo :"img/profile/"+this.form.p_photo ;
             // return "img/profile/"+this.form.photo;
            // this.form.photo='';
             return photo;
           },
          updateModal(){
            //console.log("Update Data");
            this.$Progress.start();
            this.form.put('api/product/'+this.form.id)
            .then( ()=>{

              this.$emit('AfterCreate');
                $('#addNew').modal('hide');
                
                Toast.fire({
                type: 'success',
                title: 'Product Updated  successfully'
                })
                 this.$Progress.finish();

            })
            .catch(()=>{
              this.$Progress.fail();
            })
          },
          editModal(product){
            this.editMode = true;
            this.form.reset();
             $('#addNew').modal('show');
             this.form.fill(product);
          },
          newModal(){
             this.editMode = false;
            this.form.reset();
             $('#addNew').modal('show');
          },
            deleteUser(id){
              Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                //send request to server
                this.form.delete('api/product/'+id).then( ()=>{
                   this.$emit('AfterCreate');
                  Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                  )
                
                }).catch(()=>{
                  console.log('error from delete');
                })
                }
               
              })
            },


            loadProducts(){
                axios.get("api/product").then(({ data })=>(this.products = data.data));
            },
            createProduct(){

                 this.$Progress.start();
                this.form.post('api/product')
                .then( ()=>{
                    this.$emit('AfterCreate');
                $('#addNew').modal('hide');
                
                Toast.fire({
                type: 'success',
                title: 'Product Created in successfully'
                })
                 this.$Progress.finish();
                })
                .catch( ()=>{
                    console.log('error from product component');
                })
                
            }
        },
        created() {
            this.loadProducts();
           
            this.$on('AfterCreate',() => { 
                this.loadProducts();
             });
              //setInterval( () => this.loadProducts(),3000);
        }
    }
</script>
